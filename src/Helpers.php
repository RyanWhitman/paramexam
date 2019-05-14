<?php
/**
 * @package RyanWhitman\ParamExam
 * @author Ryan Whitman <ryanawhitman@gmail.com>
 * @copyright Ryan Whitman (https://ryanwhitman.com)
 * @license https://opensource.org/licenses/MIT MIT
 * @link https://github.com/RyanWhitman/paramexam
 */

namespace RyanWhitman\ParamExam;

/**
 * A class for helper methods.
 */
abstract class Helpers {

	/**
	 * Get the value that's associated with the provided array key. The array key can belong to an indexed array, an associative array, or a multidimensional array. If the provided key does not exist, the $default value is returned instead. This method allows the developer to bypass "isset()."
	 *
	 * @param array $array The array to search.
	 * @param array|string $path A key, multiple keys in the format of an array, or multiple keys in the format of a string separated by a period(.).
	 * @param mixed $default The value to return when the key fails the "isset()" test.
	 * @return mixed The value that's associated with the provided key or the $default value when that key fails the "isset()" test.
	 */
	public static function arrayGet(array $array, $path, $default = NULL) {

		// If the path is not already an array, it's assumed to be a string in which the dot is the delimiter for array items.
		if (!is_array($path))
			$path = explode('.', $path);

		// Loop through each of the path parts. Keep going until either the array key is not found (return default) or the array loop has completed.
		foreach ($path as $part) {
			if (!array_key_exists($part, $array))
				return $default;
			$array = $array[$part];
		}

		// The array key must have been found. Return the value.
		return $array;
	}

	/**
	 * Set values in an array.
	 */
	public static function arraySet(array &$array, $path, $val) {
		if (!is_array($path))
			$path = explode('.', $path);
		$setArray = &$array;
		foreach ($path as $part)
			$setArray = &$setArray[$part];
		$setArray = $val;
	}

	/**
	 * Is the value an empty string?
	 * @return boolean
	 */
	public static function isEmptyString($val): bool {
		return is_string($val) && trim($val) === '';
	}

	/**
	 * Is the value NULL or an empty string?
	 * @return boolean
	 */
	public static function isNullOrEmptyString($val): bool {
		return is_null($val) || static::isEmptyString($val);
	}

	/**
	 * Trim all whitespace.
	 * @return string
	 */
	public static function trimFull(string $str): string {
		$str = trim($str);
		$str = preg_replace('/[ ]+(\s)/', '$1', $str);
		$str = preg_replace('/(\s)[ ]+/', '$1', $str);
		$str = preg_replace('/\0/', '', $str);
		$str = preg_replace('/(\n){2,}/', '$1$1', $str);
		$str = preg_replace('/\f/', '', $str);
		$str = preg_replace('/(\r){2,}/', '$1$1', $str);
		$str = preg_replace('/\t/', '', $str);
		$str = preg_replace('/(\v){2,}/', '$1$1', $str);
		return $str;
	}

	/**
	 * Remove text from the beginning of a string.
	 *
	 * @param string $textToRemove The text that is to be removed.
	 * @param string $strToEdit The string that is to have the text removed from it.
	 * @return string The modified string that has had the text removed from the beginning of it.
	 */
	public static function removeTextFromBeginning(string $textToRemove, string $strToEdit): string {
		if (substr($strToEdit, 0, strlen($textToRemove)) == $textToRemove)
			$strToEdit = substr($strToEdit, strlen($textToRemove));
		return $strToEdit;
	}

	/**
	 * Does the value only contain digits?
	 * @return boolean
	 */
	public static function containsOnlyDigits($val): bool {
		return is_int($val) || (is_string($val) && preg_match('/^[0-9]+$/', $val));
	}

	/**
	 * Is the value alphanumeric and does it match the correct case?
	 * @return boolean
	 */
	public static function isAlphanumeric(string $val, string $case = 'ci'): bool {
		if ($case == 'ci')
			return preg_match('/^[a-z0-9]+$/i', $val);
		else if ($case == 'lc')
			return preg_match('/^[a-z0-9]+$/', $val);
		else if ($case == 'uc')
			return preg_match('/^[A-Z0-9]+$/', $val);
		return false;
	}

	/**
	 * Is the value an email address?
	 * @return boolean
	 */
	public static function isEmail($email): bool {
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

	/**
	 * Attempt to convert a value into a valid email address.
	 */
	public static function sanitizeEmail($email): string {
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		return static::isEmail($email) ? $email : '';
	}

	/**
	 * Attempt to convert a set of values into valid email addresses.
	 */
	public static function sanitizeEmails($emails): array {
		$emails = (array) $emails;
		$validEmails = [];
		foreach ($emails as $email) {
			$email = static::sanitizeEmail($email);
			if (!empty($email))
				$validEmails[] = $email;
		}
		return $validEmails;
	}

	/**
	 * Is the value a person's name?
	 * @return boolean
	 */
	public static function isPersonsName(string $val): bool {
		return preg_match('/^[a-z][a-z`\',\.\- ]*$/i', $val);
	}

	/**
	 * Determine whether or not a value is a timestamp.
	 * @param mixed $val The value to evaluate.
	 * @return boolean
	 */
	public static function isTimestamp($val): bool {
		return (((is_int($val) || is_float($val)) ? $val : (string) (int) $val) === $val) && ((int) $val <= PHP_INT_MAX) && ((int) $val >= ~PHP_INT_MAX);
	}

	/**
	 * Determine whether or not the value is a valid currency.
	 * @param mixed $val The value to evaluate.
	 * @param bool $allowNegative Whether or not a negative currency should be allowed.
	 * @param bool $mustHave2Decimals Whether or not 2 decimals are required.
	 * @return boolean
	 */
	public static function isCurrency($val, bool $allowNegative = true, bool $mustHave2Decimals = true): bool {
		return preg_match('/^' . ($allowNegative ? '-?' : '') . '[0-9]+(?:\.[0-9]{' . ($mustHave2Decimals ? '2' : '1,') . '})' . ($mustHave2Decimals ? '' : '?') . '$/', $val) ? true : false;
	}
}