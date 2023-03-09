<?php

require 'db.php';
require 'Task.php';

$task = Task::createTask(...$_POST);
if (!$task->title or !$task->description) exit;
$conn->query(<<<SQL
	INSERT INTO tasks(title, description) VALUES('$task->title', '$task->description')
SQL);

$_SESSION = [
	'message' => 'Task Saved Successfully',
	'message_type' => 'success'
];

header('location: index.php');