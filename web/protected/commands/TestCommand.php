<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $test = New Test();
        $test->id = 1;
        $test->save();
        var_export($test->getErrors());
    }
}   
