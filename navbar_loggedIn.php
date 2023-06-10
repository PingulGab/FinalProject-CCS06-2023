<nav class="navbar navbarCustom navbar-expand-lg navbar-light py-4 fixed-top shadow-sm p-3 mb-5">
  <div class="container-fluid">
    <img src="resources/images/Logo.png" width="auto" height="75" />

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"> Menu </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="shop_main_dishes.php">Main Dish</a></li>
            <li><a class="dropdown-item" href="shop_side_dishes.php">Side Dishes</a></li>
            <li><a class="dropdown-item" href="shop_beverages.php">Drinks</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>

      </ul>
    </div>

    <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"> <i
              class="fa-solid fa-circle-user fa-2xl"
              style="color: #fab919; margin-right: 20px; margin-bottom: 20px;"></i> </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="my_account.php">My Account</a></li>
            <li><a class="dropdown-item" href="my_cart.php">Cart</a></li>
            <li><a class="dropdown-item" href="order_history.php">Order History</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
      </ul>
    </div>
  </div>
</nav>