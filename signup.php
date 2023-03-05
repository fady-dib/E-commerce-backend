<?php
include('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email  = $_POST['email'];


// username checkup
$check_username = $mysqli->prepare('select username from users where username=?');
$check_username->bind_param('s', $username);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();



// email checkup
$check_email = $mysqli->prepare('select email from users where email=?');
$check_email->bind_param('s', $email);
$check_email->execute();
$check_email->store_result();
$email_exists = $check_email -> num_rows();


// password checkup
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if ($username_exists > 0 || $email_exists > 0) {
    $response['status'] = "failed";
} else {
    $query = $mysqli->prepare('insert into users(first_name,last_name,username,password, email ) values(?,?,?,?,?)');
    $query->bind_param('sssss', $first_name,$last_name,$username,$password, $email);
    $query->execute();
    $response['status'] = "success";
}

echo json_encode($response);
