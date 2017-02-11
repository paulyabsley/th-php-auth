<?php
require_once __DIR__ . '/../inc/bootstrap.php';

$bookId = request()->get('bookId');

try {
	$deleteBook = deleteBook($bookId, $bookTitle, $bookDescription);
	redirect('books.php');
} catch (\Exception $e) {
	redirect('books.php');
}