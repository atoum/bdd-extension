<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs,
	mock\mageekguy\atoum\bdd\report\fields\spec\event as testedClass
;

class event extends specs\units
{
	public function should_be_a_test_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\report\fields\test\event');
	}

	public function should_provide_example_name_from_underscore_methods()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $firstPart = __FUNCTION__
			)
			->if(
				$field = new testedClass(),
				$field->handleEvent(atoum\test::runStart, $test)
			)
			->then
				->invoking->getCurrentExample->on($field)
					->shouldReturn->string->isEqualTo(implode(' ', explode('_', __FUNCTION__)))
		;
	}

	public function shouldProvideExampleNameFromCamelCaseMethods()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $firstPart = __FUNCTION__
			)
			->if(
				$field = new testedClass(),
				$field->handleEvent(atoum\test::runStart, $test)
			)
			->then
				->invoking->getCurrentExample->on($field)
					->shouldReturn->string->isEqualTo(implode(' ', array_map('strtolower', preg_split('/(?=[A-Z])/', __FUNCTION__))))
		;
	}
}