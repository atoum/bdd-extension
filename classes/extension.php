<?php

namespace atoum\atoum\bdd;

use atoum\atoum;
use atoum\atoum\observable;
use atoum\atoum\runner;

class extension implements atoum\extension
{
	protected $runner;
	protected $test;

	public function __construct(atoum\configurator $configurator = null)
	{
		if ($configurator)
		{
			$configurator->getScript()->setDefaultReportFactory(function($script) {
				$report = new reports\realtime\cli();
				$report->addWriter($script->getOutputWriter());

				return $report;
			});

			$parser = $configurator->getScript()->getArgumentsParser();

			$handler = function($script, $argument, $values) {
				$script->getRunner()->addTestsFromDirectory(dirname(__DIR__) . '/specs/units/classes');
			};

			$parser
				->addHandler($handler, array('--test-ext'))
				->addHandler($handler, array('--test-it'))
			;
		}
	}

	public function addToRunner(runner $runner)
	{
		$runner->addExtension($this);

		return $this;
	}

	public function setRunner(runner $runner)
	{
		$this->runner = $runner;

		return $this;
	}

	public function getRunner()
	{
		return $this->runner;
	}

	public function setTest(atoum\test $test)
	{
		$this->test = $test;

		return $this;
	}

	public function getTest()
	{
		return $this->test;
	}

	public function handleEvent($event, observable $observable)
	{
		return $this;
	}
}
