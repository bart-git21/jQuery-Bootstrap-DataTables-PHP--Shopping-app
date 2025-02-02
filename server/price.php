<?php
header("Content-Type: application/json");
$post = file_get_contents("php://input");

// // Update today's price in the JSON file
file_put_contents("db/todayPrice.json", $post);
$todayPrice = json_decode($post);

// Update price history in the JSON file
$priceHistory = json_decode(file_get_contents("db/price.json"));
foreach ($todayPrice as $key => $newProduct) {
    // find product in the history list that matches the current product
    $index = array_search($newProduct->id, array_column($priceHistory, 'id'));

    // update product price in the history list
    if ($index) {
        array_push($aa, $priceHistory[$index]->price);
        array_push($priceHistory[$index]->price, $newProduct->price);
    } else {
        $newProduct->price = [$newProduct->price];
        array_push($priceHistory, $newProduct);
    }
    ;
}