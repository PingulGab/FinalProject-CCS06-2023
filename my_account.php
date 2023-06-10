<?php
include('model/connector.php');

$fullName = '';
$userEmail = '';
$verificationMessage = '';

$stmt = $conn->prepare("SELECT user_id, user_fname, user_lname, user_email, contact_number, user_password, address FROM Users");
$stmt->execute();

$result = $stmt->get_result();

$userDetails = $result->fetch_assoc();

if (isset($_POST['saveDetails'])) {
    $password = $_POST['password'];

    if (password_verify($password, $userDetails['user_password'])) {

        $address = sanitizeInput($_POST['address']);
        $contactNumber = sanitizeInput($_POST['contact_number']);

        $stmt = $conn->prepare("UPDATE Users SET address = ?, contact_number = ? WHERE user_id = ?");
        $stmt->bind_param('ssi', $address, $contactNumber, $userDetails['user_id']);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        $_SESSION['success_message'] = 'User details updated successfully.';
        header('Location: my_account.php');
        exit;
    } else {

        echo "
        <script>
        alert('Password incorrect.');
        </script>
        ";
    }
}

function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="resources/css/Style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <?php
    include('navbar_loggedin.php');
    ?>

    <section class="my-account">
        <br> <br> <br>
        <center> <img src="resources/images/logo.png" /> </center>

        <div class="accountContainer text-center">
            <center>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <p> NAME </p>
                    <input type="text" name="name" readonly
                        value="<?php echo $userDetails['user_fname'] . ' ' . $userDetails['user_lname']; ?>" />

                    <p> ADDRESS </p>
                    <input type="text" name="address" value="<?php echo $userDetails['address'] ?>" required />

                    <p> EMAIL ADDRESS </p>
                    <input type="email" name="email" value="<?php echo $userDetails['user_email']; ?>" readonly />

                    <p> CONTACT NUMBER </p>
                    <input type="text" id="contactNumber" name="contact_number"
                        value="<?php echo $userDetails['contact_number']; ?>" required />

                    <p> PASSWORD </p>
                    <input type="password" name="password" required />

                    <br> <br>
                    <div class="saveButton">
                        <button class="LoginButtonReg" name="saveDetails" type="submit"> Save </button>
                    </div>
                </form>
            </center>
        </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>