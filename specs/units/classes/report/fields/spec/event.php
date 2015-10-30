<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs
;

class event extends specs\units
{
	public function should_be_a_test_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\report\fields\test\event');
	}

	public function should_provide_example_name_from_underscore_methods_()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $firstPart = __FUNCTION__
			)
			->if($this->testedInstance->handleEvent(atoum\test::runStart, $test))
			->then
				->invoking->getCurrentExample
					->shouldReturn->string->isEqualTo(implode(' ', explode('_', __FUNCTION__)))
		;
	}

	public function shouldProvideExampleNameFromCamelCaseMethods($actual, $expected)
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $actual
			)
			->if($this->testedInstance->handleEvent(atoum\test::runStart, $test))
			->then
				->invoking->getCurrentExample
					->shouldReturn->string->isEqualTo($expected)
		;
	}

	protected function shouldProvideExampleNameFromCamelCaseMethodsDataProvider()
	{
		return array(
			array('shouldBeOK', 'should be OK'),
			array('ShouldBeOK', 'should be OK'),
			array('shouldTestAString', 'should test a string'),
			array('should_be_OK', 'should be OK'),
			array('should_test_a_string', 'should test a string'),
			array('should_OLO', 'should OLO'),
			array('YOLO', 'YOLO'),
			array('should_contain_ABBR', 'should contain ABBR'),
			array('should_be_💪', 'should be 💪'),
			array(__FUNCTION__, implode(' ', array_map('strtolower', preg_split('/(?=[A-Z])/', __FUNCTION__))))
		);
	}
}
