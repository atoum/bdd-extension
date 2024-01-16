<?php

namespace atoum\atoum\bdd\specs\units\report\fields\spec\run;

use
	atoum\atoum,
	atoum\atoum\bdd,
	atoum\atoum\report\fields\test,
	atoum\atoum\report\fields\runner,
	atoum\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_cli_field()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\report\fields\test\run\cli');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_display_tested_class_name()
	{
		$this
			->given(
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = uniqid()
			)
			->if($this->testedInstance->handleEvent(atoum\test::runStart, $test))
			->then
				->invoking->__toString
					->shouldReturn->string->isEqualTo($testedClassName . '...' . PHP_EOL)
		;
	}

	public function should_apply_style_to_displayed_tested_class_name()
	{
		$this
			->given(
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getTestedClassName = $testedClassName = uniqid(),
				$colorizer = new \mock\atoum\atoum\cli\colorizer(),
				$prompt = new \mock\atoum\atoum\cli\prompt()
			)
			->if(
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
