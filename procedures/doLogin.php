<?php
require __DIR__ . '/../inc/bootstrap.php';

$user = findUserByEmail(request()->get('email'));

if (empty($user)) {
	$session->getFlashBag()->add('error', 'Username was not found');
	redirect('login.php');
}

if (!password_verify(request()->get('password'), $user['password'])) {
	$session->getFlashBag()->add('error', 'Invalid login');
	redirect('login.php');
}

$expTime = time() + 3600;

$jwt = \Firebase\JWT\JWT::encode([
	'iss' => request()->getBaseUrl(),
	'sub' => "{$user['id']}",
	'exp' => $expTime,
	'iat' => time(),
	'nbf' => time(),
	'is_admin' => $user['role_id'] == 1
], getenv("SECRET_KEY"), 'HS256');

$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expTime, '/', getenv('COOKIE_DOMAIN'));

$session->getFlashBag()->add('success', 'You are logged in');

redirect('index.php', ['cookies' => [$accessToken]]);