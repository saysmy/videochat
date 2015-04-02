<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $users = User::model()->findAll('nickname like :nickname', array(':nickname' => "wheelswang%"));
        echo count($users);
    }
}   
