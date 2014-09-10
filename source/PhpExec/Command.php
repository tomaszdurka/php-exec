<?php

namespace PhpExec;

use Evenement\EventEmitter;

class Command {

    /** @var string */
    private $_command;

    /** @var string[] */
    private $_arguments;

    /** @var EventEmitter */
    private $_eventEmitter;

    /**
     * @param string   $command
     * @param string[] $arguments
     */
    public function __construct($command, array $arguments = null) {
        $this->_command = (string) $command;
        $this->_arguments = (array) $arguments;
        $this->_eventEmitter = new EventEmitter();
    }

    /**
     * @param string   $event
     * @param \Closure $callback
     */
    public function on($event, \Closure $callback) {
        $this->_eventEmitter->on($event, $callback);
    }

    /**
     * @param string|null $input
     * @throws Exception
     * @return Result
     */
    public function run($input = null) {
        $command = $this->_getCommand();
        $descriptorSpec = [
            0 => ["pipe", "r"], 1 => ["pipe", "w"], 2 => ["pipe", "w"]
        ];
        $process = proc_open($command, $descriptorSpec, $pipes);
        if (!is_resource($process)) {
            throw new Exception('Cannot open command file pointer to `' . $command . '`');
        }

        if (null !== $input) {
            fwrite($pipes[0], (string) $input);
        }
        fclose($pipes[0]);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $returnStatus = proc_close($process);
        return new Result($this, $returnStatus, $stdout, $stderr);
    }

    /**
     * @return string
     */
    protected function _getCommand() {
        $command = escapeshellcmd($this->_command);
        foreach ($this->_arguments as $argument) {
            $command .= ' ' . escapeshellarg($argument);
        }
        return $command;
    }
}
