<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $test = new Test;
        $test->text = '';
        $test->save();
        var_export($test->getErrors());
      
    }
}   
