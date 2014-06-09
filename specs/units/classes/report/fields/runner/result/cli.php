<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\runner\result;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_runner_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\report\fields\runner\result');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_display_a_message_when_there_is_no_test()
	{
		$this
			->invoking->__toString()
				->shouldReturn->string->isEqualTo('No test running.' . PHP_EOL)
		;
	}

	public function should_display_success_message()
	{
		$this
			->given($runner = new atoum\runner())
			->if($this->testedInstance->handleEvent(atoum\runner::runStop, $runner))
			->then
				->invoking->__toString()
					->shouldReturn->string->isEqualTo('Success (0 spec, 0/0 example, 0 void example, 0 skipped example, 0 assertion)!' . PHP_EOL)
		;
	}

	public function should_apply_style_to_success_message()
	{
		$this
			->given(
				$runner = new atoum\runner(),
				$colorizer = new \mock\mageekguy\atoum\cli\colorizer(),
				$prompt = new \mock\mageekguy\atoum\cli\prompt()
			)
			->if(
				$this->testedInstance
					->setPrompt($prompt)
					->setSuccessColorizer($colorizer)
					->handleEvent(atoum\runner::runStop, $runner)
			)
			->when($this->testedInstance->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments('Success (0 spec, 0/0 example, 0 void example, 0 skipped example, 0 assertion)!')->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}

	public function should_display_failure_message()
	{
		$this
			->given(
				$runner = new \mock\mageekguy\atoum\runner(),
				$score = new \mock\mageekguy\atoum\runner\score(),
				$this->calling($runner)->getScore = $score,
				$this->calling($runner)->getTestNumber = 1,
				$this->calling($runner)->getTestMethodNumber = 1,
				$this->calling($score)->getAssertionNumber = 1,
				$this->calling($score)->getFailNumber = 1
			)
			->if($this->testedInstance->handleEvent(atoum\runner::runStop, $runner))
			->then
				->invoking->__toString()
					->shouldReturn->string->isEqualTo('Failure (1 spec, 1/1 example, 0 void example, 0 skipped example, 0 uncompleted example, 1 failure, 0 error, 0 exception)!' . PHP_EOL)
		;
	}

	public function should_apply_style_to_failure_message()
	{
		$this
			->given(
				$runner = new \mock\mageekguy\atoum\runner(),
				$colorizer = new \mock\mageekguy\atoum\cli\colorizer(),
				$prompt = new \mock\mageekguy\atoum\cli\prompt(),
				$score = new \mock\mageekguy\atoum\runner\score(),
				$this->calling($runner)->getScore = $score,
				$this->calling($runner)->getTestNumber = 1,
				$this->calling($runner)->getTestMethodNumber = 1,
				$this->calling($score)->getAssertionNumber = 1,
				$this->calling($score)->getFailNumber = 1
			)
			->if(
				$this->testedInstance
					->setPrompt($prompt)
					->setFailureColorizer($colorizer)
					->handleEvent(atoum\runner::runStop, $runner)
			)
			->when($this->testedInstance->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments('Failure (1 spec, 1/1 example, 0 void example, 0 skipped example, 0 uncompleted example, 1 failure, 0 error, 0 exception)!')->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}