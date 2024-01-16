<?php

namespace atoum\atoum\bdd\specs\units\report\fields\spec\event\fails;

use
	atoum\atoum,
	atoum\atoum\bdd,
	atoum\atoum\report\fields\test,
	atoum\atoum\report\fields\runner,
	atoum\atoum\bdd\specs
;

class exception extends specs\units
{
	public function should_be_a_spec_fail_field()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\bdd\report\fields\spec\event\fails');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function should_display_errored_example_name()
	{
		$this
			->given(
				$score = new \mock\atoum\atoum\score(),
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getExceptions = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'value' => ($firstLine = uniqid()) . PHP_EOL . ($secondLine = uniqid()) . PHP_EOL . ($thirdLine = uniqid())
					)
				),
				$this->calling($test)->getScore = $score,
				$this->mockGenerator->orphanize('__construct'),
				$method = new \mock\reflectionMethod(),
				$this->calling($method)->getFileName = $currentFile = uniqid(),
				$this->calling($method)->getStartLine = $currentLine = rand(0, PHP_INT_MAX)
			)
			->if(
				$this->testedInstance->setReflectionMethodFactory(function() use ($method) {
						return $method;
					}
				),
				$this->testedInstance->handleEvent(atoum\test::exception, $test)
			)
			->then
				->invoking->__toString
					->shouldReturn->string->isEqualTo('  ✘  ' . $currentMethod . ' (./' . $currentFile . ':' . $currentLine . ')' . PHP_EOL . '     Exception: ' . $firstLine . PHP_EOL . '     ' . $secondLine . PHP_EOL . '       ' . $thirdLine . PHP_EOL)
		;
	}

	public function should_apply_style_to_displayed_example_name()
	{
		$this
			->given(
				$score = new \mock\atoum\atoum\score(),
				$test = new \mock\atoum\atoum\test(),
				$this->calling($test)->getCurrentMethod = $currentMethod = uniqid(),
				$this->calling($score)->getExceptions = array(
					array(
						'class' => get_class($test),
						'method' => $currentMethod,
						'value' => ($firstLine = uniqid()) . PHP_EOL . ($secondLine = uniqid()) . PHP_EOL . uniqid()
					)
				),
				$this->calling($test)->getScore = $score,
				$this->mockGenerator->orphanize('__construct'),
				$method = new \mock\reflectionMethod(),
				$this->calling($method)->getFileName = $currentFile = uniqid(),
				$this->calling($method)->getStartLine = $currentLine = rand(0, PHP_INT_MAX),
				$prompt = new \mock\atoum\atoum\cli\prompt(),
				$colorizer = new \mock\atoum\atoum\cli\colorizer()
			)
			->if(
				$this->newTestedInstance($colorizer, $colorizer, $prompt),
				$this->testedInstance->setReflectionMethodFactory(function() use ($method) {
						return $method;
					}
				),
				$this->testedInstance->handleEvent(atoum\test::exception, $test)
			)
			->when($this->testedInstance->__toString())
			->then
				->mock($colorizer)
					->call('colorize')->withArguments($currentMethod)->once()
					->call('colorize')->withArguments('(./' . $currentFile . ':' . $currentLine . ')')->once()
					->call('colorize')->withArguments('Exception: ')->once()
					->call('colorize')->withArguments($secondLine)->once()
				->mock($prompt)
					->call('__toString')->once()
		;
	}
}
