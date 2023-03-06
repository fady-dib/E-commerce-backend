<?php
include('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];

$query = $mysqli->prepare('select id,first_name,last_name,username,password, email from users where username=?');
$query->bind_param('s', $username);
$query->execute();

$query->store_result();
$num_rows = $query->num_rows();
$query->bind_result($id, $username, $first_name,$last_name,$username,$password, $email);
$query->fetch();
$response = [];
if ($num_rows == 0) {
    $response['response'] = "user not found";
} else {
    if (password_verify($password, $hashed_password)) {
        $response['response'] = "logged in";
        $response['user_id'] = $id;
        $response['username'] = $username;
        $response['first_name'] = $first_name;
        $response['last_name'] = $last_name;
    } else {
        $response["response"] = "Incorrect password";
    }
}

echo json_encode($response);
