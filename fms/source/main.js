
load("conf.js");
load("common.js");
load("netservices.asc");

application.loginUsers = {};
application.unLoginUsers = {};
application.loginUsersClients = {};

application.onAppStart = function() {

    this.rid = this.name.substring(this.name.indexOf('_') + 1);
    this.isPlaying = false;
    this.service = NetServices.createGatewayConnection(ServerURL).getService("ChatService", this);

    this.dispatchDeadUser_Result = function(resp) {
        if (resp.errno) {
            mytrace('dispatch dead user error:' + resp.errno + '|' + resp.msg);
            application.shutdown();
            return;
        };
        var users = resp.data;
        mytrace('dipatch dead user num:' + users.length);
        for (var i in users) {
            application.loginUsers[users[i].uid] = users[i];  
        };
        userBroadcast("onInitRoom", 0, '', getUserList());

    }
    this.dispatchDeadUser_Status = function(result) {
        application.shutdown();
    }

    this.getRoomInfo_Result = function(resp) {
        if (resp.errno) {
            mytrace('getRoomInfo error:' + resp.errno + '|' + resp.msg);
            application.shutdown();
            return;
        }
        mid = resp.data.mid;
        mids = resp.data.mids;
        mytrace('room mid:' + mid + ' mids:' + jsonToString(mids));

        //主播连接成功时 实例还未获取到mid的情况
        for (var i = 0; i < application.loginUsers.length; i++) {
            if (isModerator(application.loginUsers[i].uid)) {
                userBroadcast('onShowPublicBar', 0, '', application.loginUsers[i].cid);
                break;
            }
        }
    }
    this.getRoomInfo_Status = function(result) {
        application.shutdown();
    }

    NetServices.createGatewayConnection(ServerURL).getService("ChatService", this).getRoomInfo(this.rid);//同一个service并行会出问题
    this.service.dispatchDeadUser(this.rid);
}

application.onAppStop = function(info) {
    mytrace("onAppStop called:" + jsonToString(info)); 

    this.returnDeadUser_Result = function(resp) {
        if (resp.errno) {
            mytrace('returnDeadUser error:' + resp.errno + '|' + resp.msg);
        };
        mytrace('returnDeadUser success');
    }

    var user_ids = [];
    for (var uid in this.loginUsers) {
        var user = this.loginUsers[uid];
        if (user.type == DEAD_USER) {
            user_ids.push(user.uid);
        };
    };
    this.service.returnDeadUser(this.rid, user_ids);
}

//接入机器attach过来的视频流不触发onPublish和onUnpublish
application.onPublish = function(client, stream){
    mytrace("onPublish:" + stream.name);
}
application.onUnpublish = function(client, stream) {
    mytrace("onUnpublish:" + stream.name);
}

application.onStatus = function(info){
	mytrace('code: ' + info.code + ' level: ' + info.level + ' description:' + info.description);
}

application.onConnect = function(client) {

    mytrace('onConnect');

	this.acceptConnection(client);

    if (application.isPlaying) {
        client.call('doPublish', null);
    }
}

application.onDisconnect = function(client){
    mytrace('onDisconnect');
}

Client.prototype.userPublish = function(uid) {
    mytrace('userpublish mid:' + uid);

    publishing_mid = uid;

    application.isPlaying = true;

    userBroadcast("onPublish", 0, '', {});

    application.reportPublishStart_Result = function(resp) {
        if (resp.errno == 0) {
            publish_log_id = resp.data.table_id;
        }
        else {
            mytrace('reportPublishStart error');
        }
    }
    application.service.reportPublishStart(uid, application.rid);
}

Client.prototype.userUnpublish = function(uid) {
    mytrace('userUnpublish');

    application.isPlaying = false;

    publishing_mid = null;

    userBroadcast("onUnpublish", 0, '', {});

    if (publish_log_id) {
        application.service.reportPublishEnd(uid, application.rid, publish_log_id);
        publish_log_id = null;
    }
    else {
        mytrace('miss publish_log_id');
    }
}

