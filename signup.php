<?php
include('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];

$check_username = $mysqli->prepare('select username from users where username=?');
$check_username->bind_param('s', $username);
$check_username->execute();
$check_username->store_result();
$username_exists = $check_username->num_rows();

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if ($username_exists > 0) {
    $response['status'] = "failed";
} else {
    $query = $mysqli->prepare('insert into users(username,password,first_name,last_name) values(?,?,?,?)');
    $query->bind_param('ssss', $username, $hashed_password, $first_name, $last_name);
    $query->execute();
    $response['status'] = "success";
}

echo json_encode($response);
