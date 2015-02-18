package my
{
	import flash.external.ExternalInterface;
	import spark.components.Application;

	public class NSClientObject
	{
		private var app: Object;
		
		public function NSClientObject(app: Application)
		{
			this.app = app;
		}
		
		public function onMetaData(obj: Object): void{
			this.app.debug("onMetaData");
			return;
		}
		
		public function onTimeCoordInfo(obj: Object): void{
			this.app.debug("onTimeCoordInfo");
		}
		
		public function onPlayStatus(obj: Object): void {
			this.app.debug("onPlayStatus");
		}
		
	}
}