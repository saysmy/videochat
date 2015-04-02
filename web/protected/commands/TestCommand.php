<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        ToolUtils::sendSms('18001668775', '2223');
    }
}   
