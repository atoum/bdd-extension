<?php

namespace atoum\atoum\bdd\report\fields\spec;

use atoum\atoum\fs\path;
use
	atoum\atoum\test,
	atoum\atoum\report,
	atoum\atoum\exceptions
;

abstract class event extends report\fields\test\event
{
	private $reflectionMethodFactory;

	public function __construct()
	{
		parent::__construct();

		$this->setReflectionMethodFactory();
	}

	public function setReflectionMethodFactory($factory = null)
	{
		$this->reflectionMethodFactory = $factory ?: array(__CLASS__, 'reflectionMethodFactory');

		return $this;
	}

	public function getCurrentExample()
	{
		if ($this->observable !== null)
		{
			$example = preg_split('/(?:_+|(?=(?:[A-Z](?=[a-z])|(?<=[a-z])[A-Z])))/', $this->observable->getCurrentMethod());
			$example = array_filter($example);
			$example = array_map(
				function($v) {
					if (preg_match('/^[A-Z]{2,}$/', $v) === 0) {
						$v = strtolower($v);
					}

					return trim($v);
				},
				$example
			);

			return implode(' ', $example);
		}

		return null;
	}

	public function getCurrentFileAndLine()
	{
		if ($this->observable !== null)
		{
			$method = call_user_func_array($this->reflectionMethodFactory, array($this->observable, $this->observable->getCurrentMethod()));
			$path = new path($method->getFileName());

			return $path->getRelativePathFrom(new path(getcwd())) . ':' . $method->getStartLine();
		}

		return null;
	}

	private static function reflectionMethodFactory($classOrObject, $method)
	{
		return new \reflectionMethod($classOrObject, $method);
	}
}
