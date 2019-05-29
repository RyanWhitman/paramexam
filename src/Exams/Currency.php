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
 * Attempt to get a currency.
 */
class Currency extends \RyanWhitman\ParamExam\Exam {

	/**
	 * The minimum value or false if there is no minimum value.
	 *
	 * @var int|float|false
	 */
	public $minVal = false;

	/**
	 * The maximum value or false if there is no maximum value.
	 *
	 * @var int|float|false
	 */
	public $maxVal = false;

	/**
	 * Should a negative value be allowed?
	 *
	 * @var boolean
	 */
	public $allowNegative = true;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Strip the value of a leading dollar sign.
		$val = Helpers::removeTextFromBeginning('$', $val);

		// Trim the value again.
		$val = trim($val);

		// Ensure the value is a currency.
		if (Helpers::isCurrency($val, $this->allowNegative, false)) {

			// Convert the value to a float and round it to 2 decimals.
			$val = round((float) $val, 2);

			// Ensure the value is still a currency and ensure the value is of the correct min/max limits.
			if (
				Helpers::isCurrency($val, $this->allowNegative, false) &&
				($this->minVal === false || $val >= $this->minVal) &&
				($this->maxVal === false || $val <= $this->maxVal)
			) {
				$result->setPassed($val);
			}
		}
	}
}