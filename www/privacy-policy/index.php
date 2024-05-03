<?php
// Include the component for generating the card elements
include_once __DIR__ . "/../../components/cards/index.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php
// Define the CSS and JS files to be included in the head of the document
$styles = ["header.css", "info-text.css", "footer.css"];
$scripts = ["header.js"];

// Define the title of the document
$title = "Privacy Policy";

// Include the head component with the defined variables
include_once __DIR__ . "/../../components/head/head.php";
?>

<body>
  <?php
  // Include the header component
  include_once __DIR__ . "/../../components/header/header.php";
  ?>

  <main>
    <!-- Display the privacy policy -->
    <h1>
      <span class="material-symbols-rounded">
        policy
      </span>
      <span>Privacy Policy</span>
    </h1>

    <h2>Introduction</h2>

    <p>At Atlas Hardware, we are committed to protecting the privacy and security of our customers and site visitors.
      This Privacy Policy explains how we collect, use,
      and disclose your personal information when you visit our website or use our services.</p>

    <h2>Information We Collect</h2>

    <p>We may collect the following types of personal information from you:</p>

    <ul>
      <li>Nothing</li>
    </ul>

    <h2>How We Use Your Information</h2>

    <p>We may use your personal information for the following purposes:</p>

    <ul>
      <li>Nothing</li>
    </ul>

    <h2>How We Share Your Information</h2>

    <p>We may share your personal information with the following parties:</p>

    <ul>
      <li>Bin</li>
    </ul>

    <h2>Your Choices and Rights</h2>

    <p>You have certain choices and rights regarding your personal information, including:</p>

    <ul>
      <li>The right to access, update, or delete your personal information.</li>
      <li>The right to restrict or object to the processing of your personal information.</li>
    </ul>

    <p>To exercise these choices and rights, please contact us at <a href="mailto:atlashardware@exemple.com">atlashardware@exemple.com</a>.</p>

    <h2>Data Security</h2>

    <p>We take reasonable measures to protect your personal information from unauthorized access, disclosure, alteration, or destruction.
      However, no data transmission or storage system can be guaranteed to be 100% secure.</p>

    <h2>Changes to this Privacy Policy</h2>

    <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal obligations.
      We will post the updated version on our website and indicate the date of the last revision.</p>

    <h2>Contact Us</h2>

    <p>If you have any questions or concerns about this Privacy Policy or our practices,
      please contact us at <a href="mailto:atlashardware@exemple.com">atlashardware@exemple.com</a>.</p>

  </main>

  <?php
  // Include the footer component
  include_once __DIR__ . "/../../components/footer/footer.php";
  ?>

</body>

</html>
