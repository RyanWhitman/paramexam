<?php
/**
 * @package RyanWhitman\ParamExam
 * @author Ryan Whitman <ryanawhitman@gmail.com>
 * @copyright Ryan Whitman (https://ryanwhitman.com)
 * @license https://opensource.org/licenses/MIT MIT
 * @link https://github.com/RyanWhitman/paramexam
 */

namespace RyanWhitman\ParamExam;

use RyanWhitman\ParamExam\Result;

/**
 * The exam blueprint.
 */
abstract class Exam {

	/**
	 * Is a value required?
	 * @var boolean
	 */
	private $isReqd;

	/**
	 * If the value doesn't exists, what is the default value?
	 * @var mixed
	 */
	private $default;

	/**
	 * Can an empty string be provided?
	 * @var boolean
	 */
	private $emptyStringable;

	/**
	 * The character mask, or false if strings should not be trimmed.
	 * @var string|false
	 */
	protected $trimString = ' ';

	/**
	 * Create a new Exam instance.
	 * @param boolean $isReqd Is a value required?
	 * @param mixed $default If the value doesn't exists, what is the default value?
	 * @param boolean $emptyStringable Can an empty string be provided?
	 */
	public function __construct(bool $isReqd = true, $default = NULL, bool $emptyStringable = false) {
		$this->isReqd = $isReqd;
		$this->default = $default;
		$this->emptyStringable = $emptyStringable;
		$this->init();
	}

	/**
	 * A method that gets run during the exam instantiation.
	 */
	protected function init() {}

	/**
	 * A shortcut method for creating a new exam instance that is required.
	 * @return self The exam instance.
	 */
	public static function reqd(): self {
		return new static(true);
	}

	/**
	 * A shortcut method for creating a new exam instance that is optional.
	 * @return self The exam instance.
	 */
	public static function opt(): self {
		return new static(false);
	}

	/**
	 * A shortcut method for creating a new exam instance that has a default value.
	 * @param mixed $default The default value.
	 * @return self The exam instance.
	 */
	public static function default($default): self {
		return new static(true, $default);
	}

	/**
	 * A shortcut method for creating a new exam instance that can contain an empty string.
	 * @return self The exam instance.
	 */
	public static function emptyStringable(): self {
		return new static(false, NULL, true);
	}

	/**
	 * Run the exam.
	 * @param mixed $val The value to examine.
	 * @return Result The result.
	 */
	public function runNonStatic($val): Result {

		// If the value is that of a result object that previously passed this exam, return it instead of running the exam again.
		if ($val instanceof Result && $val->isFinal() && get_class($val->getExam()) === get_class($this))
			return $val;

		// Create a new result object.
		$result = new Result($this);

		// Find the default value, if applicable.
		if (Helpers::isNullOrEmptyString($val) && !Helpers::isNullOrEmptyString($this->default))
			$val = $this->default;

		// If the value is required and the it is either null or an empty string, record the failure.
		if ($this->isReqd && Helpers::isNullOrEmptyString($val))
			$result->setFailed('nonExistent');
		else {

			// If the value is null, skip it since it passed the 'required check' above.
			if (is_null($val))
				$result->setPassed();
			else {

				// If the value is just an empty string and the "emptyStringable" prop was set, just trim it and leave it be.
				if (Helpers::isEmptyString($val) && $this->emptyStringable)
					$result->setPassed(trim($val));

				// The value has a value of some sort and empty strings are disallowed, so run it through the filter.
				else {

					// Trim strings.
					if (is_string($val) && $this->trimString !== false)
						$val = trim($val, $this->trimString);

					// Run the filter.
					$this->filter($val, $result);
				}
			}
		}

		// Finalize the result.
		$result->finalize();

		// Return the result.
		return $result;
	}

	/**
	 * A shortcut method for creating and running the exam.
	 * @param mixed $val The value to examine.
	 * @return Result The result.
	 */
	public static function runStatic($val): Result {
		return static::reqd()->run($val);
	}

	/**
	 * The param filter.
	 * @param mixed $val The value to filter.
	 * @param Result $result A Result instance.
	 */
	protected function filter($val, Result $result) {}

	/**
	 * A magic method that allows any method to be called non-statically.
	 */
	public function __call(string $method, array $args = []) {
		$method = $method . 'NonStatic';
		if (method_exists($this, $method))
			return $this->{$method}(...$args);
	}

	/**
	 * A magic method that allows any method to be called statically.
	 */
	public static function __callStatic(string $method, array $args = []) {
		$method = $method . 'Static';
		if (method_exists(static::class, $method)) {
			return static::{$method}(...$args);
		}
	}
}