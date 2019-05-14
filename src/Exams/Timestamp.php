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
 * Attempt to get a timestamp.
 */
class Timestamp extends \RyanWhitman\ParamExam\Exam {

	/**
	 * The output format.
	 * @var string
	 */
	public $outputFormat = 'Y-m-d H:i:s';

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		if (Helpers::isTimestamp($val))
			$result->setPassed(date($this->outputFormat, $val));
	}
}