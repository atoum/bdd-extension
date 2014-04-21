<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event;

use
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\test,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class skipped extends report\fields\spec\event
{
	public function __construct(colorizer $colorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(34);
		$this->prompt = $prompt ?: new prompt('  ↣ ', new colorizer('1;37', 44));
		$this->events = array(test::skipped);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null)
		{
			$skips = $this->observable->getScore()->getSkippedMethods();

			foreach ($skips as $method)
			{
				if ($method['class'] !== get_class($this->observable) || $method['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}

				$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Skipped: ') . $method['message'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('File: ') . $method['file'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Line: ') . $method['line'] . PHP_EOL;
			}
		}

		return $string;
	}
}
