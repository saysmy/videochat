<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $test = new Test('test');
        $test->id = 1;
        $test->text = 'xxxx';
        var_export($test->validate());
        var_export($test->getErrors());
    }
}   
