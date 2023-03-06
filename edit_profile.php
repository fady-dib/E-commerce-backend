<?php
header("Access-Control-Allow-Origin: *");
include('connection.php');

$id = $_POST['id'];
// $username = $_POST['username'];
// $password = $_POST['password'];
// $new_password = $_POST['new_password'];
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
$old_email -> store_result();
$old_email -> bind_result($old_email);
$old_email -> fetch();



$response["status"]='correct';

if( $old_email != $email){
    // echo "hi";
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $response["status"] = 'Invalid email format.';
    // }
if ($email_exists > 0) {
    $response['status'] = 'failed';
}else{
    $response['status'] = 'correct';
} }
if($response["status"] == 'correct'){
if($first_name != null && $last_name != null && $email != null ){
    $query = $mysqli->prepare('update users set first_name = ?,last_name= ?,email= ?,street_address= ?,country= ?,city= ?,phone_number= ?,landline_number = ? where id = ?');
    $query->bind_param('ssssssssi', $first_name,$last_name,$email,$street_address,$country,$city,$phone_number,$landline_number,$id);
    $query->execute();
    $response['status'] = "success";
}else{
    $response['status'] = "failed, basic info missing";
}
}

    echo json_encode($response);