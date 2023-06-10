<?php

include('model/connector.php');
session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$cart_orders_id = $_GET['cart_orders'];

$stmt = $conn->prepare("SELECT cart_orders.*, items.item_name, items.item_price, items.item_image FROM cart_orders JOIN items ON cart_orders.item_id = items.item_id WHERE user_id = ? AND cart_orders.order_id = ?");
$stmt->bind_param('ii', $userId, $cart_orders_id);
$stmt->execute();

$result = $stmt->get_result();

$orderHistory_Details = array();
while ($row = $result->fetch_assoc()) {
    $orderHistory_Details[] = $row;
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

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

    <!-- Navigation Bar Code -->
    <?php
    include('navbar_loggedin.php');
    ?>

    <!-- Cart Code -->
    <section class="cart container py-5" style="margin-top: 90px;">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Order #
                <?php echo $cart_orders_id ?>
            </h2>
            <hr>
        </div>

        <table class="container mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Price/Item</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($orderHistory_Details as $item) { ?>
                <tr>
                    <td>
                        <div class="item-info">
                            <img class="me-1" src="<?php echo $item['item_image']; ?>" />
                            <div class="remove_edit">
                                <p><b>
                                        <?php echo $item['item_name']; ?>
                                    </b></p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span>$</span>
                        <?php echo $item['item_price']; ?>
                    </td>

                    <td>
                        <div class="remove_edit">
                            <p>
                                <?php echo $item['quantity']; ?>
                            </p>
                        </div>
                    </td>

                    <td>
                        <span>$</span>
                        <span class="item-price">
                            <?php echo number_format($subtotal2 = $item['item_price'] * $item['quantity'], 2, '.', ','); ?>
                        </span>

                    </td>
                </tr>
            <?php } ?>

        </table>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>