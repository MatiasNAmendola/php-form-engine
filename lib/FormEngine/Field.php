<?php

namespace FormEngine;

/**
 * 
 * 
 * 
 */
class Field {

	protected $id;
	protected $name;

	protected $required = false;

	// ------------------------------

	protected $label = '';
	protected $options = array();
	protected $attributes = array();
	protected $id_prefix = 'field_';

	/**
	 * 
	 * 
	 * 
	 */
	public function __construct(array $config = array())
	{
		foreach ($config as $key => $value)
		{
			$this->setProperty($key, $value);
		}
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function setProperty($key, $value)
	{
		if (property_exists($this, $key))
		{
			$this->$key = $value;
			
			if (in_array($key, array(
				'id',
				'name',
				'required',
			)))
			{
				$this->setAttribute($key, $value);
			}
		}
		else
		{
			$this->setAttribute($key, $value);
		}
		return $this;
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function label()
	{
		if (empty($this->label))
		{
			$this->label = String::humanize($this->name);
		}
		return HTML::label($this->label, array('for' => $this->getAttribute('id')));
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function input()
	{
		return '<input'.$this->getAttributes().'>';
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function getAttribute($key)
	{
		if ($key === 'id')
		{
			return $this->id_prefix.$this->name;
		}
		return isset($this->attributes[$key]) ? $this->attributes[$key] : NULL;
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function setAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
		return $this;
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function getAttributes()
	{
		return HTML::attributes($this->attributes);
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function getOptions()
	{
		return $this->options;
	}

}