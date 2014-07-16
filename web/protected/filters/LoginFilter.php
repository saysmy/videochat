<?php
class LoginFilter extends CFilter 
{
	public function preFilter($filterChain)
	{
		if(CUser::checkLogin()) {
			return true;
		}
		else {
			header('Location:http://' . Yii::app()->params['domain'] . '/?r=user/QQLogin&url=' . urlencode('http://' . Yii::app()->params['domain'] . $_SERVER["REQUEST_URI"]));
			exit;
		}
	}
}