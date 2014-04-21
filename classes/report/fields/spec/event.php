<?php

namespace mageekguy\atoum\bdd\report\fields\spec;

use
	mageekguy\atoum\test,
	mageekguy\atoum\report,
	mageekguy\atoum\exceptions
;

abstract class event extends report\fields\test\event
{
	public function getCurrentExample()
	{
		if ($this->observable !== null)
		{
			$example = preg_split('/(?:_+|(?=[A-Z]))/', $this->observable->getCurrentMethod());
			$example = array_filter($example, function($v) { return trim($v) !== ''; });
			$example = array_map(function($v) { return strtolower(trim($v)); }, $example);

			return implode(' ', array_map(function($v) { return strtolower(trim($v)); }, $example));
		}

		return null;
	}
}
