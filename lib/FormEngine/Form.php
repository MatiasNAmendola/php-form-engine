<?php

namespace FormEngine;

/**
 * 
 * 
 * 
 */
class Form {

	protected $fields = array();
	protected $errors = array();

	/**
	 * HTML attributes
	 * 
	 * @var	array
	 */
	protected $attributes = array(
		'action'			=>	'',
		'method'			=>	'post',
		'accept-charset'	=>	'utf-8'
	);

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

			// Populate value
			$config['value'] = @$_POST[$config['name']];
			
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
		foreach ($attributes as $key => $value)
		{
			$this->attributes[$key] = $value;
		}
		return '<form'.HTML::attributes($this->attributes).'>';
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

	/**
	 * Get all validation errors.
	 * 
	 * @param void
	 * @return array
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Validate all fields.
	 * 
	 * @param void
	 * @return bool
	 */
	public function validate()
	{
		foreach ($this->fields as $key => $field)
		{
			if ( ! $field->validate())
			{
				$this->errors[$key] = $field->error();
			}
		}
		return ! empty($this->errors);
	}

}