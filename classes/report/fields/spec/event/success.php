<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event;

use
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\test,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class success extends report\fields\spec\event
{
	public function __construct(colorizer $colorizer = null, $detailColorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(32);
		$this->detailColorizer = $detailColorizer ?: new colorizer(30);
		$this->prompt = $prompt ?: new prompt('  ✔ ', new colorizer('1;37', 42));
		$this->events = array(test::success);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null && $this->event === test::success)
		{
			$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . ' ' . $this->detailColorizer->colorize('(' . $this->getCurrentFileAndLine() . ')') . PHP_EOL;
		}

		return $string;
	}
}
