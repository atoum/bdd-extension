<?php

namespace mageekguy\atoum\bdd\specs\units\asserters;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd\specs,
	mageekguy\atoum\bdd\asserters\invoking as testedClass
;

class invoking extends specs\units
{
	public function should_be_an_atoum_asserter()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\asserter');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
	}

	public function should_use_provided_test()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getTestedClassName = 'mageekguy\atoum\test'
			)
			->if($asserter = new testedClass())
			->then
				->invoking('getTest')->on($asserter)
					->shouldReturn->variable->isNull()
				->invoking('setWithTest', $test)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
				->invoking('getTest')->on($asserter)
					->shouldReturn->object->isIdenticalTo($test)
		;
	}

	public function should_check_if_provided_method_exists()
	{
		$this
			->given(
				$phpClass = new \mock\mageekguy\atoum\asserters\phpClass(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = 'mageekguy\atoum\test'
			)
			->if(
				$asserter = new testedClass(null, $phpClass),
				$asserter->setWithTest($test)
			)
			->then
				->invoking('setMethod', $method = uniqid())->on($asserter)
					->shouldThrow('mageekguy\atoum\asserter\exception')
						->hasMessage(sprintf('Method %s::%s() does not exist', $testedClassName, $method))
					->mock($phpClass)
						->call('hasMethod')->withArguments($method)->once()

			->if($this->calling($phpClass)->hasMethod = $phpClass)
			->then
				->invoking('setMethod', $method)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
		;
	}

	public function should_invoke_method_on_provided_object_when_asserting_on_return_value()
	{
		$this
			->given(
				$phpClass = new \mock\mageekguy\atoum\asserters\phpClass(),
				$test = new \mock\mageekguy\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method = uniqid(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object)
			)
			->if(
				$asserter = new testedClass(null, $phpClass),
				$asserter
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
				->invoking('returns')->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
					->mock($object)
						->call($method)->once()
		;
	}

	public function should_do_lazy_assertion_on_return_value()
	{
		$this
			->given(
				$phpClass = new \mock\mageekguy\atoum\asserters\phpClass(),
				$test = new \mock\mageekguy\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method = $value = uniqid(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object)
			)
			->if(
				$asserter = new testedClass(null, $phpClass),
				$asserter
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
				->invoking('returns', $value)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
					->mock($object)
						->call($method)->once()
				->invoking('returns', uniqid())->on($asserter)
					->shouldThrow('mageekguy\atoum\asserter\exception')
		;
	}

	public function should_invoke_method_on_provided_object_and_return_exception_asserter_when_asserting_on_thrown_exception()
	{
		$this
			->given(
				$phpClass = new \mock\mageekguy\atoum\asserters\phpClass(),
				$test = new \mock\mageekguy\atoum\test(),
				$object = new \mock\dummy(),
				$object->getMockController()->disableMethodChecking(),
				$method = uniqid('A'),
				$this->calling($phpClass)->hasMethod = $phpClass,
				$this->calling($object)->$method->throw = $exception = new \exception(),
				$this->calling($test)->getTestedClassName = $testedClassName = get_class($object),
				$exceptionAsserter = new atoum\asserters\exception()
			)
			->if(
				$asserter = new testedClass(null, $phpClass),
				$asserter
					->setWithTest($test)
					->setMethod($method)
			)
			->then
				->invoking('setInstance', $object)->on($asserter)
					->shouldReturn->object->isIdenticalTo($asserter)
				->invoking('throws')->on($asserter)
					->shouldReturn->object->isEqualTo($exceptionAsserter->setWith($exception))
					->mock($object)
						->call($method)->once();
		;
	}
}