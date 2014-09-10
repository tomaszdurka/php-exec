<?php

namespace PhpExecTests;

use PhpExec\Command;

class CommandTest extends \PHPUnit_Framework_TestCase {

    public function testCommandRunSuccess() {
        $command = new Command('ls');
        $this->assertSame("CommandTest.php\n", $command->run());
    }

    /**
     * @expectedException \PhpExec\Exception
     * @expectedExceptionMessage Command `unknown-command` failed
     */
    public function testCommandRunCommandNotFound() {
        $command = new Command('unknown-command');
        $command->run();
    }
}
