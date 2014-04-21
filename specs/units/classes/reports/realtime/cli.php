<?php

namespace mageekguy\atoum\bdd\specs\units\reports\realtime;

use
	mageekguy\atoum,
	mageekguy\atoum\bdd,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd\specs,
	mageekguy\atoum\bdd\reports\realtime\cli as testedClass
;

class cli extends specs\units
{
	public function should_be_a_realtime_report()
	{
		$this->testedClass->isSubClassOf('mageekguy\atoum\reports\realtime');
	}

	public function should_construct()
	{
		$this->object(new testedClass());
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
			->if($report = new testedClass())
			->then
				->invoking->getFields()->on($report)
					->shouldReturn->array
						->contains($testEventsField)
						->contains(new bdd\report\fields\spec\event\cli())
		;
	}

	public function shouldHaveTestsFailuresEventsField()
	{
		$this
			->if($report = new testedClass())
			->then
				->invoking->getFields()->on($report)
					->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\failure())
		;
	}

	public function shouldHaveTestsExceptionsEventsField()
	{
		$this
			->if($report = new testedClass())
			->then
				->invoking->getFields()->on($report)
					->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\exception())
		;
	}

	public function shouldHaveTestsErrorsEventsField()
	{
		$this
			->if($report = new testedClass())
			->then
				->invoking->getFields()->on($report)
					->shouldReturn->array->contains(new bdd\report\fields\spec\event\fails\error())
		;
	}

	public function shouldHaveTestsSkippedEventsField()
	{
		$this
			->if($report = new testedClass())
			->then
				->invoking->getFields->on($report)
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
			->if($report = new testedClass())
			->then
				->invoking->getFields->on($report)
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
			->if($report = new testedClass())
			->then
				->invoking->getFields()->on($report)
					->shouldReturn->array->contains($runnerResultField)
		;
	}
}