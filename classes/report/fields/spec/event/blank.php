<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event;

use
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\test,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class blank extends report\fields\spec\event
{

	public function __construct(colorizer $colorizer = null, $detailColorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(34);
		$this->detailColorizer = $detailColorizer ?: new colorizer(30);
		$this->prompt = $prompt ?: new prompt('  ∅ ', new colorizer('1;37', 44));
		$this->events = array(test::void);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null)
		{
			$voids = $this->observable->getScore()->getVoidMethods();

			foreach ($voids as $method)
			{
				if ($method['class'] !== get_class($this->observable) || $method['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}
				
				$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . ' ' . $this->detailColorizer->colorize('(' . $this->getCurrentFileAndLine() . ')') . PHP_EOL;
			}
		}

		return $string;
	}
}
