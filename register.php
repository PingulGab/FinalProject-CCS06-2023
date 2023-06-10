<?php

include('model/register.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $email = $_POST["email"];
  $password = $_POST["password"];
  $first_name = $_POST["fName"];
  $last_name = $_POST["lName"];
  $confirm_password = $_POST["confirm_password"];

  if (strlen($first_name) < 3) {
    echo "<script> alert('First name must be at least 3 characters long.'); window.location.href='register.php'; </script>";
    exit;
  }

  if (strlen($password) < 7 || !preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/", $password)) {
    echo "<script> alert('Password must be at least 7 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.'); window.location.href='register.php';</script>";
    exit;
  }

  if ($password === $confirm_password) {

    if (Register::createUser($email, $password, $first_name, $last_name)) {
      echo
        "
            <script> alert('Registration Successful'); window.location.href='login.php?Message=RegisterSucces';</script>
            ";
    }
  } else {
    echo "Passwords do not match.";
  }
}
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="resources/css/Style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

  <?php
  include('navbar_loggedout.php');
  ?>

  <section class="registerSection">
    <div class="registerContainer">

      <form method="POST" action="">
        <p> FIRST NAME </p>
        <input type="text" name="fName" required>

        <p> LAST NAME </p>
        <input type="text" name="lName" required>

        <p> EMAIL ADDRESS </p>
        <input type="email" name="email" required>

        <p> PASSWORD </p>
        <input type="password" name="password" required>

        <P> CONFIRM PASSWORD </P>
        <input type="password" name="confirm_password" required>

        <br> <br>
        <div class="registerButton">
          <button class="LoginButtonReg" type="submit"> REGISTER </button>
        </div>

      </form>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>