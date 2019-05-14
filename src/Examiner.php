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
use RyanWhitman\ParamExam\Helpers;
use Exception;

/**
 * The Examiner is used for examining multiple parameters at a time.
 */
class Examiner {

	/**
	 * The input.
	 * @var array
	 */
	private $input = [];

	/**
	 * The exam results.
	 * @var array
	 */
	private $results = [];

	/**
	 * Create a new Examiner instance.
	 * @param array $input An array of input that will be examined.
	 */
	public function __construct(array $input) {
		$this->input = $input;
	}

	/**
	 * A shortcut method for creating a new Examiner instance.
	 * @param array $input An array of input that will be examined.
	 * @return self The examiner instance.
	 */
	public static function input(array $input): self {
		return new static($input);
	}

	/**
	 * Convert a parameter to a different name.
	 * @param string $fromParam The existing parameter name.
	 * @param string $toParam The new parameter name.
	 * @param boolean $force If false, the parameter will only be converted if the new name doesn't already exist.
	 * @return self The examiner instance.
	 */
	public function convertParam(string $fromParam, string $toParam, bool $force = false): self {
		$fromParamVal = Helpers::arrayGet($this->input, $fromParam);
		if (!is_null($fromParamVal) && ($force || is_null(Helpers::arrayGet($this->input, $toParam))))
			Helpers::arraySet($this->input, $toParam, $fromParamVal);
		Helpers::arraySet($this->input, $fromParam, NULL);
		return $this;
	}

	/**
	 * Run an exam.
	 * @param string $param The parameter name to run the exam on.
	 * @param string $exam The exam class name.
	 * @param boolean $isReqd Is the value required?
	 * @param mixed $default The default value to use when the parameter doesn't exist.
	 * @param boolean $emptyStringable Can the parameter just contain an empty string?
	 * @return self The examiner instance.
	 */
	private function run(string $param, string $exam, bool $isReqd, $default = NULL, bool $emptyStringable = false): self {

		// If a valid exam class name was passed in, instantiate a new exam.
		if (class_exists($exam))
			$exam = new $exam($isReqd, $default, $emptyStringable);

		// Ensure the exam is valid.
		if (!$exam instanceof Exam)
			throw new Exception('An invalid exam was attempted.');

		// Run the exam and store the result.
		$result = $exam->run(Helpers::arrayGet($this->input, $param));
		$this->results[$param] = $result;

		// Return the Examiner instance.
		return $this;
	}

	/**
	 * A shortcut method for running an exam on a required parameter.
	 * @see run() method
	 */
	public function reqd(string $param, string $exam): self {
		return $this->run($param, $exam, true);
	}

	/**
	 * A shortcut method for running an exam on an optional parameter.
	 * @see run() method
	 */
	public function opt(string $param, string $exam): self {
		return $this->run($param, $exam, false);
	}

	/**
	 * A shortcut method for running an exam on a parameter that has a default value.
	 * @see run() method
	 */
	public function default(string $param, string $exam, $default): self {
		return $this->run($param, $exam, true, $default);
	}

	/**
	 * A shortcut method for running an exam on a parameter that allows empty strings.
	 * @see run() method
	 */
	public function emptyStringable(string $param, string $exam): self {
		return $this->run($param, $exam, false, NULL, true);
	}

	/**
	 * Have all of the exams passed?
	 * @return boolean
	 */
	public function passed(): bool {
		foreach ($this->results as $result) {
			if (!$result->passed())
				return false;
		}
		return true;
	}

	/**
	 * Get all of the errors associated with this Examiner instance.
	 * @return array The errors.
	 */
	public function getErrors(): array {
		$errors = [];
		foreach ($this->results as $param => $result) {
			$error = $result->getError();
			if (!is_null($error))
				Helpers::arraySet($errors, $param, $error);
		}
		return $errors;
	}

	/**
	 * Get all of the successful values associated with this Examiner instance.
	 * @return array The values.
	 */
	public function getVals(): array {
		$vals = [];
		foreach ($this->results as $param => $result) {
			$val = $result->getVal();
			if (!is_null($val))
				Helpers::arraySet($vals, $param, $val);
		}
		return $vals;
	}
}