<?php

namespace FormEngine;

class String
{
	public static function humanize($str)
	{
		return ucwords(preg_replace('/[^a-z\d]/i', ' ', $str));
	}

}