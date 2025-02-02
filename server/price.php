<?php
header("Content-Type: application/json");
$post = file_get_contents("php://input");

// // Update today's price in the JSON file
file_put_contents("db/todayPrice.json", $post);
$todayPrice = json_decode($post);