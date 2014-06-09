<?php

namespace mageekguy\atoum\bdd\specs\units;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd\specs
;

class spec extends specs\units
{
	public function should_be_a_test()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\test');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_set_invoking_assertion_handler()
	{
		$this
			->given($manager = new \mock\mageekguy\atoum\test\assertion\manager())
			->when($this->testedInstance->setAssertionManager($manager))
			->then
				->mock($manager)
					->call('setHandler')->withArguments('invoking')->once()
		;
	}
}