<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event;

use
	mageekguy\atoum,
	mageekguy\atoum\cli\colorizer,
	mageekguy\atoum\cli\prompt,
	mageekguy\atoum\test,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class fails extends report\fields\spec\event
{
	protected $colorizer;
	protected $prompt;
	protected $uncompleted;

	public function __construct(colorizer $colorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(31);
		$this->prompt = $prompt ?: new prompt('  ✘ ', new colorizer('1;37', 41));
		$this->uncompleted = new uncompleted();
		$this->events = array(
			test::fail,
			test::error,
			test::exception,
			test::uncompleted
		);
	}

	public function handleEvent($event, atoum\observable $observable)
	{
		$this->uncompleted->handleEvent($event, $observable);

		return parent::handleEvent($event, $observable);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null)
		{
			$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . PHP_EOL;
		}

		return $string;
	}
}
