<?php

session_start();
$conn = new SQLite3('php_sqlite_crud.db');
$conn->query(<<<SQL
	CREATE TABLE IF NOT EXISTS tasks (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		title VARCHAR(255) NOT NULL,
		description TEXT NOT NULL,
		created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP	
	)
SQL);

$_POST = $_POST ?: json_decode(file_get_contents('php://input'), true);