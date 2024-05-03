<?php include_once __DIR__ . "/../../utils/user_session.php" ?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!UserSession::is_connected()) {
        http_response_code(403);
        exit();
    }
    include_once __DIR__ . "/../../utils/posts.php";

    [$title, $description, $price, $performance, $specs] = [
        $_POST["title"],
        $_POST["description"],
        $_POST["price"],
        $_POST["performance"],
        $_POST["specs"]
    ];

    if (!isset($title, $description, $price, $performance, $specs)) {
        http_response_code(400);
        exit();
    }
    $files = $_FILES["image"];
    if (!isset($files)) {
        http_response_code(400);
        exit();
    }
    if (count($files) > 10) {
        http_response_code(400);
        exit();
    }
    if (count($files) < 1) {
        http_response_code(400);
        exit();
    }
    foreach ($files["error"] as $error) {
        if ($error !== 0) {
            http_response_code(400);
            exit();
        }
    }
    foreach ($files["size"] as $size) {
        if ($size > 1000000) {
            http_response_code(400);
            exit();
        }
    }
    foreach ($files["type"] as $type) {
        if (!in_array($type, ["image/webp"])) {
            http_response_code(400);
            exit();
        }
    }

    $title = htmlspecialchars($title);
    $description = htmlspecialchars($description);
    $price = intval($price);
    $performance = intval($performance);
    if (!is_int($price) || $price < 0 || $price > 20000) {
        http_response_code(400);
        exit();
    }

    if (!is_int($performance) || $performance < 0 || $performance > 999) {
        http_response_code(400);
        exit();
    }
    if (strlen($title) < 1 || strlen($title) > 100) {
        http_response_code(400);
        exit();
    }
    if (strlen($description) < 1 || strlen($description) > 1000) {
        http_response_code(400);
        exit();
    }

    $specs = json_decode($specs, true);
    [$cpu, $gpu, $motherboard, $ram, $psu, $storage, $case] = [
        $specs["cpu"],
        $specs["gpu"],
        $specs["motherboard"],
        $specs["ram"],
        $specs["psu"],
        $specs["storage"],
        $specs["case"]
    ];
    if (!isset($cpu, $gpu, $motherboard, $ram, $psu, $storage, $case)) {
        http_response_code(400);
        exit();
    }
    if (!is_array($storage)) {
        http_response_code(400);
        exit();
    }
    if (count($storage) > 5) {
        http_response_code(400);
        exit();
    }
    $cpu = htmlspecialchars($cpu);
    $gpu = htmlspecialchars($gpu);
    $motherboard = htmlspecialchars($motherboard);
    $ram = htmlspecialchars($ram);
    $psu = htmlspecialchars($psu);
    $case = htmlspecialchars($case);
    # Loop through indexes and replace string with sanitized
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

    $sspecs = json_encode([
        "cpu" => $cpu,
        "gpu" => $gpu,
        "motherboard" => $motherboard,
        "ram" => $ram,
        "psu" => $psu,
        "storage" => $storage,
        "case" => $case
    ]);

    $user = $_SESSION["user_id"];
    $rating = rand(0, 100) / 10;
    $return_url = Posts::add_post($user, $title, $description, $price, $performance, $rating, $sspecs, $files);
    if (!isset($return_url)) {
        http_response_code(500);
        exit();
    }
    http_response_code(200);
    echo $return_url;
    exit();
}
