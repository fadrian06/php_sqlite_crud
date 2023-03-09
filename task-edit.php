<?php

require 'db.php';
require 'Task.php';

$task = Task::createTask(
	$_GET['id'] ?? $_POST['id'] ?? 0,
	$conn->escapeString($_POST['title'] ?? ''),
	$conn->escapeString($_POST['description'] ?? '')
);

if (!$task->id) exit;

// UPDATE TASK
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	$conn->query(<<<SQL
		UPDATE tasks
		SET title='$task->title', description='$task->description'
		WHERE id=$task->id
	SQL);
	
	$_SESSION = [
		'message' => 'Task Updated Successfully',
		'message_type' => 'success'
	];
	
	header('location: index.php');
endif;

// EDIT FORM
$result = $conn->query("SELECT * FROM tasks WHERE id=$task->id");
if (!$task = $result->fetchArray(SQLITE3_ASSOC)) exit;

$task = Task::createTask(...$task);
include 'includes/head.html';

echo <<<HTML
	<div class="container p-4">
		<div class="row">
			<!-- EDIT TASK FORM -->
			<form action="task-edit.php" method="post" class="col-md-4 mx-auto card card-body">
				<div class="form-group">
					<input name="title" value="$task->title" class="form-control" placeholder="Update Title">
				</div>
				<div class="form-group">
					<textarea name="description" class="form-control" placeholder="Update Description">$task->description</textarea>
				</div>
				<input type="hidden" name="id" value="$task->id">
				<input type="submit" name="edit_task" value="Update" class="btn btn-success btn-block">
			</form>
		</div>
	</div>
HTML;

include 'includes/foot.html';