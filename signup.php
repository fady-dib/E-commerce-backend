<?php
include('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email  = $_POST['email'];

//  ----------email and password verification

// $email = $password = "";





if (empty($email)) {
    $response["status"] = " email is required ";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["status"] = 'Invalid email format.';
} else {

    if (empty($password)) {
        $response["status"] = " password is required ";
    } else if (strlen($password) < 8) {
        $response["status"] = " password should be >8 ";
    } else if (!preg_match('/[A-Z]/', $password)) {

        $response["status"] = "Password should contain at least one uppercase letter";
    } else if (!preg_match('/[@#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password)) {
        $response["status"] = "Password should contain at least one special letter";
    } else {
        $response["status"] = "success";
    




    // echo json_encode($response);




    // username checkup
    $check_username = $mysqli->prepare('select username from users where username=?');
    $check_username->bind_param('s', $username);
    $check_username->execute();
    $check_username->store_result();
    $username_exists = $check_username->num_rows();








    // -----------------email checkup
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

}
}
echo json_encode($response);
