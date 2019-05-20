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
 * Attempt to get a boolean.
 */
class Boolean extends \RyanWhitman\ParamExam\Exam {

	/**
	 * If strict is true, the value must be true or false. Otherwise, similar values may be used (0, 1, n, y, etc.).
	 * @var boolean
	 */
	public $strict = false;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {
		if (!$this->strict) {
			if (in_array($val, ['false', 'off', 'no', 'n', '0', 0], true))
				$val = false;
			else if (in_array($val, ['true', 'on', 'yes', 'y', '1', 1], true))
				$val = true;
		}
		if (is_bool($val))
			$result->setPassed($val);
	}
}