<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $test = new Test('test');
        var_export($test->getAttributes());
    }
}   
