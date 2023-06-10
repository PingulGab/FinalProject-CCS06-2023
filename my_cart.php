<?php

include('model/connector.php');
session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT cart.cart_id, items.item_name, items.item_price, items.item_image, cart.quantity, items.item_id FROM cart JOIN items ON cart.item_id = items.item_id WHERE cart.user_id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();

$result = $stmt->get_result();

$cartItems = array();
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

$stmt->close();

if (isset($_POST['removeFromCart'])) {
    $cartItemId = $_POST['cart_item_id'];

    $deleteCartItem = $conn->prepare("DELETE FROM cart WHERE item_id= ?");
    $deleteCartItem->bind_param("i", $cartItemId);
    $deleteCartItem->execute();

    header('Location: my_cart.php');
    exit;
}

if (isset($_POST['editFromCart'])) {
    $cartItemId = $_POST['cart_item_id'];
    $cartNewQuantity = $_POST['cart_new_quantity'];

    $updateCartItem = $conn->prepare("UPDATE cart SET quantity = ? WHERE item_id= ?");
    $updateCartItem->bind_param("ii", $cartNewQuantity, $cartItemId);
    $updateCartItem->execute();

    header('Location: my_cart.php');
    exit;
}

$totalPrice = 0;

foreach ($cartItems as $item) {

    $itemId = $item['item_id'];
    $totalGet = $conn->prepare("SELECT item_price FROM items WHERE item_id = ?");
    $totalGet->bind_param("i", $itemId);
    $totalGet->execute();
    $result = $totalGet->get_result();
    $row = $result->fetch_assoc();
    $itemPrice = $row['item_price'];

    $subtotal = $itemPrice * $item['quantity'];
    $totalPrice += $subtotal;
}


if (isset($_POST['checkOut'])) {

    $userId = $_SESSION['user_id'];
    $totalPrice = 0;

    $insertOrderTrack = $conn->prepare("INSERT INTO order_track(user_id) VALUES (?)");
    $insertOrderTrack->bind_param("i", $userId);
    $insertOrderTrack->execute();
    $orderId = $insertOrderTrack->insert_id;

    $insertOrder = $conn->prepare("INSERT INTO cart_orders (total_price, user_id, quantity, item_id, order_id) VALUES (?, ?, ?, ?, ?)");

    foreach ($cartItems as $item) {
        $itemPrice = $item['item_price'];
        $subtotal = $itemPrice * $item['quantity'];
        $totalPrice += $subtotal;

        $insertOrder->bind_param("siiii", $subtotal, $userId, $item['quantity'], $item['item_id'], $orderId);
        $insertOrder->execute();
    }

    if ($insertOrder->affected_rows > 0) {

        $_SESSION['order_total_price'] = $totalPrice;

        $orderId = $insertOrder->insert_id;

        $deleteCartItems = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $deleteCartItems->bind_param("i", $userId);
        $deleteCartItems->execute();

        header('Location: order_history.php');
        exit();
    } else {
        echo "<script> alert('Failed to place the order.'); </script>";
    }

    $insertOrder->close();
    $deleteCartItems->close();
}




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
            <h2 class="font-weight-bold">Your Cart</h2>
            <hr>
        </div>

        <table class="container mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Price/Item</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php foreach ($cartItems as $item) { ?>
                <tr>
                    <td>
                        <div class="item-info">
                            <img class="me-1" src="<?php echo $item['item_image']; ?>" />
                            <div class="remove_edit">
                                <p><b>
                                        <?php echo $item['item_name']; ?>
                                    </b></p>
                                <form method="POST">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $item['item_id']; ?>" />
                                    <button type="submit" name="removeFromCart">REMOVE</button>
                                </form>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span>$</span>
                        <?php echo $item['item_price']; ?>
                    </td>

                    <td>
                        <div class="remove_edit">
                            <form method="POST">
                                <input type="number" name="cart_new_quantity" value="<?php echo $item['quantity']; ?>" />
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['item_id']; ?>" />
                                <button type="submit" name="editFromCart">EDIT</button>

                            </form>
                        </div>
                    </td>

                    <td>
                        <span>$</span>
                        <span class="item-price">
                            <?php echo $subtotal2 = $item['item_price'] * $item['quantity']; ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>

        </table>

        <div class="container cart-total">
            <table>
                <tr>
                    <td>Total</td>
                    <td>$
                        <?php echo number_format($totalPrice, 2, '.', ','); ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="container orderContainer">
            <form method="POST">
                <button type="submit" name="checkOut" class="order-button">ORDER</button>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

</body>

</html>