Client.prototype.userConnect = function(sid, uid, rid, cid) {

    mytrace('userConnect sid:' + sid + ' uid:' + uid + ' rid:' + rid + ' cid:' + cid);

    var client = this;

    if (uid == UNLOGIN_UID) {//未登录
        doLoginOK({uid : uid, cid : cid, type : UNLOGIN_USER}, this);
        return;
    }
    // 重复登录问题 接收本次连接 断开上一次的连接
    if(application.loginUsers[uid]){

        mytrace('replogin uid:' + uid);

        application.loginUsersClients[uid].call('userConnectResp', null, 100, '', {}, application.loginUsers[uid].cid);
        
        delete application.loginUsersClients[uid];
        delete application.loginUsers[uid];

    }

    // 获取用户身份
    application.getUserInfo_Result = function(resp){
        if(resp.errno){
            // 无效用户
            mytrace('getUserInfo error:' + resp.errno + '|' + resp.msg);

            client.call('userConnectResp', null, 103, '', null, cid);
            return;
        }

        var userInfo = resp.data;
        userInfo.sid = sid;
        userInfo.uid = userInfo.id;
        userInfo.cid = cid;

        mytrace("uid:" + userInfo.id + " nickname:" + userInfo.nickname + " sex:" + userInfo.sex + " type:" + userInfo.type + " headPic:" + userInfo.headPic + " logoutMsg:" + userInfo.logoutMsg);
        // 普通用户
        if(userInfo.type == COMMON_USER){
            if(!userInfo.allowIn) {//禁止进入
                mytrace('uid:' + userInfo.id + ' not allow');

            }
        }
        else{ // 主持人和管理员
            mytrace('admin onLogin uid:' + userInfo.id);
        }
        doLoginOK(userInfo, client);

    }

    application.service.getUserInfo(sid, uid, rid);
}

Client.prototype.userDisconnect = function(cid) {

    mytrace('userDisconnect cid:' + cid);

    var userInfo = null;

    for (var uid in application.loginUsers) {
        if (application.loginUsers[uid].cid == cid) {
            userInfo = application.loginUsers[uid];
            delete application.loginUsers[uid];
            delete application.loginUsersClients[uid];
            break;
        }
    }

    if (!userInfo) {
        for (var tCid in application.unLoginUsers) {
            if (application.unLoginUsers[tCid].cid == cid) {
                userInfo = application.unLoginUsers[tCid];
                delete application.unLoginUsers[tCid];
                break;
            }
        };
    }

    if (!userInfo) {
        mytrace("userDisconnect user cannot find cid:" + cid);
        return;
    }

    if (userInfo.uid == publishing_mid) { //主播
        userBroadcast('onUnpublish', 0, '', null);
    }

    userBroadcast("onLogout", 0, '', userInfo);

    application.service.disconnectReport(application.rid, userInfo.uid, getUserList().length);
}


Client.prototype.isPlaying = function(cid) {

    mytrace('isPlaying cid:' + cid + ' isPlaying:' + application.isPlaying);

    userCall(this, 'onCheckVideo', 0, '', {isPlaying : application.isPlaying}, cid);
}

Client.prototype.sendMsg = function(msgData, cid) {

    mytrace('sendMsg msgData:' + jsonToString(msgData) + ' cid:' + cid);

    var clientUserInfo = getUserInfoByCid(cid);
    if (!clientUserInfo) {
        mytrace('getUserInfoByCid error cid:' + cid);
        return;
    }

    var userInfo = {};

    if (msgData.to != 0) {
        userInfo = application.loginUsers[msgData.to];
        if(!userInfo){
            mytrace('sendMsg target uid:' + msgData.to + ' userInfo not found');
            userCall(this, "onChatMsg", 100, 'user not in room uid:' + msgData.to, {}, cid);
            return;
        }
    }
    else {
        userBroadcast("onChatMsg", 0, '', {"from" : clientUserInfo.uid, "fromNickname" : clientUserInfo.nickname, "fromHeadPic" : clientUserInfo.headPic, "to" : msgData.to, "toNickname" : '', "toHeadPic" : '', "msg" : msgData.msg, private : false, "timestamp" : (new Date).getTime()});
        return;
    };

    var ret = {"from" : clientUserInfo.uid, "fromNickname" : clientUserInfo.nickname, "fromHeadPic" : clientUserInfo.headPic, "to" : userInfo.uid, "toNickname" : userInfo.nickname, "toHeadPic" : userInfo.headPic, "msg" : msgData.msg, private : msgData.private, "timestamp" : (new Date).getTime()};

    if (!msgData.private) {
        userBroadcast('onChatMsg', 0, '', ret);
    }
    else {
        userBroadcast('onChatMsg', 0, '', ret, userInfo.cid);
    }

}

