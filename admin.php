<?php
require_once __DIR__ . '/inc/bootstrap.php';
requireAdmin();
require_once __DIR__ . '/inc/head.php';
require_once __DIR__ . '/inc/nav.php';
?>
<div class="container">
	<div class="well">
		<?php print displaySuccess(); ?>
		<?php print displayErrors(); ?>
		<h2>Admin</h2>
		<div class="panel">
			<h4>Users</h4>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Email</th>
						<th>Registered</th>
						<th>Promote/Demote</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach (getAllUsers() as $user) : ?>
					<tr>
						<td><?php echo $user["email"]; ?></td>
						<td><?php echo date('d/m/y H:i', strtotime($user["created_at"])); ?></td>
						<td>
							<?php if (!isOwner($user['id'])) : ?>
								<?php if ($user['role_id'] == 1) : ?>
								<a href="procedures/adjustRole.php?role=demote&userId=<?php echo $user['id']; ?>" class="bt btn-xs btn-warning">Demote from Admin</a>
								<?php elseif ($user['role_id'] == 2) : ?>
								<a href="procedures/adjustRole.php?role=promote&userId=<?php echo $user['id']; ?>" class="bt btn-xs btn-warning">Promote to Admin</a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
require_once __DIR__ . '/inc/footer.php';