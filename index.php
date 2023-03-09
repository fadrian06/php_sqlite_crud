<?php
	require 'db.php';
	require 'Task.php';
	
	$result = $conn->query('SELECT * FROM tasks');
	$tasks = Task::createTasks($result);
	include 'includes/head.html';
?>

<div class="container p-4">
	<div class="row">
		<div class="col-md-4">
			<!-- NOTIFICATION -->
			<?php if (isset($_SESSION['message'])) print <<<HTML
				<div role="alert" class="alert alert-{$_SESSION['message_type']} alert-dismissible fade show">
					{$_SESSION['message']}
					<button class="close" data-dismiss="alert">&times;</button>
				</div>
			HTML and session_destroy() ?>
			<!-- TASK FORM -->
			<form action="task-save.php" method="post" class="card card-body">
				<div class="form-group">
					<input name="title" class="form-control" placeholder="Task Title" autofocus>
				</div>
				<div class="form-group">
					<textarea	name="description" class="form-control" placeholder="Task Description"></textarea>
				</div>
				<input type="submit" value="Save Task" class="btn btn-success btn-block">
			</form>
		</div>
		<!-- TABLE -->
		<table class="col-md-8 table table-bordered mt-4 mt-md-0">
			<tr class="bg-dark text-white">
				<th>Title</th>
				<th>Description</th>
				<th>Created At</th>
				<th>Actions</th>
			</tr>
			<?php foreach ($tasks as $task) echo <<<HTML
				<tr>
					<td>$task->title</td>
					<td>$task->description</td>
					<td>{$task->getFormatedDate()}</td>
					<td>
						<a href="task-edit.php?id=$task->id" class="fas fa-marker btn btn-secondary"></a>
						<a href="task-delete.php?id=$task->id" class="fas fa-trash-alt btn btn-danger"></a>
					</td>
				</tr>
			HTML ?>
		</table>
	</div>
</div>

<?php include 'includes/foot.html' ?>