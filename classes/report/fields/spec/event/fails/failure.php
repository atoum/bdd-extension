<?php

namespace atoum\atoum\bdd\report\fields\spec\event\fails;

use
	atoum\atoum\test,
	atoum\atoum\cli,
	atoum\atoum\bdd\report,
	atoum\atoum\exceptions
;

class failure extends report\fields\spec\event\fails
{

	public function __construct(cli\colorizer $colorizer = null, cli\colorizer $detailColorizer = null, cli\prompt $prompt = null)
	{
		parent::__construct($colorizer, $detailColorizer, $prompt);

		$this->events = array(test::fail);
	}

	public function __toString()
	{
		$string = parent::__toString();

		if ($this->observable !== null)
		{
			$assertions = $this->observable->getScore()->getFailAssertions();

			foreach ($assertions as $assertion)
			{
				if ($assertion['class'] !== get_class($this->observable) || $assertion['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}

				$string .= '     ' . $this->colorizer->colorize('Failure: ') . $assertion['fail'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('File: ') . $assertion['file'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Line: ') . $assertion['line'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Asserter: ') . $assertion['asserter'] . PHP_EOL;
			}
		}

		return $string . $this->uncompleted;
	}
}
