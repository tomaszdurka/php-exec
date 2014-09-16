### PhpExec

Super-simple library for executing shell commands in php.

## Installation

Use composer:
```json
"require": {
  "tomaszdurka/php-exec": "~0.1.0"
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
Apart from basic usages you can listen for Command events to intercept specific events.
All possible events are listed in example:
```php
$command = new Command('ls');
$command->on('start', function($pid) {
}
$command->on('stdout', function($output) {
}
$command->on('stderr', function($error) {
}
$command->on('stop', function($exitCode) {
}
$result = $command->run();
```

