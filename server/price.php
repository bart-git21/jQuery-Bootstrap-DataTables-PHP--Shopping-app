<?php
header("Content-Type: application/json");
$post = file_get_contents("php://input");

// // Update today's price in the JSON file
file_put_contents("db/todayPrice.json", $post);
$todayPrice = json_decode($post);

// Update price history in the JSON file
$priceHistory = json_decode(file_get_contents("db/price.json"));
$changedProducts = [];
foreach ($todayPrice as $key => $newProduct) {
    // find product in the history list that matches the current product
    $index = array_search($newProduct->id, array_column($priceHistory, 'id'));

    // update product price in the history list
    if ($index) {
        // if the price is different, add it to the price history
        if (intval(end($priceHistory[$index]->price)) !== intval($newProduct->price)) {
            (intval(end($priceHistory[$index]->price)) > intval($newProduct->price)) && array_push($changedProducts, $priceHistory[$index]);
            array_push($priceHistory[$index]->price, $newProduct->price);
        }
    } else {
        $newProduct->price = [$newProduct->price];
        array_push($priceHistory, $newProduct);
    }
    ;
}
file_put_contents("db/price.json", json_encode($priceHistory, JSON_UNESCAPED_UNICODE));

// Return the updated price data
echo json_encode($changedProducts);