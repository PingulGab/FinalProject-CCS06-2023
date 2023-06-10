<?php

session_start();

include('model/connector.php');

if (isset($_SESSION['is_logged_in'])) {
  if ($_SESSION['is_logged_in']) {
    header('Location: index.php');
    exit();
  }
}

if (isset($_POST['loginButton'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $getUser = $conn->prepare("SELECT user_id, user_email, user_password FROM users WHERE user_email=? LIMIT 1");

  $getUser->bind_param('s', $email);

  if ($getUser->execute()) {
    $getUser->bind_result($user_id, $user_email, $user_password);
    $getUser->store_result();

    if ($getUser->num_rows() == 1) {
      $row = $getUser->fetch();

      if (password_verify($password, $user_password)) {

        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $user_id;

        header('Location: index.php?message=LoggedIn');
        exit();
      } else {

        echo "<script> alert('Invalid Credentials'); </script>";
      }
    } else {

      echo "<script> alert('Invalid Credentials'); </script>";
    }
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Item Description</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="resources/css/Style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <!-- Navigation Bar Code -->
  <?php
  include('navbar_loggedout.php');
  ?>

  <section class="loginSection" id="loginBG">

    <div class="loginContainer text-center">
      <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
      <form action="login.php" method="POST">

        <div class="mt-2">
          <label>Email Address</label>
          <input type="email" name="email" />
        </div>

        <div class="mt-2">
          <label>Password</label>
          <input type="password" name="password" />
        </div>

        <div class="container-fluid display:flex mt-3">
          <button type="submit" name="loginButton"> Login </button>
          <a href="register.php"> <button type="text"> Register </a>
        </div>
      </form>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>