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
 * Attempt to get a value that contains only digits.
 */
class Digits extends \RyanWhitman\ParamExam\Exam {

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		if (Helpers::containsOnlyDigits($val))
			$result->setPassed($val);
	}
}