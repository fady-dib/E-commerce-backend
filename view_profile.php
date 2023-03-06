<?php
include('connection.php');

// automatically gets the id from js
$id = $_GET['id'];

$query = $mysqli -> prepare('select * from users where id =?');
$query -> bind_param('i',$id);
$query -> execute();
$query -> store_result();
$query -> bind_result($id,$first_name,$last_name, $username, $password, $email, $is_admin, $street_address, $country, $city, $phone_number, $landline_number);
$query -> fetch();

$response = [];

$response['first_name'] = $first_name;
$response['last_name'] = $last_name;
$response['username'] = $username;
$response['email'] = $email;
$response['street_address'] = $street_address;
$response['country'] = $country;
$response['city'] = $city;
$response['phone_number'] = $phone_number;
$response['landline_number'] = $landline_number;


echo json_encode($response);
