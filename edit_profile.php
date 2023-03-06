<?php
include('connection.php');

$id = $_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$new_password = $_POST['new_password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email  = $_POST['email'];
$street_address = $_POST['street_address'];
$country = $_POST['country'];
$city = $_POST['city'];
$phone_number = $_POST['phone_number'];
$landline_number = $_POST['landline_number'];

// -----------------email checkup
$check_email = $mysqli->prepare('select email from users where email=?');
$check_email->bind_param('s', $email);
$check_email->execute();
$check_email->store_result();
$email_exists = $check_email -> num_rows();

// -----------------get email of user in database
$old_email = $mysqli->prepare('select email from users where id=?');
$old_email->bind_param('i', $id);
$old_email->execute();
$old_email->store_result();

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if( $old_email != $email){
if ($email_exists > 0) {
    $response['status'] = "failed";
} }
    $query = $mysqli->prepare('update users set first_name = ?,last_name= ?,username= ?,password= ?,email= ?,street_address= ?,country= ?,city= ?,phone_number= ?,landline_number = ? where id = ?');
    $query->bind_param('ssssssssssi', $first_name,$last_name,$username,$hashed_password, $email,$street_address,$country,$city,$phone_number,$landline_number,$id);
    $query->execute();
    $response['status'] = "success";

    echo json_encode($response);