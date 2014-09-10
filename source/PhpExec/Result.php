<?php

namespace PhpExec;

class Result {

    /** @var Command */
    private $_command;

    /** @var int */
    private $_exitCode;

    /** @var string */
    private $_output;

    /** @var string */
    private $_error;

    /**
     * @param Command     $command
     * @param int         $exitCode
     * @param string|null $output
     * @param string|null $error
     */
    public function __construct(Command $command, $exitCode, $output, $error) {
        $this->_command = $command;
        $this->_exitCode = (int) $exitCode;

        if (null !== $output) {
            $this->_output = (string) $output;
        }
        if (null !== $error) {
            $this->_error = (string) $error;
        }
    }

    /**
     * @return bool
     */
    public function isSuccess() {
        return 0 === $this->_exitCode;
    }

    /**
     * @return string
     */
    public function getOutput() {
        return $this->_output;
    }

    /**
     * @return string
     */
    public function getErrorOutput() {
        return $this->_error;
    }
}
