<?php

namespace mageekguy\atoum\bdd\specs\units;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd\specs
;

class extension extends specs\units
{
	public function should_be_an_atoum_extension()
	{
		$this->testedClass->hasInterface('mageekguy\atoum\extension');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_construct_and_set_test_command_line_handlers()
	{
		$this
			->given(
				$script = new atoum\scripts\runner(uniqid()),
				$parser = new \mock\mageekguy\atoum\script\arguments\parser(),
				$configurator = new \mock\mageekguy\atoum\configurator($script),
				$script->setArgumentsParser($parser),
				$this->resetMock($parser)
			)
			->if($this->newTestedInstance($configurator))
			->then
				->mock($parser)
					->call('addHandler')->twice()
				->boolean($parser->argumentHasHandler('--test-it'))->isTrue()
				->boolean($parser->argumentHasHandler('--test-ext'))->isTrue()
		;
	}

	public function should_use_provided_runner()
	{
		$this
			->given($runner = new atoum\runner())
			->then
				->invoking->getRunner
					->shouldReturn->variable->isNull()
				->invoking->setRunner($runner)
					->shouldReturn->object->isTestedInstance
				->invoking->getRunner
					->shouldReturn->object->isIdenticalTo($runner)
		;
	}

	public function should_use_provided_test()
	{
		$this
			->given($test = new \mock\mageekguy\atoum\test())
			->then
				->invoking->getTest
					->shouldReturn->variable->isNull()
				->invoking->setTest($test)
					->shouldReturn->object->isTestedInstance
				->invoking->getTest
					->shouldReturn->object->isIdenticalTo($test)
		;
	}

	public function should_gracefully_ignore_events()
	{
		$this
			->invoking->handleEvent(uniqid(), new \mock\mageekguy\atoum\observable())
				->shouldReturn->object->isTestedInstance
		;
	}
}
