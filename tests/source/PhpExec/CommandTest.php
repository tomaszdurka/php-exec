<?php

namespace PhpExecTests;

use PhpExec\Command;

class CommandTest extends \PHPUnit_Framework_TestCase {

    public function testCommandRunSuccess() {
        $command = new Command('ls');
        $result = $command->run();
        $this->assertTrue($result->isSuccess());
        $this->assertSame("CommandTest.php\n", $result->getOutput());
        $this->assertNull($result->getErrorOutput());
    }

    public function testCommandRunCommandNotFound() {
        $command = new Command('unknown-command');
        $result = $command->run();
        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getOutput());
        $this->assertSame("sh: unknown-command: command not found\n", $result->getErrorOutput());
    }

    public function testCommandRunIntervalOutput() {
        $command = new Command('bash', ['-c', 'echo -n foo; sleep 1; echo -n bar;']);
        $eventTriggerCount = 0;
        $command->on('stdout', function ($output) use (&$eventTriggerCount) {
            $eventTriggerCount++;
            if (1 === $eventTriggerCount) {
                $this->assertSame('foo', $output);
            }
            if (2 === $eventTriggerCount) {
                $this->assertSame('bar', $output);
            }
        });
        $result = $command->run();
        $this->assertTrue($result->isSuccess());
    }
}
