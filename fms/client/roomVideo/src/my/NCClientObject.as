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
			ExternalInterface.call("doAddMsg", 'bandwitdh=' + p_bw + 'Kbps');
		} 
		
		// events
		
		public function onInitRoom(userList: Object): void {
			ExternalInterface.call("room.onInitRoom", userList);
		}
		
		public function onShowPublicBar(): void {
			app.initPublicBar(true);
		}
		
		public function onLogin(userInfo: Object): void{
			ExternalInterface.call("room.onLogin", userInfo);
		}
		
		public function onLogout(userInfo: Object): void{
			ExternalInterface.call("room.onLogout", userInfo);
		}
		
		public function onChatMsg(errno: int, msg: String, data: Object): void{
			ExternalInterface.call("room.onChatMsg", errno , msg , data);
		}
		
		public function onGiftMsg(errno: int, msg: String, data: Object): void{
			ExternalInterface.call("room.onGiftMsg", errno, msg, data);
		}
		
		public function onBanMsg(errno: int, msg: String, data: Object) :void{
			ExternalInterface.call("room.onBanMsg", errno, msg, data);			
		}
		
		/*
		public function onBroadcastMsg(type: String, s1: String, s2: String, s3: String, s4: String, s5: String, s6: String, s7: String): void{
			switch(type){
				case 'onUserLogin':
					// time msg uid nick role logo
					ExternalInterface.call(type, s1, s2, s3, s4, s5, s6);
					break;
				case 'onUserLogout':
					// time uid nick role logo
					ExternalInterface.call(type, s1, s2, s3, s4, s5);
					break;
				case 'onChat':
					// time msg from fromnick to tonick
					ExternalInterface.call(type, s1, s2, s3, s4, s5, s6);
					break;
				case 'onGift':
					// onGift, time, gift, count, from, fromnick, to, tonick
					ExternalInterface.call(type, s1, s2, s3, s4, s5, s6, s7);
					break;
			}
		}
		*/

	}
}