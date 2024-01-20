<?php

namespace atoum\atoum\bdd\report\fields\spec\event;

use
	atoum\atoum,
	atoum\atoum\cli\colorizer,
	atoum\atoum\cli\prompt,
	atoum\atoum\test,
	atoum\atoum\bdd\report,
	atoum\atoum\exceptions
;

class fails extends report\fields\spec\event
{
	protected $colorizer;
	protected $detailColorizer;
	protected $prompt;
	protected $uncompleted;

	public function __construct(colorizer $colorizer = null, $detailColorizer = null, prompt $prompt = null)
	{
		parent::__construct();

		$this->colorizer = $colorizer ?: new colorizer(31);
		$this->detailColorizer = $detailColorizer ?: new colorizer(30);
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
			$string = $this->prompt . ' ' . $this->colorizer->colorize($this->getCurrentExample()) . ' ' . $this->detailColorizer->colorize('(' . $this->getCurrentFileAndLine() . ')') . PHP_EOL;
		}

		return $string;
	}
}
