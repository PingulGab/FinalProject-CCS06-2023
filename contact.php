<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="resources/css/Style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background-image: url('resources/images/contact_bg.png');">

  <!-- Navigation Bar Code -->
  <?php
  session_start();

  if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {

    include('navbar_loggedin.php');
  } else {

    include('navbar_loggedout.php');
  }
  ?>

  <!-- Contact Code -->
  <div class="contactInfo">
    <h3> OPENING HOURS </h3>
    <h4> Mon - Fri: 7am - 10pm </h4>
    <h4> Saturday: 8am - 10pm </h4>
    <h4> Sunday: 8am - 11pm</h4>

    <h3> LOCATION </h3>
    <h4> 123 Anywhere St. Any City, </h4>
    <h4> ST 12345 </h4>

    <h3> FOLLOW US ON </h3>
    <span>
      <i class="fa-brands fa-facebook fa-2xl me-5 mt-4" style="color: #ffffff;"></i>
      <i class="fa-brands fa-instagram fa-2xl me-5" style="color: #ffffff;"></i>
      <i class="fa-brands fa-twitter fa-2xl me-5" style="color: #ffffff;"></i>
    </span>
  </div>

  <div class="contactEmail">
    <h3>CustomerSupport@silogexpress.com</h3>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

</body>

</html>