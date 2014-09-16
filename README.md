### PhpExec

Super-simple library for executing shell commands in php.

## Installation

Use composer:
```json
{
  "require": {
    "tomaszdurka/php-exec": "~0.1.0"
  }
}
```

## Code usage

```php
$command = new Command('ls');
$result = $command->run();

$result->isSuccess();
$result->getOutput();
$result->getExitCode();
$result->getErrorOutput();
```

## Events
Apart from basic usage you can listen to intercept specific Command events.
All possible events are listed in example below:
```php
$command = new Command('ls');
$command->on('start', function($pid) {
});
$command->on('stdout', function($output) {
});
$command->on('stderr', function($error) {
});
$command->on('stop', function($exitCode) {
});
$command->run();
```

