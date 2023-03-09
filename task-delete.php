<?php

require 'db.php';
require 'Task.php';

$task = Task::createTask(($_GET['id'] ?? 0));
if (!$task->id) exit;

$conn->query("DELETE FROM tasks WHERE id=$task->id");

$_SESSION = [
	'message' => 'Task Deleted Successfully',
	'message_type' => 'info'
];

header('location: index.php');