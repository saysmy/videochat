// ActionScript file
package my {
	import flash.net.Responder;
	import spark.components.Application;

	public class NCResponder extends Responder {
		
		private var app: Object;

		public function NCResponder(app: Application)
		{
			super(this.result, null);
			this.app = app;
		}
		
		public function result(obj :Object): void {
			this.app.debug(obj);;	
		}
	}
}