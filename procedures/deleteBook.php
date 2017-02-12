<?php
require_once __DIR__ . '/../inc/bootstrap.php';
requireAuth();

$bookId = request()->get('bookId');

if (!isAdmin() && !isOwner($book['owner_id'])) {
	$session->getFlashBag()->add('error', 'Not Authorised');
	redirect('books.php');
}

try {
	$deleteBook = deleteBook($bookId, $bookTitle, $bookDescription);
	redirect('books.php');
} catch (\Exception $e) {
	redirect('books.php');
}