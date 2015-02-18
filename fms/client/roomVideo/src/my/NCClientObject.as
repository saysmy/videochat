package my
{
	import flash.external.ExternalInterface;
	import flash.net.*;
	
	import spark.components.Application;
	
	public class NCClientObject
	{
		private var app: Object;
		
		public function NCClientObject(app: Application)
		{
			this.app = app;
		}
		
		public function onMetaData(obj: Object): void{}
		public function onTimeCoordInfo(obj: Object): void{}
		
		public function onBWCheck(... rest):Number { 
			return 0; 
		} 
		
		public function onBWDone(... rest):void { 
			var p_bw: Number = 0; 
			if (rest.length > 0) p_bw = rest[0]; 
			this.app.debug('bandwitdh=' + p_bw + 'Kbps');
		} 
		
		// events
		
		public function onInitRoom(errno : int, msg : String, userList: Object): void {
			ExternalInterface.call("room.onInitRoom", userList);
		}
		
		public function onShowPublicBar(errno : int, msg : String, data: Object): void {
			this.app.debug("onShowPublicBar");
			app.initPublicBar(true);
		}
		
		public function onLogin(errno : int, msg : String, userInfo: Object): void{
			ExternalInterface.call("room.onLogin", userInfo);
		}
		
		public function onLogout(errno : int, msg : String, userInfo: Object): void{
			ExternalInterface.call("room.onLogout", userInfo);
		}
		
		public function onChatMsg(errno: int, msg: String, data: Object): void{
			ExternalInterface.call("room.onChatMsg", errno , msg , data);
		}
		
		public function onGiftMsg(errno: int, msg: String, data: Object): void{
			ExternalInterface.call("room.onGiftMsg", errno, msg, data);
		}
		
		public function onBan(errno: int, msg: String, data: Object) :void{
			ExternalInterface.call("room.onBan", errno, msg, data);			
		}
		
		public function onTi(errno: int, msg: String, data: Object) :void {
			ExternalInterface.call("room.onTi", errno, msg, data);	
		}
		
		public function onSetAdmin(errno: int, msg: String, data: Object) :void {
			ExternalInterface.call("room.onSetAdmin", errno, msg, data);	
		}
		
		public function onPublish(errno: int, msg: String, data: Object) : void {
			this.app.debug("onPublish");
			this.app.doPlay();
		}
		
		public function onUnpublish(errno: int, msg: String, data: Object) : void {
			this.app.debug("onUnpublish");
			this.app.doStop();	
		}
		
		public function onConnectStatus(errno: int, msg: String, data: Object) : void {
			this.app.onConnectErrorStatus({errno : errno});
		}
		
		public function onCheckVideo(errno : int, msg : String, data : Object) : void {
			this.app.debug('isPlaying:' + data.isPlaying);
			if (data.isPlaying) {
				this.app.doPlay();
			}
		}
		
		public function onPublishStatus(errno: int, msg: String, data: Object) : void {
			this.app.debug("onPublishStatus");
			this.app.doStopPublish();
		}

	}
}