<?php

namespace atoum\atoum\bdd\specs\units\reports\realtime;

use
	atoum\atoum,
	atoum\atoum\bdd,
	atoum\atoum\cli\prompt,
	atoum\atoum\cli\colorizer,
	atoum\atoum\report\fields\test,
	atoum\atoum\report\fields\runner,
	atoum\atoum\bdd\specs
;

class cli extends specs\units
{
	public function should_be_a_realtime_report()
	{
		$this->testedClass->isSubClassOf('atoum\atoum\reports\realtime');
	}

	public function should_construct()
	{
		$this->newTestedInstance;
	}

	public function shouldHaveTestsEventsFields()
	{
		$this
			->given(
				$testEventsField = new bdd\report\fields\spec\run\cli(),
				$testEventsField
					->setPrompt(new prompt('> ', $defaultColorizer = new colorizer(1)))
					->setColorizer($defaultColorizer)
			)
			->then
				->invoking->getFields
					->shouldReturn->array
						->contains($testEventsField)
						->contains(new bdd\report\fields\spec\event\cli())
		;
	}

	public function shouldHaveTestsFailuresEventsField()
	{
		$this
			->invoking->getFields
				->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\failure())
		;
	}

	public function shouldHaveTestsExceptionsEventsField()
	{
		$this
			->invoking->getFields
				->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\exception())
		;
	}

	public function shouldHaveTestsErrorsEventsField()
	{
		$this
			->invoking->getFields
				->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\error())
		;
	}

	public function shouldHaveTestsSkippedEventsField()
	{
		$this
			->invoking->getFields
				->shouldReturn->array->contains(new bdd\report\fields\spec\event\skipped())
		;
	}

	public function shouldHaveTestsOutputsEventsField()
	{
		$this
			->given(
				$runnerOutputsField = new runner\outputs\cli(),
				$runnerOutputsField
					->setTitlePrompt(new prompt('> ', $defaultColorizer = new colorizer(1)))
					->setTitleColorizer($defaultColorizer)
					->setMethodPrompt(new prompt('=> ', $defaultColorizer))
			)
			->then
				->invoking->getFields
					->shouldReturn->array->contains($runnerOutputsField)
		;
	}

	public function shouldHaveRunnerResultField()
	{
		$this
			->given(
				$runnerResultField = new bdd\report\fields\runner\result\cli(),
				$runnerResultField
					->setSuccessColorizer(new colorizer('1;37;42'))
					->setFailureColorizer(new colorizer('1;37;41'))
			)
			->then
				->invoking->getFields()
					->shouldReturn->array->contains($runnerResultField)
		;
	}
}
