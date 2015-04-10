<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        throw new Exception("test", 1000);
    }
}   
