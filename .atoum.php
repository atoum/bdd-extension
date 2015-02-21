<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use mageekguy\atoum\bdd;

$runner->addExtension(new bdd\extension($script));
