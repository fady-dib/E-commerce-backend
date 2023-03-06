<?php
include('connection.php');

$category_id=$_GET["category_id"];
$query = $mysqli ->prepare('select name,image,price from products where category_id=? ');
$query -> bind_param('i',$category_id);
$query-> execute();
$query -> store_result();
$num_rows=$query ->num_rows();
$query->bind_result($name,$image,$price);
$query->fetch();
$response=[];

if($num_rows==0){
    $response['response']="no products";
}
else{
    $response['name']=$name;
    $response['image']=$image;
    $response['price']=$price;
}

echo json_encode($response);