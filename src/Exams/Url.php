<?php
/**
 * @package RyanWhitman\ParamExam
 * @author Ryan Whitman <ryanawhitman@gmail.com>
 * @copyright Ryan Whitman (https://ryanwhitman.com)
 * @license https://opensource.org/licenses/MIT MIT
 * @link https://github.com/RyanWhitman/paramexam
 */

namespace RyanWhitman\ParamExam\Exams;

/**
 * Attempt to get a URL.
 */
class Url extends \RyanWhitman\ParamExam\Exam {

	/**
	 * The minimum length or false if there is no minimum length.
	 *
	 * @var int|false
	 */
	public $minLength = false;

	/**
	 * The maximum length or false if there is no maximum length.
	 *
	 * @var int|false
	 */
	public $maxLength = false;

	/**
	 * The validation flag.
	 *
	 * @var null|string
	 */
	public $validateFlag = NULL;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Prepare the value.
		$val = trim(filter_var($val, FILTER_SANITIZE_URL));

		// Ensure the value is of the correct length.
		$length = strlen($val);
		if (
			($this->minLength !== false && $length < $this->minLength) ||
			($this->maxLength !== false && $length > $this->maxLength)
		) {
			return $result->setFailed('invalid_length');
		}

		// Validate the URL.
		if (filter_var($val, FILTER_VALIDATE_URL, $this->validateFlag))
			$result->setPassed($val);
	}
}