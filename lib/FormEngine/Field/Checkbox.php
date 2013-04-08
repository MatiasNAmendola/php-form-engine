<?php

namespace FormEngine\Field;

use \FormEngine\HTML;

class Checkbox extends \FormEngine\Field  {

	/**
	 * 
	 * 
	 * 
	 */
	public function input()
	{
		ob_start();
		foreach ($this->getOptions() as $value => $text)
		{
			echo '<label><input type="checkbox" value="'.HTML::escape($value).'">'.HTML::escape($text)."</label>\n";
		}
		return ob_get_clean();
	}

}