<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\event\fails;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs,
	mageekguy\atoum\bdd\report\fields\spec\event\fails\failure as testedClass
;

class failure extends specs\units
{
	public function should_be_a_spec_fail_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\bdd\report\fields\spec\event\fails');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
	}

	public function should_display_failed_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getFailAssertions = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'fail' => $message = uniqid(),
						'line' => $line = rand(1, PHP_INT_MAX),
						'file' => $file = uniqid(),
						'asserter' => $asserter = uniqid(),
					)
				),
				$this->calling($test)->getScore = $score
			)
			->if(
				$field = new testedClass(),
				$field->handleEvent(atoum\test::fail, $test)
			)
			->then
				->invoking->__toString->on($field)
					->shouldReturn->string->isEqualTo('  ✘  ' . $currentMethod . PHP_EOL . '     Failure: ' . $message . PHP_EOL . '     File: ' . $file . PHP_EOL . '     Line: ' . $line . PHP_EOL . '     Asserter: ' . $asserter . PHP_EOL)
		;
	}

	public function should_apply_style_to_displayed_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getFailAssertions = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'fail' => $message = uniqid(),
						'line' => $line = rand(1, PHP_INT_MAX),
						'file' => $file = uniqid(),
						'asserter' => $asserter = uniqid(),
					)
				),
				$this->calling($test)->getScore = $score,
				$prompt = new \mock\mageekguy\atoum\cli\prompt(),
				$colorizer = new \mock\mageekguy\atoum\cli\colorizer()
			)
			->if(
				$field = new testedClass($colorizer, $prompt),
				$field->handleEvent(atoum\test::fail, $test)
			)
			->when($field->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments($currentMethod)->once()
					->call('colorize')->withArguments('Failure: ')->once()
					->call('colorize')->withArguments('File: ')->once()
					->call('colorize')->withArguments('Line: ')->once()
					->call('colorize')->withArguments('Asserter: ')->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}