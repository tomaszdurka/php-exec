<?php

namespace PhpExecTests;

use PhpExec\Command;

class CommandTest extends \PHPUnit_Framework_TestCase {

    public function testCommandRunSuccess() {
        $command = new Command('ls');
        $result = $command->run();
        $this->assertTrue($result->isSuccess());
        $this->assertSame("CommandTest.php\n", $result->getOutput());
        $this->assertSame('', $result->getErrorOutput());
    }

    public function testCommandRunCommandNotFound() {
        $command = new Command('unknown-command');
        $result = $command->run();
        $this->assertFalse($result->isSuccess());
        $this->assertSame('', $result->getOutput());
        $this->assertSame("sh: unknown-command: command not found\n", $result->getErrorOutput());
    }
}
