<?php

namespace atoum\atoum\bdd\specs\units\asserters;

use
	atoum\atoum,
	atoum\atoum\bdd\specs
;

class invoking extends specs\units
{
	public function should_be_an_atoum_asserter()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\asserter');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_use_provided_test()
	{
		$this
			->given(
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getTestedClassName = 'atoum\atoum\test'
			)
			->if($this->newTestedInstance)
			->then
				->invoking('getTest')
					->shouldReturn->variable->isNull()
				->invoking('setWithTest', $test)
					->shouldReturn->object->isTestedInstance
				->invoking('getTest')
					->shouldReturn->object->isIdenticalTo($test)
		;
	}

	public function should_check_if_provided_method_exists()
	{
		$this
			->given(
				$phpClass = new \mock\atoum\atoum\asserters\phpClass(),
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = 'atoum\atoum\test'
			)
			->if(
				$this->newTestedInstance(null, $phpClass),
				$this->testedInstance->setWithTest($test)
			)
			->then
				->invoking('setMethod', $method = uniqid())
					->shouldThrow('atoum\atoum\asserter\exception')
						->hasMessage(sprintf('%s::%s() does not exist', $testedClassName, $method))
					->mock($phpClass)
						->call('hasMethod')->withArguments($method)->once()

			->if($this->calling($phpClass)->hasMethod = $phpClass)
			->then
				->invoking('setMethod', $method)
					->shouldReturn->object->isTestedInstance
		;
	}

	public function should_invoke_method_on_provided_object_when_asserting_on_return_value()
	{
		$this
			->given(
				$phpClass = new \mock\atoum\atoum\asserters\phpClass(),
				$test = new \mock\atoum\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method = uniqid(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object)
			)
			->if(
				$this->newTestedInstance(null, $phpClass),
				$this->testedInstance
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)
					->shouldReturn->object->isTestedInstance
				->invoking('returns')
					->shouldReturn->object->isTestedInstance
					->mock($object)
						->call($method)->once()
		;
	}

	public function should_do_lazy_assertion_on_return_value()
	{
		$this
			->given(
				$phpClass = new \mock\atoum\atoum\asserters\phpClass(),
				$test = new \mock\atoum\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method = $value = uniqid(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object)
			)
			->if(
				$this->newTestedInstance(null, $phpClass),
				$this->testedInstance
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)
					->shouldReturn->object->isTestedInstance
			->if($this->testedInstance->setInstance($object))
			->then
				->invoking('returns', $value)
					->shouldReturn->object->isTestedInstance
					->mock($object)
						->call($method)->once()
			->if($this->testedInstance->setInstance($object))
			->then
				->invoking('returns', uniqid())
					->shouldThrow('atoum\atoum\asserter\exception')
		;
	}

	public function should_invoke_method_on_provided_object_and_return_exception_asserter_when_asserting_on_thrown_exception()
	{
		$this
			->given(
				$generator = new atoum\asserter\generator(),
				$phpClass = new \mock\atoum\atoum\asserters\phpClass($generator),
				$test = new \mock\atoum\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method->throw = $exception = new \exception(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object),
				$exceptionAsserter = new atoum\asserters\exception($generator)
			)
			->if(
				$this->newTestedInstance($generator, $phpClass),
				$this->testedInstance
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)
					->shouldReturn->object->isTestedInstance
				->invoking('throws')
					->shouldReturn->object->isEqualTo($exceptionAsserter->setWith($exception))
					->mock($object)
						->call($method)->once();
		;
	}
}
