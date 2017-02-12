<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$bookTitle = request()->get('title');
$bookDescription = request()->get('description');

if (empty($bookTitle)) {
	$session->getFlashBag()->add('error', 'Please enter a book title');
	redirect('add.php');
}

if (empty($bookDescription)) {
	$session->getFlashBag()->add('error', 'Please enter a book description');
	redirect('add.php');
}

try {
	$newBook = addBook($bookTitle, $bookDescription);
	$session->getFlashBag()->add('success', 'Book added');
	redirect('books.php');
} catch (\Exception $e) {
	redirect('add.php');
}