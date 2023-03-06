<?php
header("Access-Control-Allow-Origin: *");

include('connection.php');

// $category_id = $_GET["category_id"];
$query = $mysqli->prepare('select name,image,price,id from products');
// $query->bind_param('i', $category_id);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows();
$query->bind_result($name, $image, $price,$id);
// $query->fetch();
$response = [];

// echo $query;
if ($num_rows == 0) {
    $response['response'] = "no products";
} else {
    while ($query->fetch() && $num_rows !== 0)  {
        $data = array(
        'name' => $name,
        'image' => $image,
        'price' => $price,
        'id' => $id
        );
        array_push($response, $data);
    }
}

echo json_encode($response);