Client.prototype.sendGift = function(propId, count, to, cid) {

    mytrace('sendGift propId:' + propId + ' count:' + count + ' to:' + to + ' cid:' + cid);

    var clientUserInfo = getUserInfoByCid(cid);
    if (!clientUserInfo) {
        mytrace('getUserInfoByCid error cid:' + cid);
        return;
    }

    var client = this;

    var userInfo = application.loginUsers[to];
    if(!userInfo){
        mytrace('sendGift target uid:' + to + ' userInfo not found');
        userCall(client, "onGiftMsg", 200, 'user not in room uid:' + to, {}, cid);
        return;
    }

    application.sendGift_Result = function(resp){
        if(resp.errno) {
            userCall(client, "onGiftMsg", resp.errno, resp.msg, {}, cid);
            return;
        }

        userBroadcast("onGiftMsg", 0, '',  {"from" : clientUserInfo.uid, "fromNickname" : clientUserInfo.nickname, "fromHeadPic" : clientUserInfo.headPic, "to" : to, "toNickname" : userInfo.nickname, "toHeadPic" : userInfo.headPic, "propId": propId, "propName" : resp.data.propName,  "propPic" : resp.data.propPic, "count" : count, "showProp" : resp.data.showProp, "time" : resp.data.time});
    };
    application.service.sendGift(application.rid, clientUserInfo.sid, clientUserInfo.uid, to, propId, count);

}

Client.prototype.ban = function(buid, cid) {

    mytrace('ban buid:' + buid + ' cid:' + cid);

    var clientUserInfo = getUserInfoByCid(cid);
    if (!clientUserInfo) {
        userCall(client, "onBan", 302, 'getUserInfoByCid error', {}, cid);
        mytrace('getUserInfoByCid error cid:' + cid);
        return;
    }

    var client = this;

    var banUserInfo = application.loginUsers[buid];
    if(!banUserInfo){
        mytrace('ban target uid:' + buid + ' userInfo not found');
        userCall(client, "onBan", 300, 'ban user not in room', {}, cid);
        return;
    }

    application.ban_Result = function(resp) {
        if(resp.errno){
            userCall(client, "onBan", 301, 'ban error:' + resp.errno, {}, cid);
        }
        else{
            userBroadcast("onBan", 0, '' , {banUid : buid, banNickname : banUserInfo.nickname});
        }
    };

    application.service.ban(clientUserInfo.sid, clientUserInfo.uid, application.rid, buid);

}

Client.prototype.ti = function(tuid, cid) {
    mytrace('ti tuid' + tuid + ' cid:' + cid);

    var user = getUserInfoByCid(cid);
    if (!user) {
        mytrace('Ti getUserInfoByCid error user not found:' + cid);
        return;
    }

    if (!(user.type == ROOM_MODERATOR_USER || user.type == ROOM_ADMIN_USER || user.type == ROOM_OWN_USER)) {
        userCall(user.client, 'onTi', 100, 'privilige not enough', {}, cid);
        return;
    }

    for (var i in application.loginUsers) {
        if (application.loginUsers[i].uid == tuid) {

            userBroadcast('onTi', 0, '', {tCid : application.loginUsers[i].cid, tiNickname : application.loginUsers[i].nickname, tUid : tuid});
            delete application.loginUsers[i];
            delete application.loginUsersClients[i];

            return;
        }
    }

    mytrace('tuid not found');

    userCall(user.client, 'onTi', 101, 'user not in room', {}, cid);
}

