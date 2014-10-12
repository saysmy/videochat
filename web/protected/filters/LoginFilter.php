<?php
class LoginFilter extends CFilter 
{
	public function preFilter($filterChain)
	{
		if(!CUser::checkLogin()) {
			throw new CHttpException(200, '需要登录', -100);
		}
		return true;
	}
}