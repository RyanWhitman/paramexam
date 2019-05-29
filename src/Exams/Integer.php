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
 * Attempt to get an integer.
 */
class Integer extends \RyanWhitman\ParamExam\Exam {

	/**
	 * The minimum value or false if there is no minimum value.
	 *
	 * @var int|false
	 */
	public $minVal = false;

	/**
	 * The maximum value or false if there is no maximum value.
	 *
	 * @var int|false
	 */
	public $maxVal = false;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Ensure the value only contains digits.
		if (Helpers::containsOnlyDigits($val)) {

			// Cast the value as an integer.
			$val = (int) $val;

			// Ensure value is of the correct min/max limits.
			if (
				($this->minVal === false || $val >= $this->minVal) &&
				($this->maxVal === false || $val <= $this->maxVal)
			) {
				$result->setPassed($val);
			}
		}
	}
}