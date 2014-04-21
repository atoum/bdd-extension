<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\event;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs,
	mageekguy\atoum\bdd\report\fields\spec\event\uncompleted as testedClass
;

class uncompleted extends specs\units
{
	public function should_be_a_spec_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\bdd\report\fields\spec\event');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
	}

	public function should_display_void_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getUncompletedMethods = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'exitCode' => $exitCode = rand(1, PHP_INT_MAX),
						'output' => $output = uniqid()
					)
				),
				$this->calling($test)->getScore = $score
			)
			->if(
				$field = new testedClass(),
				$field->handleEvent(atoum\test::uncompleted, $test)
			)
			->then
				->invoking->__toString->on($field)
					->shouldReturn->string->isEqualTo('     Uncompleted (exit code: ' . $exitCode . '): output(' . strlen($output) . ') "' . $output . '"' . PHP_EOL)
		;
	}

	public function should_append_prompt_to_displayed_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getUncompletedMethods = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'exitCode' => $exitCode = rand(1, PHP_INT_MAX),
						'output' => $output = uniqid()
					)
				),
				$this->calling($test)->getScore = $score,
				$prompt = new \mock\mageekguy\atoum\cli\prompt()
			)
			->if(
				$field = new testedClass($prompt),
				$field->handleEvent(atoum\test::uncompleted, $test)
			)
			->when($field->__toString())
			->then
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}