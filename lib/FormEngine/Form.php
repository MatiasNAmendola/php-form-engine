<?php

namespace FormEngine;

/**
 * 
 * 
 * 
 */
class Form {

	protected $fields = array();
	protected $attributes = array();

	/**
	 * 
	 * 
	 * 
	 */
	public function __construct(array $fields = array())
	{
		foreach ($fields as $config)
		{
			$class = '\FormEngine\Field';
			
			if (isset($config['type']))
			{
				$class .= '\\'.$config['type'];
			}

			$this->fields[] = new $class($config);
		}
	}

	/**
	 * Get all fields.
	 * 
	 * @param void
	 * @return array
	 */
	public function fields()
	{
		return $this->fields;
	}

	/**
	 * Open the form tag.
	 * 
	 * @param array $attributes HTML attributes
	 * @return array
	 */
	public function open($attributes = array())
	{
		return '<form'.HTML::attributes($attributes).'>';
	}

	/**
	 * Close the form tag.
	 * 
	 * @param void
	 * @return array
	 */
	public function close()
	{
		return '</form>';
	}

}