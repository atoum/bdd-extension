<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event\fails;

use
	mageekguy\atoum\test,
	mageekguy\atoum\cli,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class exception extends report\fields\spec\event\fails
{

	public function __construct(cli\colorizer $colorizer = null, cli\colorizer $detailColorizer = null, cli\prompt $prompt = null)
	{
		parent::__construct($colorizer, $detailColorizer, $prompt);

		$this->events = array(test::exception);
	}

	public function __toString()
	{
		$string = parent::__toString();

		if ($this->observable !== null)
		{
			$exceptions = $this->observable->getScore()->getExceptions();

			foreach ($exceptions as $exception)
			{
				if ($exception['class'] !== get_class($this->observable) || $exception['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}

				$lines = explode(PHP_EOL, $exception['value']);

				$string .= '     ' . $this->colorizer->colorize('Exception: ') . array_shift($lines) . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize(array_shift($lines));

				foreach ($lines as $line)
				{
					$string .= PHP_EOL . '       ' . $line;
				}

				$string .= PHP_EOL;
			}
		}

		return $string . $this->uncompleted;
	}
}
