<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event;

use
	mageekguy\atoum\test,
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class uncompleted extends report\fields\spec\event
{

	public function __construct(prompt $prompt = null)
	{
		parent::__construct();

		$this->prompt = $prompt ?: new prompt('     Uncompleted:', new colorizer('1;37'));
		$this->events = array(test::uncompleted);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null)
		{
			$uncompleted = $this->observable->getScore()->getUncompletedMethods();

			foreach ($uncompleted as $method)
			{
				if ($method['class'] !== get_class($this->observable) || $method['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}

				$this->prompt->setValue('     Uncompleted (exit code: ' . $method['exitCode'] . '): ');

				$string .= $this->prompt . 'output(' . strlen($method['output']) . ') "' . $method['output'] . '"' . PHP_EOL;
			}
		}

		return $string;
	}
}
