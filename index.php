<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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

  <!--Landing Page-->
  <section id="landing">
    <div class="landingTextLocation">
      <h1>Delicious silog for every mood</h1>
    </div>
  </section>

  <!--Categories-->
  <section id="category" class="w-100">
    <div class="row p-0 m-0">
      <!--Category #1-->
      <div class="categoryImg col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="resources/images/category1.png" />
        <div class="details">
          <h2>Main Dishes</h2>
          <a href="shop_main_dishes.php"><button class="text-uppercase">View More</button> </a>
        </div>
      </div>

      <!--Category #2-->
      <div class="categoryImg col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="resources/images/category2.png" />
        <div class="details">
          <h2>Side Dishes</h2>
          <a href="shop_side_dishes.php"> <button class="text-uppercase">View More</button> </a>
        </div>
      </div>

      <!--Category #3-->
      <div class="categoryImg col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="resources/images/category3.png" />
        <div class="details">
          <h2>Drinks</h2>
          <a href="shop_beverages.php"> <button class="text-uppercase">View More</button> </a>
        </div>
      </div>
    </div>
  </section>

  <!--Featured Products-->
  <section id="featured" class="my-5 pb5 ">
    <div class="container text-center mt-5 py-4">
      <h3> Featured </h3>
      <hr>
      <p> Our most famous meals. </p>
      <br>
    </div>
    <div class="row mx-auto container-fluid">

      <?php include('model/get_featured_items.php') ?>

      <?php while ($row = $featured_items->fetch_assoc()) { ?>

        <!--Featured Product Display-->
        <div class="product text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="<?php echo $row['item_image']; ?>" />
          <div class="star">
            <i class="fas fa-star" style="color:#fab919"></i>
            <i class="fas fa-star" style="color:#fab919"></i>
            <i class="fas fa-star" style="color:#fab919"></i>
            <i class="fas fa-star" style="color:#fab919"></i>
            <i class="fas fa-star" style="color:#fab919"></i>
          </div>
          <h5 class="p-name">
            <?php echo $row['item_name']; ?>
          </h5>
          <h4 class="p-price"> $
            <?php echo $row['item_price']; ?>
          </h4>
          <a href="<?php echo "item_description.php?item_id=" . $row['item_id']; ?>"> <button class="buy-button"> BUY NOW
            </button> </a>
        </div>

      <?php } ?>

    </div>
  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>
</body>

</html>