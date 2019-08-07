<?php

	// require __DIR__.'/public/index.php';

	// use Core\{ Router, Route };

	// $router = new Router();

	$t = '/show?';

	$qString = '';

	// echo substr($t, strlen($t) - 1, 1);

	if($qString and strlen($t))
	{
		$pos = stripos($t, $qString);
		$text = substr($t, 0, ($pos - 1));
	}
	elseif(substr($t, (strlen($t) - 1)) == '?')
	{
		$text = substr($t, 0, (strlen($t) - 1));
	}
	else
		$text = $t;

	echo $text;
