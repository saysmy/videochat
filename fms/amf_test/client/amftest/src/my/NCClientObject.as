package my
{
	import flash.external.ExternalInterface;
	import flash.net.*;
	
	import spark.components.Application;

	public class NCClientObject
	{
		public function NCClientObject()
		{
		}
		public function onLogin(name: String): void{
			ExternalInterface.call("onLogin", name);
		}
	}
}