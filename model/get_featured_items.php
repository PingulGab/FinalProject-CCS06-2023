<?php

include('connector.php');

$featuredGet = $conn->prepare("SELECT * FROM items LIMIT 4");

$featuredGet->execute();

$featured_items = $featuredGet->get_result();

?>