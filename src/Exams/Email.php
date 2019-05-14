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
 * Attempt to get an email address.
 */
class Email extends \RyanWhitman\ParamExam\Exam {

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		$val = Helpers::sanitizeEmail($val);
		if (Helpers::isEmail($val))
			$result->setPassed($val);
	}
}