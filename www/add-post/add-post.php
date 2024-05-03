<?php
// Include the user session utility file
include_once __DIR__ . "/../../utils/user_session.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the user is connected, if not send a 403 Forbidden response and exit
    if (!UserSession::is_connected()) {
        http_response_code(403);
        exit();
    }

    // Include the posts utility file
    include_once __DIR__ . "/../../utils/posts.php";

    // Retrieve the POST data and assign it to variables
    [$title, $description, $price, $performance, $specs] = [
        $_POST["title"],
        $_POST["description"],
        $_POST["price"],
        $_POST["performance"],
        $_POST["specs"]
    ];

    // Check if all required fields are set, if not send a 400 Bad Request response and exit
    if (!isset($title, $description, $price, $performance, $specs)) {
        http_response_code(400);
        exit();
    }

    // Retrieve the uploaded image files
    $files = $_FILES["image"];

    // Check if files are set, if not send a 400 Bad Request response and exit
    if (!isset($files)) {
        http_response_code(400);
        exit();
    }

    // Check if the number of uploaded files is within the allowed range (1-10), if not send a 400 Bad Request response and exit
    if (count($files) > 10 || count($files) < 1) {
        http_response_code(400);
        exit();
    }

    // Check if there are any errors with the uploaded files, if so send a 400 Bad Request response and exit
    foreach ($files["error"] as $error) {
        if ($error !== 0) {
            http_response_code(400);
            exit();
        }
    }

    // Check if the size of any uploaded file exceeds the maximum allowed size (1MB), if so send a 400 Bad Request response and exit
    foreach ($files["size"] as $size) {
        if ($size > 1000000) {
            http_response_code(400);
            exit();
        }
    }

    // Check if the type of any uploaded file is not "image/webp", if so send a 400 Bad Request response and exit
    foreach ($files["type"] as $type) {
        if (!in_array($type, ["image/webp"])) {
            http_response_code(400);
            exit();
        }
    }

    // format the title and description fields with htmlspecialchars()
    $title = htmlspecialchars($title);
    $description = htmlspecialchars($description);

    // Convert the price and performance fields to integers
    $price = intval($price);
    $performance = intval($performance);

    // Check if the price is a valid integer within the allowed range (0-20000), if not send a 400 Bad Request response and exit
    if (!is_int($price) || $price < 0 || $price > 20000) {
        http_response_code(400);
        exit();
    }

    // Check if the performance is a valid integer within the allowed range (0-999), if not send a 400 Bad Request response and exit
    if (!is_int($performance) || $performance < 0 || $performance > 999) {
        http_response_code(400);
        exit();
    }

    // Check if the title and description fields are within the allowed length (1-100 for title, 1-1000 for description), if not send a 400 Bad Request response and exit
    if (strlen($title) < 1 || strlen($title) > 100) {
        http_response_code(400);
        exit();
    }
    if (strlen($description) < 1 || strlen($description) > 1000) {
        http_response_code(400);
        exit();
    }

    // Decode the specs JSON string into an associative array
    $specs = json_decode($specs, true);

    // Retrieve the individual spec fields from the decoded array and assign them to variables
    [$cpu, $gpu, $motherboard, $ram, $psu, $storage, $case] = [
        $specs["cpu"],
        $specs["gpu"],
        $specs["motherboard"],
        $specs["ram"],
        $specs["psu"],
        $specs["storage"],
        $specs["case"]
    ];

    // Check if all required spec fields are set, if not send a 400 Bad Request response and exit
    if (!isset($cpu, $gpu, $motherboard, $ram, $psu, $storage, $case)) {
        http_response_code(400);
        exit();
    }

    // Check if the storage field is an array, if not send a 400 Bad Request response and exit
    if (!is_array($storage)) {
        http_response_code(400);
        exit();
    }

    // Check if the number of storage devices exceeds the maximum allowed (5), if so send a 400 Bad Request response and exit
    if (count($storage) > 5) {
        http_response_code(400);
        exit();
    }

    // Format the individual spec fields with htmlspecialchars()
    $cpu = htmlspecialchars($cpu);
    $gpu = htmlspecialchars($gpu);
    $motherboard = htmlspecialchars($motherboard);
    $ram = htmlspecialchars($ram);
    $psu = htmlspecialchars($psu);
    $case = htmlspecialchars($case);

    // Loop through the storage array and format each element with htmlspecialchars()
    foreach ($storage as $i => $st) {
        if (!isset($st)) {
            http_response_code(400);
            exit();
        }
        if (!is_integer($i)) {
            http_response_code(400);
            exit();
        }
        $st = htmlspecialchars($st);
        $storage[$i] = $st;
    }

    // Check if any of the spec fields are not strings or exceed the maximum allowed length (200), if so send a 400 Bad Request response and exit
    foreach ([$cpu, $gpu, $motherboard, $ram, $psu, ...$storage, $case] as $spec) {
        if (!is_string($spec)) {
            http_response_code(400);
            exit();
        }
        if (strlen($spec) < 1 || strlen($spec) > 200) {
            http_response_code(400);
            exit();
        }
    }

    // Re-encode the formatd spec fields into a JSON string
    $sspecs = json_encode([
        "cpu" => $cpu,
        "gpu" => $gpu,
        "motherboard" => $motherboard,
        "ram" => $ram,
        "psu" => $psu,
        "storage" => $storage,
        "case" => $case
    ]);

    // Retrieve the user ID from the session
    $user = $_SESSION["user_id"];

    // Generate a random rating for the post
    $rating = rand(0, 100) / 10;

    // Add the post to the database using the add_post() function from the posts utility file, passing in the user ID, title, description, price, performance, rating, specs, and image files
    $return_url = Posts::add_post($user, $title, $description, $price, $performance, $rating, $sspecs, $files);

    // Check if the add_post() function returned a URL, if not send a 500 Internal Server Error response and exit
    if (!isset($return_url)) {
        http_response_code(500);
        exit();
    }

    // Send a 200 OK response with the URL of the new post
    http_response_code(200);
    echo $return_url;
    exit();
}
