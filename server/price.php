<?php
header("contentType: application/json");
$post = file_get_contents("php://input");
file_put_contents("db/todayPrice.json", $post);