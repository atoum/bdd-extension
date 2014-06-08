<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\run;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_cli_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\report\fields\test\run\cli');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_display_tested_class_name()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = uniqid()
			)
			->if(
				$this->newTestedInstance,
				$this->testedInstance->handleEvent(atoum\test::runStart, $test)
			)
			->then
				->invoking->__toString
					->shouldReturn->string->isEqualTo($testedClassName . '...' . PHP_EOL)
		;
	}

	public function should_apply_style_to_displayed_tested_class_name()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = uniqid(),
				$colorizer = new \mock\mageekguy\atoum\cli\colorizer(),
				$prompt = new \mock\mageekguy\atoum\cli\prompt()
			)
			->if(
				$this->newTestedInstance,
				$this->testedInstance
					->setColorizer($colorizer)
					->setPrompt($prompt)
					->handleEvent(atoum\test::runStart, $test)
			)
			->when($this->testedInstance->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments($testedClassName)->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}