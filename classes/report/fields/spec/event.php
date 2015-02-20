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
			$example = preg_split('/(?:_+|(?=[A-Z](?![A-Z]|$)))/', $this->observable->getCurrentMethod());
			$example = array_filter($example);
			$example = array_map(
                function($v) {
                    if (preg_match('/^[A-Z]+$/', $v) === 0) {
                        $v = strtolower($v);
                    }

                    return trim($v);
                },
                $example
            );

			return implode(' ', $example);
		}

		return null;
	}
}
