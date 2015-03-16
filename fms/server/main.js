load("conf.js");
load("common.js");
load("Source.js");
load("netservices.asc");

application.onAppStart = function(){

	this.service = NetServices.createGatewayConnection(ServerURL).getService("ChatService", this);

	this.rid = this.name.substring(this.name.indexOf('_') + 1);

	this.source = new Source(this.rid);
}

application.onAppStop = function(info) {
	mytrace("onAppStop called:" + jsonToString(info)); 
}

application.onPublish = function(client, stream){
	mytrace('publish mid:' + client.data.uid);
	this.source.publish(stream, client.data.uid);
}

application.onUnpublish = function(client, stream){
	mytrace('unpublish: ' + stream.name);
	this.source.unpublish(stream, client.data.uid);
}

application.onStatus = function(info){
	mytrace('code: ' + info.code + ' level: ' + info.level + ' description:' + info.description);
}

application.onConnect = function(client, sid, uid, rid) {
	mytrace('onConnect session:' + sid + ' uid:' + uid + " rid:" + rid);

	this.source.userConnect(sid, uid, rid, client);

}

application.onDisconnect = function(client){
	this.source.userDisconnect(client.id);

}


Client.prototype.sendMsg = function(msgData){

	var client = this;

	mytrace("sendMsg to:" + msgData.to + " msg:" + msgData.msg + " from:" + this.data.uid + " private:" + msgData.private);
	if(msgData.msg.length == 0) return;

	if (this.data.uid == UNLOGIN_UID) {
		this.call('onChatMsg', null, 104, 'not login', {});
		return;
	}
	if (this.data.ban) {
		this.call('onChatMsg', null, 103, 'send msg not allow uid:' + this.data.uid, {private : true});
		return;
	};

	//命感词过滤
	application.msgFilter_Result = function(resp) {
		if (resp.errno == -100) {//未登录
			client.call('onChatMsg', null, 104, 'not login' + client.data.uid, {private : true});
		}
		else if (resp.errno == 500) {//发言频率控制
			client.call('onChatMsg', null, 105, 'send msg not allow uid:' + client.data.uid, {private : true});
			return;
		}
		else if (resp.errno == 501) {//短时间内不能发相同内容
			client.call('onChatMsg', null, 106, 'send msg not allow uid:' + client.data.uid, {private : true});
			return;
		}
		else if (resp.errno == 502) {//被禁言
			client.call('onChatMsg', null, 107, 'send msg not allow uid:' + client.data.uid, {private : true});
			return;			
		}
		else if (resp.errno == 0) {

			msgData.msg = resp.data.msg;
			application.source.sendMsg(msgData, client.id);
		}

	}
	application.service.msgFilter(this.data.sid, this.data.uid, application.rid, msgData.msg);
}

Client.prototype.sendGift = function(propId, count, to){
	mytrace('sendGift propId:' + propId + ' count:' + count + ' to:' + to + ' from:' + this.data.uid);
	if (this.data.uid == UNLOGIN_UID) {
		this.call("onGiftMsg", null, 201, 'not login', {});
		return;
	}

	application.source.sendGift(propId, count, to, this.id);
}

Client.prototype.ban = function(buid){
	application.source.ban(buid, this.id);
}

Client.prototype.ti = function(tuid) {
	application.source.ti(tuid, this.id);
}

Client.prototype.setAdmin = function(auid) {
	application.source.setAdmin(auid, this.id);
}

Client.prototype.checkVideo = function() {
	application.source.checkVideo(this.id);
}

Client.prototype.FCSubscribe = function() {
	mytrace("FCSubscribe:" + jsonToString(arguments));
    this.call('onFCSubscribe', null);
}
