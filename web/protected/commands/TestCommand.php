<?php

class TestCommand extends CConsoleCommand
{
    public function run() {
        $results = Yii::app()->db->createCommand("Select CONCAT( 'drop table ', table_name ) as c FROM information_schema.tables Where table_name LIKE 'thinkox_%';")->queryAll();
        foreach($results as $result) {
            $sql = $result['c'];
            Yii::app()->db->createCommand($sql)->execute();
        }

    }
}   
