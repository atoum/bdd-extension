<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\event;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_spec_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\bdd\report\fields\spec\event');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_add_a_new_line()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
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