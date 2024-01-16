<?php

namespace atoum\atoum\bdd\report\fields\spec\event;

use
	atoum\atoum\test,
	atoum\atoum\bdd\report,
	atoum\atoum\exceptions
;

class cli extends report\fields\spec\event
{
	public function __construct()
	{
		parent::__construct();

		$this->events = array(
			test::runStop,
			test::runtimeException
		);
	}

	public function __toString()
	{
		$string = '';

		if ($this->observable !== null)
		{
			$string = PHP_EOL;
		}

		return $string;
	}
}
