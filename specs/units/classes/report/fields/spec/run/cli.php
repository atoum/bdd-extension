<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\run;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs,
	mageekguy\atoum\bdd\report\fields\spec\run\cli as testedClass
;

class cli extends specs\units
{
	public function should_be_a_cli_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\report\fields\test\run\cli');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
	}

	public function should_display_tested_class_name()
	{
		$this
			->given(
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = uniqid()
			)
			->if(
				$field = new testedClass(),
				$field->handleEvent(atoum\test::runStart, $test)
			)
			->then
				->invoking->__toString->on($field)
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
				$field = new testedClass(),
				$field
					->setColorizer($colorizer)
					->setPrompt($prompt)
					->handleEvent(atoum\test::runStart, $test)
			)
			->when($field->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments($testedClassName)->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}