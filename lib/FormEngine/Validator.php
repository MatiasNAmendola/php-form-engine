<?php
namespace FormEngine;

/**
 * Data validation class
 * 
 * @package	FormEngine
 * @version	0.1
 */
class Validator {

	/**
	 * Required
	 *
	 * @access	public
	 * @param	mixed
	 * @return	bool
	 */
	public function required($input)
	{
		if (is_string($input))
		{
			return trim($input) !== '';
		}
		if (is_array($input))
		{
			return count(array_filter($input)) > 0;
		}
		return (bool) $input;
	}

	/**
	 * Min Length
	 *
	 * @access	public
	 * @param	string
	 * @param	string|int
	 * @return	bool
	 */
	public function min_length($input, $length)
	{
		return $length <= strlen(trim($input));
	}

	/**
	 * Max Length
	 *
	 * @access	public
	 * @param	string
	 * @param	string|int
	 * @return	bool
	 */
	public function max_length($input, $length)
	{
		return $length >= strlen(trim($input));
	}

	/**
	 * Valid Email
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function email($input)
	{
		return (bool) filter_var($input, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Valid IP Address
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function ip_address($input)
	{
		return (bool) filter_var($input, FILTER_VALIDATE_IP);
	}

	/**
	 * Valid URL
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function url($input)
	{
		return (bool) filter_var($input, FILTER_VALIDATE_URL);
	}

	/**
	 * Integer
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function integer($input)
	{
		return ctype_digit((string) $input);
	}

	/**
	 * Less than
	 *
	 * @todo	Don't cast to int (max integer may be hit), check out string comparison of numbers
	 * @access	public
	 * @param	string
	 * @param	string|integer
	 * @return	bool
	 */
	public function less_than($input, $max)
	{
		return (int) $input < (int) $max;
	}

	/**
	 * Greater than
	 *
	 * @todo	Don't cast to int (max integer may be hit), check out string comparison of numbers
	 * @access	public
	 * @param	string
	 * @param	string|integer
	 * @return	bool
	 */
	public function greater_than($input, $max)
	{
		return (int) $input > (int) $max;
	}

	/**
	 * Equal to
	 *
	 * @access	public
	 * @param	string
	 * @param	mixed
	 * @return	bool
	 */
	public function equal_to($input, $str)
	{
		return trim((string) $input) === trim((string) $str);
	}

	/**
	 * Validate hex digits
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function hex($input)
	{
		return ctype_xdigit($input);
	}

	/**
	 * Validate hex colors
	 *
	 * @todo	Allow hash character?
	 * @todo	Allow 3 digits?
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	public function hex_color($input)
	{
		// $input = ltrim($input, '#');
		return self::hex($input) && strlen($input) === 6;
	}

	/**
	 * Check by field name if one field matches another
	 *
	 * @todo	Read from the form values, not $_POST directly
	 * @access	public
	 * @param	string
	 * @param	string	$field_name	The field name to check against
	 * @return	bool
	 */
	public function matches($input, $field_name)
	{
		$field_value = isset($_POST[$field_name]) ? $_POST[$field_name] : FALSE;
		return $input === $field_value;
	}

/* end class Validate */
}

/* end file */