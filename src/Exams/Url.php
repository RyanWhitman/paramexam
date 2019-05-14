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
	 * The validation flag.
	 * @var null|string
	 */
	public $validateFlag = NULL;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Prepare the value.
		$val = trim(filter_var($val, FILTER_SANITIZE_URL));

		// Validate the URL.
		if (filter_var($val, FILTER_VALIDATE_URL, $this->validateFlag))
			$result->setPassed($val);
	}
}