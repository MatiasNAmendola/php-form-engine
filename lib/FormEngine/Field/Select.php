<?php

namespace FormEngine\Field;

use \FormEngine\HTML;

class Select extends \FormEngine\Field  {

	/**
	 * 
	 * 
	 * 
	 */
	public function input()
	{
		ob_start();
		echo '<select'.$this->getAttributes().">\n";
		foreach ($this->getOptions() as $value => $text)
		{
			echo '<option value="'.HTML::escape($value).'">'.HTML::escape($text)."</option>\n";
		}
		echo '</select>';
		return ob_get_clean();
	}

}