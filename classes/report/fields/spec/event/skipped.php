<?php

namespace atoum\atoum\bdd\report\fields\spec\event;

use
	atoum\atoum\cli\colorizer,
	atoum\atoum\cli\prompt,
	atoum\atoum\test,
	atoum\atoum\bdd\report,
	atoum\atoum\exceptions
;

class skipped extends report\fields\spec\event
{
    protected $colorizer = null;
    protected $detailColorizer = null;
    protected $prompt = null;

	public function __construct(colorizer $colorizer = null, $detailColorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(34);
		$this->detailColorizer = $detailColorizer ?: new colorizer(30);
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

				$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . ' ' . $this->detailColorizer->colorize('(' . $this->getCurrentFileAndLine() . ')') . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Skipped: ') . $method['message'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('File: ') . $method['file'] . PHP_EOL;
				$string .= '     ' . $this->colorizer->colorize('Line: ') . $method['line'] . PHP_EOL;
			}
		}

		return $string;
	}
}
