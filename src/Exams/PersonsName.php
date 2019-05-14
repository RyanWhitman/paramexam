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
 * Attempt to get a person's name.
 */
class PersonsName extends \RyanWhitman\ParamExam\Exam {

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		$val = Helpers::trimFull($val);
		if (Helpers::isPersonsName($val))
			$result->setPassed($val);
	}
}