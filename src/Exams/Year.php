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
 * Attempt to get a year.
 */
class Year extends \RyanWhitman\ParamExam\Exam {

	/**
	 * The year length.
	 * @var integer
	 */
	public $length = 4;

	/**
	 * The minimum year or false if there is no minimum year.
	 * @var int|false
	 */
	public $minYear = false;

	/**
	 * The maximum year or false if there is no maximum year.
	 * @var int|false
	 */
	public $maxYear = false;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Ensure the value only contains digits, is of the correct length, and meets the min/max requirements.
		if (
			Helpers::containsOnlyDigits($val) &&
			strlen($val) == $this->length &&
			($this->minYear === false || $val >= $this->minYear) &&
			($this->maxYear === false || $val <= $this->maxYear)
		) {
			$result->setPassed($val);
		}
	}
}