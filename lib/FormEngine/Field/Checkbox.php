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
			$attrs = HTML::attributes(array(
				'name' => $this->getAttribute('name').'['.HTML::escape($value).']',
				'type' => 'checkbox',
				'value' => $value,
			));

			echo '<label><input'.$attrs.'>'.HTML::escape($text)."</label>\n";
		}
		return ob_get_clean();
	}

}