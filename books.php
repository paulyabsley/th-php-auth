<?php
require_once __DIR__ . '/inc/bootstrap.php';
require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>
<div class="container">
	<div class="well">
		<?php print displaySuccess(); ?>
		<?php print displayErrors(); ?>
		<h2>Book List</h2>
		<?php
		foreach (getAllBooks() as $book) {
			include __DIR__ . '/inc/book.php';	
		}
		?>
	</div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';