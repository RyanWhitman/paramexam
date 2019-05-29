<?php
/**
 * @package RyanWhitman\ParamExam
 * @author Ryan Whitman <ryanawhitman@gmail.com>
 * @copyright Ryan Whitman (https://ryanwhitman.com)
 * @license https://opensource.org/licenses/MIT MIT
 * @link https://github.com/RyanWhitman/paramexam
 */

namespace RyanWhitman\ParamExam;

use RyanWhitman\ParamExam\Exam;
use Exception;

/**
 * An exam result.
 */
class Result {

	/**
	 * The exam.
	 *
	 * @var Exam
	 */
	private $exam;

	/**
	 * Whether or not the exam passed.
	 *
	 * @var boolean
	 */
	private $passed = false;

	/**
	 * The exam error.
	 *
	 * @var string
	 */
	private $error = 'invalid';

	/**
	 * The successful value after passing an exam.
	 *
	 * @var mixed
	 */
	private $val;

	/**
	 * Whether or not a result has been finalized.
	 *
	 * @var boolean
	 */
	private $isFinal = false;

	/**
	 * Create a new Result instance.
	 *
	 * @param Exam $exam The exam this result is based on.
	 */
	public function __construct(Exam $exam) {
		$this->exam = $exam;
	}

	/**
	 * Get the exam this result is based on.
	 *
	 * @return Exam
	 */
	public function getExam(): Exam {
		return $this->exam;
	}

	/**
	 * Has this result been finalized?
	 *
	 * @return boolean
	 */
	public function isFinal(): bool {
		return $this->isFinal;
	}

	/**
	 * Ensure the result has not already been finalized.
	 *
	 * @throws Exception Throws an exception if the result has already been finalized.
	 */
	private function ensureNotAlreadyFinalized() {
		if ($this->isFinal())
			throw new Exception('This result has already been finalized.');
	}

	/**
	 * Finalize a result.
	 */
	public function finalize() {
		$this->ensureNotAlreadyFinalized();
		$this->isFinal = true;
	}

	/**
	 * Set an exam as having passed.
	 *
	 * @param mixed $val The successful value.
	 */
	public function setPassed($val = NULL) {
		$this->ensureNotAlreadyFinalized();
		$this->passed = true;
		$this->val = $val;
	}

	/**
	 * Set an exam as having failed.
	 *
	 * @param mixed $error The error.
	 */
	public function setFailed($error = NULL) {
		$this->ensureNotAlreadyFinalized();
		$this->passed = false;
		if (!is_null($error))
			$this->error = $error;
	}

	/**
	 * Did the exam pass?
	 *
	 * @return boolean
	 */
	public function passed(): bool {
		return $this->passed;
	}

	/**
	 * Get the exam error.
	 *
	 * @return mixed The error or NULL if the exam passed.
	 */
	public function getError() {
		return $this->passed() ? NULL : $this->error;
	}

	/**
	 * Get the exam value.
	 *
	 * @return mixed The value or NULL if the exam failed.
	 */
	public function getVal() {
		return $this->passed() ? $this->val : NULL;
	}
}