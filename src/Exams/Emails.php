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
 * Attempt to get multiple email addresses.
 */
class Emails extends \RyanWhitman\ParamExam\Exam {

	/**
	 * Must all of the submitted email addresses be valid?
	 * @var boolean
	 */
	public $allValid = true;

	/**
	 * @inheritDoc
	 */
	protected function filter($val, $result) {

		// Ensure $val is an array
		$val = (array) $val;

		// Get the initial email address count.
		$initialCount = count($val);

		// Reduce the email address array to only contain legitimate email addresses.
		$val = Helpers::sanitizeEmails($val);

		// Get the refined email address count.
		$refinedCount = count($val);

		// if 'allValid' is set to false, then ensure at least 1 legitimate email address was provided.
		if (!$this->allValid) {
			if ($refinedCount == 0) {
				$result->setFailed('noneValid');
				return;
			}
		}

		// If 'allValid' is set to true, then the initial count must be the same as the refined count.
		else {
			if ($refinedCount != $initialCount) {
				$result->setFailed('someInvalid');
				return;
			}
		}

		// The value contains a valid set of email addresses.
		$result->setPassed($val);
	}
}