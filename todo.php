<?php

// php todo.php list
// php todo.php list 2022-10-12
// php todo.php list today
// php todo.php list yesterday
// php todo.php add "Wake up"
// php todo.php complete 1
// php todo.php remove 2 (rm)



function main(array $arguments): void
{
	array_shift($arguments);

	$command= array_shift($arguments);

	switch ($command)
	{
		case 'list':
			listCommand($arguments);
			break;
		case 'add':
			addCommand($arguments);
			break;
		case 'complete':
			completeCommand($arguments);
			break;
		case 'remove':
		case 'rm':
			removeCommand($arguments);
		break;

		default:
			echo 'unknown command';
			exit(1);


	}

	exit(0);
}

function removeCommand(array $arguments)
{

}

function completeCommand(array $arguments)
{

}

function addCommand(array $arguments)
{
	$title = array_shift($arguments);

	$todo = [
		'id' => uniqid('', false),
		'title' => $title,
		'completed' => false,
	];

	$fileName = date('y-m-d').'.txt';
	$filePath = __DIR__.'/data/'.$fileName;

	if (file_exists($filePath))
	{
		$content = file_get_contents($filePath);
		$todos = unserialize($content, [
			'allowed_classes' => false,
		]);
		$todos[] = $todo;
		file_put_contents($filePath, serialize($todos));
	}
	else
	{
		$todos = [ $todo ];
		file_put_contents($filePath, serialize($todos));
	}
}

function listCommand(array $arguments)
{
	$fileName = date('y-m-d').'.txt';
	$filePath = __DIR__.'/data/'.$fileName;

	if (!file_exists($filePath))
	{
		echo 'Nothing to do here';
		return;
	}

	$content = file_get_contents($filePath);
	$todos = unserialize($content, [
		'allowed_classes' => false,
	]);

	if (empty($todos))
	{
		echo 'Nothing to do here';
		return;
	}


	foreach ($todos as $index => $todo)
	{
		echo sprintf(
			"%s. [%s] %s \n",
			($index+1),
			$todo['completed'] ? 'x' : '',
			$todo['title'],
		);
	}
}

main($argv);