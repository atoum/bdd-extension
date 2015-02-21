<?php

namespace mageekguy\atoum\bdd;

use mageekguy\atoum;

atoum\autoloader::get()
	->addNamespaceAlias('atoum\bdd', __NAMESPACE__)
	->addClassAlias('atoum\spec', __NAMESPACE__ . '\\spec')
	->addClassAlias('atoum\bdd\spec', __NAMESPACE__ . '\\spec')
	->addClassAlias('mageekguy\atoum\spec', __NAMESPACE__ . '\\spec')
	->addDirectory(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR . 'classes');
;

require_once __DIR__ . '/specs/autoloader.php';
