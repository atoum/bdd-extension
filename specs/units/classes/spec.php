<?php

namespace atoum\atoum\bdd\specs\units;

use
	atoum\atoum,
	atoum\atoum\bdd\specs
;

class spec extends specs\units
{
	public function should_be_a_test()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\test');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_set_invoking_assertion_handler()
	{
		$this
			->given($manager = new \mock\atoum\atoum\test\assertion\manager())
			->when($this->testedInstance->setAssertionManager($manager))
			->then
				->mock($manager)
					->call('setHandler')->withArguments('invoking')->once()
		;
	}
}
