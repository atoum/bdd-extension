<?php

namespace mageekguy\atoum\bdd\specs\units\report\fields\spec\event;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs
;

class void extends specs\units
{
	public function should_be_a_spec_field()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\bdd\report\fields\spec\event');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_display_void_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getVoidMethods = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod
					)
				),
				$this->calling($test)->getScore = $score
			)
			->if($this->testedInstance->handleEvent(atoum\test::void, $test))
			->then
				->invoking->__toString
					->shouldReturn->string->isEqualTo('  ∅  ' . $currentMethod . PHP_EOL)
		;
	}

	public function should_apply_style_to_displayed_example_name()
	{
		$this
			->given(
				$score = new \mock\mageekguy\atoum\score(),
				$test = new \mock\mageekguy\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getVoidMethods = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod
					)
				),
				$this->calling($test)->getScore = $score,
				$prompt = new \mock\mageekguy\atoum\cli\prompt(),
				$colorizer = new \mock\mageekguy\atoum\cli\colorizer()
			)
			->if(
				$this->newTestedInstance($colorizer, $prompt),
				$this->testedInstance->handleEvent(atoum\test::void, $test)
			)
			->when($this->testedInstance->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments($currentMethod)->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}