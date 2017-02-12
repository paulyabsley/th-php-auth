<?php
require __DIR__ . '/../inc/bootstrap.php';

$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');
$email = request()->get('email');

if ($password != $confirmPassword) {
	$session->getFlashBag()->add('error', 'Passwords do not match');
	redirect('register.php');
}

$user = findUserByEmail($email);
if (!empty($user)) {
	$session->getFlashBag()->add('error', 'Email address already in use');
	redirect('register.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$session->getFlashBag()->add('success', 'You have successfully registered');

$user = createUser($email, $hashed);
redirect('index.php');