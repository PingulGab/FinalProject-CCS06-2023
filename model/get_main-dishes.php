<?php

include('connector.php');

$itemGet = $conn->prepare("SELECT * FROM items WHERE category_id = 1");

$itemGet->execute();

$itemSet = $itemGet->get_result();

?>