<?php 

/**
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
	return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function addBook($title, $description) {
	global $db;
	$ownerId = 0;

	try {
		$query = 'INSERT INTO books (name, description, owner_id) VALUES (:name, :description, :ownerId)';
		$stmt = $db->prepare($query);
		$stmt->bindParam(':name', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':ownerId', $ownerId);
		return $stmt->execute();
	} catch (\Exception $e) {
		throw $e;
	}
}

function updateBook($bookId, $title, $description) {
	global $db;

	try {
		$query = "UPDATE books SET name = :name, description = :description WHERE id = :bookId";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':name', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':bookId', $bookId);
		$stmt->execute();
	} catch (\Exception $e) {
		throw $e;
	}
}

function deleteBook($bookId) {
	global $db;

	try {
		$query = "DELETE FROM books WHERE id = :bookId";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':bookId', $bookId);
		$stmt->execute();
	} catch (\Exception $e) {
		throw $e;
	}
}

function getAllBooks() {
	global $db;
	try {
		$query = "SELECT books.*, sum(votes.value) as score FROM books LEFT JOIN votes ON (books.id = votes.book_id) GROUP BY books.id ORDER BY score DESC";
		$stmt = $db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll();
	} catch (\Exception $e) {
		throw $e;
	}
}

function getBook($id) {
	global $db;
	try {
		$query = "SELECT * FROM books WHERE id = ?";
		$stmt = $db->prepare($query);
		$stmt->bindParam(1, $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (\Exception $e) {
		throw $e;
	}
}

function vote($bookId, $score) {
	global $db;
	$userId = 0;

	try {
		$query = "INSERT INTO votes (book_id, user_id, value) VALUES (:bookId, :userId, :score)";
		$stmt = $db->prepare($query);
		$stmt->bindValue(':bookId', $bookId);
		$stmt->bindValue(':userId', $userId);
		$stmt->bindValue(':score', $score);
		$stmt->execute();
	} catch (\Exception $e) {
		die('Something happened with voting. Please try again');
	}
}

function redirect($path) {
	$response = \Symfony\Component\HttpFoundation\Response::create(null, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => ROOT . $path]);
	$response->send();
	exit;
}

function findUserByEmail($email) {
	global $db;

	try {
		$query = "SELECT * FROM users WHERE email = :email";
		$stmt = $db->prepare($query);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (\Exception $e) {
		throw $e;
	}
}

function createUser($email, $password) {
	global $db;

	try {
		$query = "INSERT INTO users (email, password, role_id) VALUES (:email, :password, 2)";
		$stmt = $db->prepare($query);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':password', $password);
		$stmt->execute();
		return findUserByEmail($email);
	} catch (\Exception $e) {
		throw $e;
	}
}


















