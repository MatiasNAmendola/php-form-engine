<?php

namespace FormEngine;

/**
 * 
 * 
 * 
 */
class Field {

	// Shared with HTML attributes
	// ------------------------------
	protected $id;
	protected $name;
	protected $required = false;

	// Configurable
	// ------------------------------
	protected $label = '';
	protected $rules = array();
	protected $options = array();
	protected $attributes = array();
	protected $id_prefix = 'field_';
	
	// Not configurable
	// ------------------------------
	protected $value;
	protected $errors = array();
	protected $validator;

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
		if ( ! $this->id)
		{
			$this->setProperty('id', $this->id_prefix.$this->name);
		}
		
		// TODO: Move somewhere else
		$this->validator = new Validator;
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

	/**
	 * 
	 * 
	 * 
	 */
	protected function isRequired()
	{
		return $this->required === TRUE;
	}

	/**
	 * 
	 * 
	 * 
	 */
	public function validate()
	{
		if ( ! $this->isRequired())
		{
			return true;
		}

		foreach ($this->rules as $key => $value)
		{
			// Rules that take params store rule names in the key
			if (is_int($key))
			{
				$rule = $value;
				$args = NULL;
			}
			else
			{
				$rule = $key;
				$args = $value;
			}
			
			##########################
			// Validation class and rule name
			$method = array($this->validator, $rule);

			// Check the validation class for the rule
			if ( ! is_callable($method))
			{
				// Check if a function exists with this rule name
				if (function_exists($rule))
				{
					$method = $rule;
				}
				// Rule not found or not callable
				else
				{
					throw new Exception('Unable to call validation rule "'.$rule.'"');
				}
			}
			
			// Values are sometimes an array, sometimes a string
			// Casting to array is easier than type checking and conditionals
			foreach ((array) $this->value as $key => $value)
			{
				// Set value as first argument and get the result of the validation function
				$result = call_user_func_array($method, array($value, $args));
				
				// If the result was a boolean FALSE, we have an error
				if ($result === FALSE)
				{
					$this->errors[] = $rule;
				}
				// Any other sane return value we'll reassign, like a filter
				elseif (is_string($result) || is_float($result) || is_integer($result))
				{
					// $this->value = $result;
					$this->value[$key] = $result;
				}
				// TODO: Log errors, don't throw exceptions in production
				elseif ($result !== TRUE)
				{
					throw new Exception('Unexpected '.gettype($result).' return value from validation rule "'.$rule.'"');
				}
			}
			
			##########################
		}
		return empty($this->errors);
	}

}