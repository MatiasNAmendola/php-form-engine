<?php

namespace FormEngine;

class HTML
{
	const charset = 'UTF-8';

	public static function escape($str)
	{
		return htmlspecialchars($str, ENT_QUOTES, self::charset);
	}

	public static function attributes(array $attrs = array())
	{
		ob_start();
		ksort($attrs);
		foreach ($attrs as $key => $value)
		{
			// Boolean attributes
			if ($value === true)
			{
				echo ' '.self::escape($key);
			}
			else
			{
				echo ' '.self::escape($key).'="'.self::escape($value).'"';
			}
		}
		return ob_get_clean();
	}

	public static function label($text, array $attrs = array())
	{
		return '<label'.self::attributes($attrs).'>'.self::escape($text).'</label>';
	}

}