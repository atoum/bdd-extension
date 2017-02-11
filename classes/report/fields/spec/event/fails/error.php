<?php

namespace mageekguy\atoum\bdd\report\fields\spec\event\fails;

use
	mageekguy\atoum\test,
	mageekguy\atoum\cli,
	mageekguy\atoum\bdd\report,
	mageekguy\atoum\exceptions
;

class error extends report\fields\spec\event\fails
{
	public function __construct(cli\colorizer $colorizer = null, cli\colorizer $detailColorizer = null, cli\prompt $prompt = null)
	{
		parent::__construct($colorizer, $detailColorizer, $prompt);

		$this->events = array(test::uncompleted, test::error);
	}

	public function __toString()
	{
		$string = parent::__toString();

		if ($this->observable !== null)
		{
			$errors = $this->observable->getScore()->getErrors();

			foreach ($errors as $error)
			{
				if ($error['class'] !== get_class($this->observable) || $error['method'] !== $this->observable->getCurrentMethod())
				{
					continue;
				}

				$string .= '     ' . $this->colorizer->colorize($error['type'] . ': ') . $error['message'] . PHP_EOL;

				if (($line = $error['file'] ?: $error['errorFile']) !== null)
				{
					$string .= '     ' . $this->colorizer->colorize('File: ') . ($error['file'] ?: $error['errorFile']) . PHP_EOL;
				}

				if (($line = $error['line'] ?: $error['errorLine']) !== null)
				{
					$string .= '     ' . $this->colorizer->colorize('Line: ') . ($error['line'] ?: $error['errorLine']) . PHP_EOL;
				}

			}
		}

		return $string . $this->uncompleted;
	}
}
