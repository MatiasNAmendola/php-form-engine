<?php

namespace FormEngine\Field;

use \FormEngine\HTML;

class Radio extends \FormEngine\Field  {

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
				'type' => 'radio',
				'value' => $value,
			));

			echo '<label><input'.$attrs.'>'.HTML::escape($text)."</label>\n";
		}
		return ob_get_clean();
	}

}