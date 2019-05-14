<?php
/**
 * @package RyanWhitman\ParamExam
 * @author Ryan Whitman <ryanawhitman@gmail.com>
 * @copyright Ryan Whitman (https://ryanwhitman.com)
 * @license https://opensource.org/licenses/MIT MIT
 * @link https://github.com/RyanWhitman/paramexam
 */

namespace RyanWhitman\ParamExam\Exams;

use RyanWhitman\ParamExam\Helpers;

/**
 * Attempt to get a value that contains some type of text.
 */
class Text extends \RyanWhitman\ParamExam\Exam {

	/**
	 * Should the trimFull method be run?
	 * @var boolean
	 */
	public $trimFull = false;

	/**
	 * The minimum length or false if there is no minimum length.
	 * @var int|false
	 */
	public $minLength = false;

	/**
	 * The maximum length or false if there is no maximum length.
	 * @var int|false
	 */
	public $maxLength = false;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Ensure the value is a string.
		if (is_string($val)) {

			// Trim the string.
			if ($this->trimFull)
				$val = Helpers::trimFull($val);

			// Ensure the value is of the correct length.
			$length = strlen($val);
			if (
				($this->minLength === false || $length >= $this->minLength) &&
				($this->maxLength === false || $length <= $this->maxLength)
			) {
				$result->setPassed($val);
			}
		}
	}
}