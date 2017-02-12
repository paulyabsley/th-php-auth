<?php
require __DIR__ . '/../inc/bootstrap.php';

$access_token = new \Symfony\Component\HttpFoundation\Cookie("access_token", "Expired", time()-3600, '/', getenv('COOKIE_DOMAIN'));

$session->getFlashBag()->add('success', 'You have been logged out');

redirect('login.php', ['cookies' => [$access_token]]);