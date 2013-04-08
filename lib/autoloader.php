<?php

spl_autoload_register(function($class) {

	if (strpos($class, 'FormEngine\\') !== 0)
	{
		return;
	}
	
	$file = $class.'.php';
	
	include $file;

});