Client.prototype.setAdmin = function(auid, cid) {

    mytrace('auid:' + auid + ' cid:' + cid);

    var user = getUserInfoByCid(cid);
    if (!user) {
        mytrace('Ti getUserInfoByCid error user not found:' + cid);
        return;
    }

    if (!(user.type == ROOM_MODERATOR_USER || user.type == ROOM_OWN_USER)) {
        userCall(user.client, 'onSetAdmin', 200, 'privilige not enough', {}, cid);
        return;
    }

    var newAdminUser = getUserInfoByUid(auid);
    if (!newAdminUser) {
        userCall(user.client, 'onSetAdmin', 201, 'user not in room', {}, cid);
        return;
    }

    if (newAdminUser.type != COMMON_USER) {//普通用户
        userCall(user.client, 'onSetAdmin', 203, 'already admin level', {}, cid);
        return;
    }

    application.setAdmin_Result = function(resp) {
        if (!resp.errno) {
            newAdminUser.type = ROOM_ADMIN_USER;
            userBroadcast('onSetAdmin', 0, '', {auid : newAdminUser.uid, aNickname : newAdminUser.nickname});
        }
        else {
            userCall(user.client, 'onSetAdmin', 202, resp.errno + '|' + resp.msg, {}, cid);
        }
    }

    application.service.setAdmin(auid, user.uid, user.sid, application.rid);
}


function doLoginOK(userInfo, client){
    mytrace('doLoginOK uid:' + jsonToString(userInfo));

    userBroadcast("onLogin", 0, '', userInfo);

    // 接受新用户登录
    client.call('userConnectResp', null, 0, '', userInfo, userInfo.cid);

    // 更新用户昵称映射表
    if (userInfo.uid != UNLOGIN_UID) {
        application.loginUsers[userInfo.uid] = userInfo;
        application.loginUsersClients[userInfo.uid] = client;
    }
    else {
        application.unLoginUsers[userInfo.cid] = userInfo;
    }

    var allUsers = getUserList();
    
    userCall(client, "onInitRoom", 0, '', allUsers, userInfo.cid);
    if (isModerator(userInfo.uid)) {
        userCall(client, "onShowPublicBar", 0, '', {}, userInfo.cid);
    }

    application.service.connectReport(application.rid, userInfo.uid, allUsers.length);
}

function getUserList() {
    var ret = [];
    for (var uid in application.loginUsers) {
        ret.push(application.loginUsers[uid]);
    }

    //未登录用户  
    for (var cid in application.unLoginUsers) {
        ret.push(application.unLoginUsers[cid]);
    }    

    return ret;
}

function getUserInfoByCid(cid) {
    for (var uid in application.loginUsers) {
        if (application.loginUsers[uid].cid == cid) {
            return application.loginUsers[uid];
        }
    }

    //未登录用户  
    for (var cid in application.unLoginUsers) {
        if (application.unLoginUsers[cid].cid == cid) {
            return application.unLoginUsers[uid];
        }    
    }

    return null;
}

function getUserInfoByUid(uid) {
    if (application.loginUsers[uid]) {
        return application.loginUsers[uid];
    }
    return  null;
}

function isModerator(uid) {
    if (mid == uid) {
        return true;
    }

    for (var i in mids) {
        if (mids[i] == uid) {
            return true;
        }
    }

    return false;
}

function userBroadcast(cmd, errno, msg, data, cid) {
    if (cid) {
        application.broadcastMsg('userBroadcast', cmd, errno, msg, data, USER_BROADCAST_TO, cid);
    }
    else {
        application.broadcastMsg('userBroadcast', cmd, errno, msg, data, USER_BROADCAST, null);

    }
}

function userCall(client, cmd, errno, msg, data, cid) {
    client.call('userCall', null, cmd, errno, msg, data, cid);
}