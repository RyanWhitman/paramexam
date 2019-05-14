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
 * Attempt to get an alphanumeric value.
 */
class Alphanumeric extends \ParamExam\Exam {

	/**
	 * The case to check for. See the isAlphanumeric method.
	 * @var string
	 */
	public $case = 'ci';

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		if (Helpers::isAlphanumeric($val, $this->case))
			$result->setPassed($val);
	}
}