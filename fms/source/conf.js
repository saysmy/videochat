var ServerURL = 'http://www.efeizao.com/amf/';
var mid = null;//主播ID 房间主
var mids = [];//主播们
var publishing_mid = null;
var publish_log_id = null;
var streamName = 'chat';

var USER_BROADCAST = 1;
var USER_BROADCAST_TO = 2;
var UNLOGIN_UID = -1;

var UNLOGIN_USER = -1;
var COMMON_USER = 1;
var DEAD_USER = 4;

var COMMON_USER = 1;//普通用户
var ROOM_MODERATOR_USER = 2;//主播
var ROOM_ADMIN_USER = 3;//管理员
var ROOM_OWN_USER = 5;//房间主