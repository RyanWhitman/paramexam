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
 * Attempt to get an array.
 */
class Array extends \RyanWhitman\ParamExam\Exam {

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		if (is_array($val))
			$result->setPassed($val);
	}
}