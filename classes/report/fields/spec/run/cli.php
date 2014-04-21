<?php

namespace mageekguy\atoum\bdd\report\fields\spec\run;

use
	mageekguy\atoum,
	mageekguy\atoum\report
;

class cli extends report\fields\test\run\cli
{
	protected $testedClassName;

	public function __toString()
	{
		return $this->prompt .
			(
				$this->testClass === null
				?
				$this->colorizer->colorize($this->locale->_('There is currently no test running.'))
				:
				sprintf($this->locale->_('%s...'), $this->colorizer->colorize($this->testedClassName))
			) .
			PHP_EOL
		;
	}

	public function handleEvent($event, atoum\observable $observable)
	{
		if (parent::handleEvent($event, $observable) === false)
		{
			return false;
		}

		$this->testedClassName = $observable->getTestedClassName();

		return parent::handleEvent($event, $observable);
	}
}
