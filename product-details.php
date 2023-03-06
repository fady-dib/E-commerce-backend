<?php
include('connection.php');

$product_id = $_GET['product_id'];

$query = $mysqli -> prepare('select name,image,description,price,quantity from products where id =?');
$query -> bind_param('i',$product_id);
$query -> execute();
$query -> store_result();
$num_rows = $query -> num_rows();
$query -> bind_result($name,$image,$description,$price,$quantity);
$query -> fetch();

$response = [];

if($num_rows == 0) {
    $response['response'] = "Product not found";
}
else{
    $response['name'] = $name;
    $response['image'] = $image;
    $response['description'] = $description;
    $response['price'] = $price;
    $response['quantity'] = $quantity;
}

echo json_encode($response);