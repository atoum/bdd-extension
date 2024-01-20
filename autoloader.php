<?php

namespace atoum\atoum\bdd;

use atoum\atoum;

atoum\autoloader::get()
	->addNamespaceAlias('atoum\bdd', __NAMESPACE__)
	->addClassAlias('atoum\spec', __NAMESPACE__ . '\\spec')
	->addClassAlias('atoum\bdd\spec', __NAMESPACE__ . '\\spec')
	->addClassAlias('atoum\atoum\spec', __NAMESPACE__ . '\\spec')
	->addDirectory(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR . 'classes');
;
