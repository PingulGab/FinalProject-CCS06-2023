<?php

session_start();

if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
  header('Location: login.php');
  exit;
}

include('model/connector.php');

if (isset($_GET['item_id'])) {

  $item_id = $_GET['item_id'];

  $getItem = $conn->prepare("SELECT items.*, categories.category_name FROM items JOIN categories ON items.category_id = categories.category_id WHERE item_id = ?");
  $getItem->bind_param("i", $item_id);
  $getItem->execute();

  $item = $getItem->get_result();

  if (isset($_POST['addToCart'])) {

    $cart_item_id = $_POST['cart_item_id'];
    $cart_item_quantity = $_POST['cart_item_quantity'];

    $checkCartItem = $conn->prepare("SELECT * FROM cart WHERE item_id = ? AND user_id = ?");
    $checkCartItem->bind_param("ii", $cart_item_id, $_SESSION['user_id']);
    $checkCartItem->execute();

    $existingCartItem = $checkCartItem->get_result();

    if ($existingCartItem->num_rows > 0) {

      $existingCartRow = $existingCartItem->fetch_assoc();
      $newQuantity = $existingCartRow['quantity'] + $cart_item_quantity;

      $updateCartItem = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
      $updateCartItem->bind_param("ii", $newQuantity, $existingCartRow['cart_id']);
      $updateCartItem->execute();
    } else {

      $insertCartItem = $conn->prepare("INSERT INTO cart (item_id, user_id, quantity) VALUES (?, ?, ?)");
      $insertCartItem->bind_param("iii", $cart_item_id, $_SESSION['user_id'], $cart_item_quantity);
      $insertCartItem->execute();

      if ($insertCartItem->error) {
        echo "Error: " . $insertCartItem->error;
      }
    }

    header('Location: my_cart.php');
    exit;
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

<script>
  window.onload = function () {
    showPrompt();
  };
  function showPrompt() {

    if (confirm("We only accept Cash On Delivery. Do you wish to proceed?") == false) {
      window.location.href = 'index.php';
    };
  }
</script>

<body>

  <!-- Navigation Bar Code -->
  <?php
  include('navbar_loggedin.php');
  ?>

  <section class="container-fluid item-description pt-5" style="margin-top: 75px;">
    <div class="row mt-5">

      <?php
      while ($row = $item->fetch_assoc()) {
        ?>

        <div class="col-lg-7 col-md-6 col-sm-12">
          <img class="img-fluid w-75 pb-0" src="<?php echo $row['item_image'] ?>" />
        </div>


        <div class="col-lg-5 col-md-12 col-12">
          <h6>
            <?php echo $row['category_name'] ?>
          </h6>
          <h3 class="py-4">
            <?php echo $row['item_name'] ?>
          </h3>
          <h2> $
            <?php echo $row['item_price'] ?>
          </h2>

          <form method="POST">
            <input type="hidden" name="cart_item_id" value="<?php echo $row['item_id'] ?>" />
            <input type="hidden" name="cart_item_image" value="<?php echo $row['item_image'] ?>" />
            <input type="hidden" name="cart_item_name" value="<?php echo $row['item_name'] ?>" />
            <input type="hidden" name="cart_item_price" value="<?php echo $row['item_price'] ?>" />

            <input type="number" name="cart_item_quantity" value="1" />
            <button class="buy-button" type="submit" name="addToCart"> ADD TO CART </button>
          </form>

          <h4 class="mt-5 mb-2"> Product Details </h4>
          <span>
            <?php echo $row['item_description'] ?>
          </span>
        </div>

      <?php } ?>

    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

</body>

</html>