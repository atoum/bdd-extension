<?php

namespace mageekguy\atoum\bdd\asserters;

use mageekguy\atoum;
use mageekguy\atoum\asserter;
use mageekguy\atoum\exceptions;
use mageekguy\atoum\asserters;

class invoking extends atoum\asserter
{
	protected $phpClass;
	protected $test;
	protected $testedClassName;
	protected $testedInstance;
	protected $testedMethodName;
	protected $testedMethodArguments;
	protected $actualValue;
	protected $actualException;

	public function __construct(asserter\generator $generator = null, asserters\phpClass $phpClass = null)
	{
		$this->phpClass = $phpClass ?: new asserters\phpClass();

		parent::__construct($generator);
	}

	public function __call($method, $arguments)
	{
		switch(strtolower($method))
		{
			case 'on':
				$this->setInstance(array_shift($arguments));

			case 'should':
				return $this->methodIsSet();

			case 'return':
			case 'shouldreturn':
				return call_user_func_array(array($this, 'returns'), $arguments);

			case 'throw':
			case 'shouldthrow':
			case 'throwexception':
			case 'shouldthrowexception':
				return call_user_func_array(array($this, 'throws'), $arguments);

			default:
				if ($this->testedMethodName === null)
				{
					return $this->setMethod($method)->setArguments($arguments);
				}
		}

		return parent::__call($method, $arguments);
	}

	public function __get($property)
	{
		switch(strtolower($property))
		{
			case 'should':
			case 'return':
			case 'shouldreturn':
			case 'throw':
			case 'shouldthrow':
			case 'throwexception':
			case 'shouldthrowexception':
				return $this->__call($property, array());

			case 'returns':
			case 'throws':
				return call_user_func_array(array($this, $property), array());

			default:
				try
				{
					return $this->__call($property, array($this->actualValue));
				}
				catch (\exception $e)
				{
					return parent::__get($property);
				}
		}
	}

	public function reset()
	{
		parent::reset();

		$this->testedMethodArguments = array();
		$this->testedMethodName = null;
	}

	public function setWithTest(atoum\test $test)
	{
		$this->reset();

		$this->test = $test;
		$this->testedClassName = $test->getTestedClassName();

		$this->phpClass->setWith($this->testedClassName);

		return parent::setWithTest($test);
	}

	public function getTest()
	{
		return $this->test;
	}

	public function setMethod($method)
	{
		$this->testedMethodName = $method;

		try
		{
			$this->phpClass->hasMethod($this->testedMethodName);

			$this->pass();
		}
		catch (asserter\exception $exception)
		{
			$this->fail($exception->getMessage());
		}

		return $this->setArguments();
	}

	public function setInstance($instance)
	{
		if ($instance instanceof $this->testedClassName === false)
		{
			throw new exceptions\logic\invalidArgument('Argument passed to ' . __METHOD__ . ' should be an instance of ' . $this->testedClassName);
		}

		$this->testedInstance = $instance;

		return $this;
	}

	public function setArguments(array $arguments = null)
	{
		$this->methodIsSet()->testedMethodArguments = $arguments ?: array();

		return $this;
	}

	public function returns($mixed = null)
	{
		$this->testedInstanceIsSet()->methodIsSet()->actualValue = call_user_func_array(array($this->testedInstance, $this->testedMethodName), $this->testedMethodArguments);

		if ($mixed !== null)
		{
			$this->variable($this->actualValue)->isEqualTo($mixed);
		}

		return $this;
	}

	public function throws($exception = null)
	{
		$testedInstance = $this->testedInstance;
		$testedMethodName = $this->testedMethodName;
		$testedMethodArguments = $this->testedMethodArguments;

		$asserter = $this->testedInstanceIsSet()->methodIsSet()->exception(
			function() use ($testedInstance, $testedMethodName, $testedMethodArguments) {
				call_user_func_array(array($testedInstance, $testedMethodName), $testedMethodArguments);
			}
		);

		if ($exception !== null)
		{
			$asserter->isInstanceOf($exception);
		}

		return $asserter;
	}

	protected function methodIsSet($message = 'Method is undefined')
	{
		if ($this->testedMethodName === null)
		{
			throw new exceptions\logic($message);
		}

		return $this;
	}

	protected function testedInstanceIsSet($message = 'Tested instance is undefined')
	{
		if ($this->testedInstance === null)
		{
			throw new exceptions\logic($message);
		}

		return $this;
	}
} 