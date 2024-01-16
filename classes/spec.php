<?php

namespace atoum\atoum\bdd;

use atoum\atoum;
use atoum\atoum\bdd\asserters;
use atoum\atoum\test;

class spec extends atoum\test
{
	const defaultNamespace = '#(?:^|\\\)specs?(?:\\\(?:units?|bdd)?)?\\\#i';
	const defaultMethodPrefix = '#^(?:test|[^_]*_?should_?)#i';

	public function __get($property)
	{
		if (preg_match('/^invoking(.+)$/', $property, $matches) > 0)
		{
			$arguments = func_get_args();
			$arguments[0] = $matches[1];

			return call_user_func_array(array($this, 'invoking'), $arguments);
		}

		if ($property === 'testedInstance')
		{
			try
			{
				return parent::__get($property);
			}
			catch(atoum\exceptions\runtime $e)
			{
				return $this->newTestedInstance;
			}
		}

		return parent::__get($property);
	}

	public function __call($method, array $arguments)
	{
		if (preg_match('/^invoking(.+)$/', $method, $matches) > 0)
		{
			array_unshift($arguments, $matches[1]);

			return call_user_func_array(array($this, 'invoking'), $arguments);
		}

		return parent::__call($method, $arguments);
	}

	public function beforeTestMethod($testMethod)
	{
		$this->beforeExample($testMethod);
	}

	public function afterTestMethod($testMethod)
	{
		$this->afterExample($testMethod);
	}

	public function beforeExample($testMethod) {}

	public function afterExample($testMethod) {}

	public function setAssertionManager(test\assertion\manager $assertionManager = null)
	{
		$asserter = null;
		$spec = $this;

		parent::setAssertionManager($assertionManager)
			->getAssertionManager()
				->setHandler('invoking', function($method = null) use (& $asserter, $spec) {
						if ($asserter === null)
						{
							$asserter = new asserters\invoking($spec->getAsserterGenerator());
							$asserter->setWithTest($spec);
						}

						$asserter->reset();

						if ($method !== null)
						{
							$asserter->setMethod($method);
						}

						$arguments = func_get_args();
						array_shift($arguments);

						if (sizeof($arguments) > 0)
						{
							$asserter->setArguments($arguments);
						}

						return $asserter;
					}
				)
		;

		return $this;
	}
}
