package my
{
	public class VideoItemParameter
	{

		public var sip: String;
		public var sid: String;
		public var uid: String;
		public var rid: String;
		public var appname: String = '';
		
		public function getAppURL(): String {
			return  "rtmp://" + sip + "/" + appname;
		}
		
		public function getStreamName(): String{
			return 'chat';
		}
	
	}
}