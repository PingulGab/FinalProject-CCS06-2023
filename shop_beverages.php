<?php

include('model/get_beverages.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
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
  session_start();

  if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
    // User is logged in
    include('navbar_loggedin.php');
  } else {
    // User is not logged in
    include('navbar_loggedout.php');
  }
  ?>

  </head>

  <body>
    <!-- Products -->
    <section id="featured" class="pb5" style="margin-top: 125px;">
      <div class="container text-center mt-5 py-4">
        <h3> Beverages </h3>
        <hr>
        <p> Check our most famous products. </p>
        <br>
      </div>
      <div class="row mx-auto container-fluid">

        <!--Showcase Products-->
        <?php while ($row = $itemSet->fetch_assoc()) { ?>

          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <a href="<?php echo "item_description.php?item_id=" . $row['item_id']; ?>"> <img
                class="img-fluid mb-3" src="<?php echo $row['item_image']; ?>" /> </a>
            <h5 class="p-name">
              <?php echo $row['item_name']; ?>
            </h5>
            <h4 class="p-price"> $
              <?php echo $row['item_price']; ?>
            </h4>
            <a href="<?php echo "item_description.php?item_id=" . $row['item_id']; ?>"> <button class="buy-button"> BUY NOW </button> </a>
          </div>

        <?php } ?>

      </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
      crossorigin="anonymous"></script>


  </body>

</html>