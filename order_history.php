<?php

include('model/connector.php');
session_start();

// If the session variable is not set or is not true (user not logged in)
if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: login.php');
    exit;
}

// Retrieve the user ID from the session
$userId = $_SESSION['user_id'];

// Retrieve the order history for the user
$stmt = $conn->prepare("SELECT cart_orders.*, SUM(cart_orders.total_price) as total, items.item_name FROM cart_orders JOIN items ON cart_orders.item_id = items.item_id WHERE cart_orders.user_id = ? GROUP BY order_id;");
$stmt->bind_param('i', $userId);
$stmt->execute();

$result = $stmt->get_result();

$orderHistory = array();
while ($row = $result->fetch_assoc()) {
    $orderHistory[] = $row;
}

if (isset($_POST['viewButton'])) {
    $orderID = $_POST['viewButton'];
    header("Location: order_history_details.php?cart_orders=" . urlencode($orderID));
    exit;
}
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
    include('navbar_loggedin.php');
    ?>

    <!-- Order History Code -->
    <section class="cart container py-5" style="margin-top: 90px;">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Order History</h2>
            <hr>
        </div>

        <table class="container mt-3 pt-1">
            <tr class="text-center">
                <th>Order Number</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Details</th>
            </tr>

            <?php foreach ($orderHistory as $order) { ?>
                <tr>
                    <div class="item-info">
                        <td>
                            <?php echo $order['cart_orders'] ?>
                        </td>
                        <td>
                            <?php echo $order['order_status']; ?>
                        </td>
                        <td>
                            <?php echo $order['date']; ?>
                        </td>
                        <td>
                            <span> $ </span>
                            <?php echo $order['total']; ?>
                        </td>
                        <td>
                            <form method="POST">
                                <button type="submit" name="viewButton" class="order-button"
                                    value="<?php echo $order['order_id'] ?>">View</button>
                            </form>
                        </td>
                    </div>
                </tr>
            <?php } ?>
        </table>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>