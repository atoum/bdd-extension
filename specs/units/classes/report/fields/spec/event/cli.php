<?php

namespace atoum\atoum\bdd\specs\units\report\fields\spec\event;

use
	atoum\atoum,
	atoum\atoum\bdd,
	atoum\atoum\report\fields\test,
	atoum\atoum\report\fields\runner,
	atoum\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_spec_field()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\bdd\report\fields\spec\event');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_add_a_new_line()
	{
		$this
			->given(
				$score = new \mock\atoum\atoum\score(),
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($test)->getScore = $score
			)
			->if($this->testedInstance->handleEvent(atoum\test::runStop, $test))
			->then
				->invoking->__toString
					->shouldReturn->string->isEqualTo(PHP_EOL)
		;
	}
}
