<?php

// -----------------get old password of user in database
$old_password = $mysqli->prepare('select password from users where id=?');
$old_password->bind_param('i', $id);
$old_password->execute();
$old_password->store_result();

if($password != null && $new_password!=null){
if(password_verify($password, $old_password)){

}
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);