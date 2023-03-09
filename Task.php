<?php

final readonly class Task {
	public ?int $id;
	public ?string $title;
	public ?string $description;
	public ?string $created_at;
	
	/**
	 * Format date to a specified format string, Default: `'d/m/Y h:ia'`
	 * @return ?string Returns `NULL` if Task doesn't have a valid `$created_at` property
	 */
	function getFormatedDate(string $format = 'd/m/Y h:ia'): ?string {
		if ($this->created_at)
			$formatedDate = date($format, strtotime($this->created_at));
		
		return $formatedDate ?? null;
	}
	
	/**
	 * Create a Task object using an array
	 * @return Task A new Task object with the following properties:
	 * ```php
	 * readonly ?int $id;
	 * readonly ?string $title;
	 * readonly ?string $description;
	 * readonly ?string $created_at;
	 * ```
	 */
	static function createTask(
		?int $id = null,
		?string $title = null,
		?string $description = null,
		?string $created_at = null,
	): self {
		$task = new self;
		$task->id = $id;
		$task->title = $title;
		$task->description = $description;
		$task->created_at = $created_at;
		return $task;
	}
	
	/** @return Task[] */
	static function createTasks(SQLite3Result $result): array {
		/** @var self[] */
		$tasks = [];
		while ($task = $result->fetchArray(SQLITE3_ASSOC))
			$tasks[] = self::createTask(...$task);
		
		return $tasks;
	}
	
	function __toString(): string {
		return json_encode((array) $this);
	}
}