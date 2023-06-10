<?php
class Register {
    public static function createUser($email, $password, $first_name, $last_name)
    {
        include('connector.php');
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (user_email, user_password, user_fname, user_lname) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $hashedPassword, $first_name, $last_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
