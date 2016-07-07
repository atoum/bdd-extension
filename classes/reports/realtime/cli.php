<?php

namespace mageekguy\atoum\bdd\reports\realtime;

use
	mageekguy\atoum,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\reports\realtime,
	mageekguy\atoum\report\fields\test,
	mageekguy\atoum\report\fields\runner,
	mageekguy\atoum\bdd
;

class cli extends realtime
{
	public function __construct()
	{
		parent::__construct();

		$defaultColorizer = new colorizer(1);

		$firstLevelPrompt = new prompt('> ', $defaultColorizer);
		$secondLevelPrompt = new prompt('=> ', $defaultColorizer);

		$failureColorizer = new colorizer(31);
		$failurePrompt = clone $secondLevelPrompt;
		$failurePrompt->setColorizer($failureColorizer);

		$testRunField = new bdd\report\fields\spec\run\cli();
		$this
			->addField(
				$testRunField
					->setPrompt($firstLevelPrompt)
					->setColorizer($defaultColorizer)
			)
			->addField(new bdd\report\fields\spec\event\cli())
			->addField(new bdd\report\fields\spec\event\success())
			->addField(new bdd\report\fields\spec\event\fails\failure())
			->addField(new bdd\report\fields\spec\event\fails\exception())
			->addField(new bdd\report\fields\spec\event\fails\error())
			->addField(new bdd\report\fields\spec\event\blank())
			->addField(new bdd\report\fields\spec\event\skipped())
		;

		$resultField = new bdd\report\fields\runner\result\cli();
		$resultField
			->setSuccessColorizer(new colorizer('1;37;42'))
			->setFailureColorizer(new colorizer('1;37;41'))
		;
		$this->addField($resultField);

		$runnerOutputsField = new runner\outputs\cli();
		$runnerOutputsField
			->setTitlePrompt($firstLevelPrompt)
			->setTitleColorizer($defaultColorizer)
			->setMethodPrompt($secondLevelPrompt)
		;

		$this->addField($runnerOutputsField);

		/*$errorColorizer = new colorizer('0;33');
		$errorMethodPrompt = clone $secondLevelPrompt;
		$errorMethodPrompt->setColorizer($errorColorizer);
		$errorPrompt = clone $thirdLevelPrompt;
		$errorPrompt->setColorizer($errorColorizer);

		$skippedTestColorizer = new colorizer('0;90');
		$skippedTestMethodPrompt = clone $secondLevelPrompt;
		$skippedTestMethodPrompt->setColorizer($skippedTestColorizer);

		$runnerSkippedField = new runner\tests\skipped\cli();
		$runnerSkippedField
			->setTitlePrompt($firstLevelPrompt)
			->setTitleColorizer($skippedTestColorizer)
			->setMethodPrompt($skippedTestMethodPrompt)
		;

		$this->addField($runnerSkippedField);*/
	}
}
