<?php

namespace mageekguy\atoum\bdd\specs\units;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd\spec as testedClass
;

class spec extends atoum\spec
{
	public function should_be_a_test()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\test');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
	}

	public function should_set_invoking_assertion_handler()
	{
		$this
			->given($manager = new \mock\mageekguy\atoum\test\assertion\manager())
			->if($test = new testedClass())
			->when($test->setAssertionManager($manager))
			->then
				->mock($manager)
					->call('setHandler')->withArguments('invoking')->once()
		;
	}
}