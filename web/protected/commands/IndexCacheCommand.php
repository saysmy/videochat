<?php

class IndexCacheCommand extends CConsoleCommand
{
	public function run() {
		Yii::app()->cache->set('index', 'test');
	}
}	