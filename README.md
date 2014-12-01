# atoum Spec BDD extension [![Build Status](https://travis-ci.org/atoum/bdd-extension.svg?branch=master)](https://travis-ci.org/atoum/bdd-extension)

![atoum](http://downloads.atoum.org/images/logo.png)

## Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "require-dev": {
        "atoum/bdd-extension": "~1.0"
    }
}

```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use mageekguy\atoum\bdd;

$runner->addExtension(new bdd\extension($script));
```

## Use it

### Your first spec

The extension requires you to place your specs in a `specs` namespace and make them extend `atoum\spec`. Let's write a
spec for the `jubianchi\example\formatter` class:

```php
<?php
namespace jubianchi\example\specs;

use atoum;
use jubianchi\example\formatter as testedClass;

class formatter extends atoum\spec
{
    public function should_format_underscore_separated_method_name()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(__FUNCTION__)->on($formatter)
                    ->shouldReturn('should format underscore separated method name')
        ;
    }

    public function shouldFormatCamelCaseMethodName()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(__FUNCTION__)->on($formatter)
                    ->shouldReturn('should format camel case method name')
        ;
    }

    public function should_formatMixed__MethodName()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(__FUNCTION__)->on($formatter)
                    ->shouldReturn('should format mixed method name')
        ;
    }
}
```

### Running your first spec

```sh
$ vendor/bin/atoum -d specs
> jubianchi\example\formatter...
  ✘  should format camel case method name
     256: Tested class 'jubianchi\example\formatter' does not exist for test class 'jubianchi\example\specs\formatter'
     File: /atoum-bdd-extension/formatter.php
  ✘  should format underscore separated method name
     256: Tested class 'jubianchi\example\formatter' does not exist for test class 'jubianchi\example\specs\formatter'
     File: /atoum-bdd-extension/formatter.php
  ✘  should format mixed method name
     256: Tested class 'jubianchi\example\formatter' does not exist for test class 'jubianchi\example\specs\formatter'
     File: /atoum-bdd-extension/formatter.php

Failure (1 spec, 3/3 examples, 0 void example, 0 skipped example, 0 uncompleted example, 0 failure, 3 errors, 0 exception)!
```

And run it again until you get green:

```sh
$ vendor/bin/atoum -d specs
> jubianchi\example\formatter...
  ✔  should format underscore separated method name
  ✔  should format camel case method name
  ✔  should format mixed method name

Success (1 spec, 3/3 examples, 0 void example, 0 skipped example, 6 assertions)!
```

_You can use the `--loop` flag to work incrementally: `vendor/bin/atoum -d specs --loop`_

#### Reading the report

The spec report uses a set of icon to identify examples' statuses:

* `✘` to mark failed examples (error, exception or assertion failure)
* `✔` to mark passed examples
* `↣` to mark skipped examples
* `∅` to mark void examples (not implemented specs)

## Spec syntax

### Invoking methods

Invoking a method is the process of calling a method on a tested object in a way that will allow the tester to assert
on method behavior:

```php
<?php
namespace jubianchi\example\specs;

use atoum;
use jubianchi\example\formatter as testedClass;

class formatter extends atoum\spec
{
    public function should_invoke_method()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(__FUNCTION__)->on($formatter)
                    // ...
        ;
    }
}
```

This example will invoke the `format` method of the `$formatter` object with one argument, `__FUNCTION__`.

There are several way of invoking method, depending on which syntax you prefer:

```php
$this->invoking->format(__FUNCTION__)->on($formatter);
$this->invoking('format', __FUNCTION__)->on($formatter);
$this->invokingFormat(__FUNCTION__)->on($formatter);
```

### Asserting on returned values

The spec extension provides some shortcut to assert on method return value.

```php
<?php
namespace jubianchi\example\specs;

use atoum;
use jubianchi\example\formatter as testedClass;

class formatter extends atoum\spec
{
    public function should_format_underscore_separated_method_name()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(__FUNCTION__)->on($formatter)
                    ->shouldReturn('should format underscore separated method name')
        ;
    }
}
```

As you can see, `shouldReturn` lets you assert on invoked method return value. Again, there are several way of doing the
same:

```php
$this->invoking->format(__FUNCTION__)->on($formatter)->shouldReturn('...');
$this->invoking->format(__FUNCTION__)->on($formatter)->returns('...');
$this->invoking->format(__FUNCTION__)->on($formatter)->should->return('...');
```

Calling `shouldReturn` with a parameter will fallback on the `atoum\asserters\variable::isEqual` assertion which is the
less strict one in atoum. You can of course use strict assertions to do some type checking:

```php
$this->invoking->format(__FUNCTION__)->on($formatter)->shouldReturn->string->isEuqlaTo('...')
```

### Asserting on thrown exceptions

Asserting on exception is quite simple and similar to asserting on returned values:

```php
<?php
namespace jubianchi\example\specs;

use atoum;
use jubianchi\example\formatter as testedClass;

class formatter extends atoum\spec
{
    public function should_format_underscore_separated_method_name()
    {
        $this
            ->given($formatter = new testedClass())
            ->then
                ->invoking->format(uniqid())->on($formatter)
                    ->shouldThrow('invalidArgumentException')
        ;
    }
}
```

As for `shouldReturn`, `shouldThrow` provides some alternative synatxes:

```php
$this->invoking->format(__FUNCTION__)->on($formatter)->shouldThrow('exception');
$this->invoking->format(__FUNCTION__)->on($formatter)->throws('exception');
$this->invoking->format(__FUNCTION__)->on($formatter)->should->throw('exception');
```

Calling `shouldThrow` this way will fallback on `atoum\asserters\exception::isInstanceOf`, if you don't want to check
the exception type, you can simple omit the argument:

```php
$this->invoking->format(__FUNCTION__)->on($formatter)->shouldThrow;
$this->invoking->format(__FUNCTION__)->on($formatter)->throws;
$this->invoking->format(__FUNCTION__)->on($formatter)->should->throw;
```

Of course, you can also check the exception message using regular assertions:

```php
$this->invoking->format(__FUNCTION__)->on($formatter)->shouldThrow->hasMessage('...');
$this->invoking->format(__FUNCTION__)->on($formatter)->throws('invalidArgumentException')->hasMessage('...');
```
