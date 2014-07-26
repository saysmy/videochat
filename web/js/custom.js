var faces = [{img : 'img/face/5.png', data : '[猪]'},{img : 'img/face/8.png', data : '[西瓜]'},{img : 'img/face/e1.png', data : '[爱]'},{img : 'img/face/e3.png', data : '[蛋糕]'},{img : 'img/face/e4.png', data : '[色]'},{img : 'img/face/e6.png', data : '[屎]'},{img : 'img/face/e7.png', data : '[花]'},{img : 'img/face/e8.png', data : '[笑]'}];
$(document).ready(function(){
	
	$(".vlist > li:child(1))").css({"margin-bottom":"10px"});
	$(".vlist > li:nth-child(2n)").css({"margin-left":"10px"});
	
	$(".vlist2 > dl:nth-child(4n)").css({"margin-right":"0"})
	
	$(".roomHot li:lt(3) em").css({"background":"#4598da"});
	$(".roomHot li:lt(3) a").css({"font-weight":"bold"});
	
	$(".roomChat tr:odd").css({"background":"#F4F4F4"});
	$(".roomUserItem li:odd").css({"background":"#F4F4F4"});
	
	jq_tabs("room");
	jq_tabs("roomUser");

	createSWF('roomVideo', 'roomPlayer', {uid : app.uid, rid : app.rid, sid : app.sid, appname : app.appname, sip : app.sip}, {width : 470, height : 330});

	$("#sendMsgBtn").click(sendMsg);
	$("#msgArea").keydown(function(e){
		if (e.which == 13) {sendMsg()};
	})

	$("#face").popCheckbox(200, faces, function(item, index) {
		return $('<div style="dispaly:inline-block;text-align:center;float:left;cursor:pointer;margin:2px" index="' + index + '""><img src="' + item.img + '" style="width:24px;height:24px;"/></div>');
	}, function(item) {
		$("#msgArea").checkboxFill(item['data']);
	});

	$("#chooseProp").popCheckbox(200, prop, function(item, index) {
		return $('<div style="dispaly:inline-block;text-align:center;float:left;cursor:pointer;margin:2px" index="' + index + '""><img src="' + item.img + '" style="width:60px;height:60px;"/><br/><div style="display:inline-block;">' + item.desc + '</div></div>');
	}, function(item) {
		$("#chooseProp").text(item.desc);
		$("#chooseProp").attr('propId', item.propId);
		$("#choosePropImg")[0].src = item.img;
	});

	$("#propNum").parent().popCheckbox(60, [1,2,3,4,5,6,7,8,9,10], function(item, index) {
		return $('<div index="' + index + '" style="text-align:center;cursor:pointer;">' + item + '</div>');
	}, function(item) {
		$("#propNum").text(item);
	})

	$("#panelArrow").click(function() {
		if($(this).hasClass('arrow_up')) {
			$(this).removeClass('arrow_up');
			$(this).addClass('arrow_down');
			$('#publicChatPanel').height("0px");
			$('#privateChatPanel').height('405px');
		}
		else {
			$(this).removeClass('arrow_down');
			$(this).addClass('arrow_up');
			$('#publicChatPanel').height("320px");
			$('#privateChatPanel').height('85px');
		}
		return false;
	})

});

var userList = {};

function onConnectSuccess() {
	addPublicRoomMsg('视频连接成功', 1);
}

function onConnectRejected(resp) {
	var msg = '';
	switch(resp.errno){
		case 100:
			msg = "重复登录";
			break;
		case 101:
			msg = "服务器超出最大用户数";
			break;
		case 102:
			msg = "禁止进入";
			break;
		case 103:
			msg = "系统错误";
			break;
	}
	addPublicRoomMsg('视频连接失败:' + msg, 1);
}

function onConnectClosed() {
	addPublicRoomMsg('视频连接已断开', 1);
}

function onVideoPublish() {
	addPublicRoomMsg('视频播放开始', 1);
}

function onVideoUnpublish() {
	addPublicRoomMsg('视频播放结束', 1);
}

function debug(msg) {
	console.log(msg);
}

function onLogin(user) {
	addUser(user, true);
	updateUserNum();
}

function onLogout(user) {
	removeUser(user);
	updateUserNum();
}

function onInitRoom(list) {
	console.log(list);
	var c_0 = 0;
	var c_1 = 0;
	for (var i in list) {
		addUser(list[i], false);
	};
	updateUserNum();
}

var user0Flag = false;
var user1Flag = false;
function addUser(user, showPublicMsg) {
	if (showPublicMsg) {	
		addPublicRoomMsg(user, 3);
	};
	userList[user.uid] = user;
	if (user.uid == app.mid) {
		return;
	};
	var style = '';
	if (user.role == 3) {
		var area = "roomUserItem0";
		if (user0Flag) {style='background-color: rgb(244, 244, 244)'};
		user0Flag = !user0Flag;
	}
	else {
		var area = "roomUserItem1";
		$("#c_1").text(++c_1);
		if (user1Flag) {style='background-color: rgb(244, 244, 244)'};
		user1Flag = !user1Flag;
	}
	$("#" + area + " ul").append($("<li id='user_" + user.uid + "' style='" + style + "'><a href='javascript:changeReceiver(" + user.uid + ")'>" + user.nickname + "</a><i></i></li>"));
}

function removeUser(user) {
	addPublicRoomMsg(user.nickname + "退出聊天室", 1);
	$('#user_' + user.uid).remove();
	delete userList[user.uid];
}

function updateUserNum() {
	var c_0 = 0, c_1 = 0;
	for (var uid in userList) {
		if (userList[uid].role == 3) {c_0 ++;};
		if (userList[uid].role == 1) {c_1 ++;};
	}
	$("#c_0").text(c_0);
	$("#c_1").text(c_1);
}

function createSWF(swf, placehoder, flashvars, attributes){
	var swfVersionStr = "11.1.0";
	var xiSwfUrlStr = "playerProductInstall.swf";
	var params = {};
	params.wmode = "transparent";
	params.quality = "high";
	params.bd = "2000000";
	params.allowscriptaccess = "sameDomain";
	attributes.id = placehoder;
	attributes.name = placehoder;
	attributes.align = "middle";
	swfobject.embedSWF('swf/' + swf+".swf?v=0.18", placehoder, attributes.width, attributes.height, swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
}

var publicRoomFlag = false;
function addPublicRoomMsg(msgData, type) {
	var table = $("#publicChatPanel table");
	var style = '';
	if (publicRoomFlag) {style="background-color:rgb(244,244,244)"};
	publicRoomFlag = !publicRoomFlag;
	if (type == 1) {
		table.append("<tr><td colspan=2>" + msgData + "</td></tr>");
	}
	else if(type == 2) {
		var date = new Date();
		date.setTime(msgData.timestamp);
		table.append('<tr style="' + style + '"><th>' + date.getHours() + ':'  + date.getMinutes() + '</th><td><a href="javascript:changeReceiver(' + msgData.from + ')">' + msgData.fromNickname + '</a>' + (msgData.to == 0 ? '' : '对<a href="javascript:changeReceiver(' + msgData.to + ')">' + msgData.toNickname + '</a>') + '说：' + msgData.msg + '</td></tr>');
	}
	else {
		table.append("<tr style='" + style + "'><td colspan=2><a href='javascript:changeReceiver(" + msgData.uid + ")'>" + msgData.nickname + "</a>加入聊天室</td></tr>");
	}
	$("#publicChatPanel").scrollTop($("#publicChatPanel")[0].scrollHeight - $("#publicChatPanel").height());
}

function addPrivateRoomMsg(msgData, type) {
	if (type == 1) {
		$("#privateChatPanel ul").append($('<li>' + msgData + '</li>'));
	}
	else {
		$("#privateChatPanel ul").append($('<li><a href="javascript:changeReceiver(' + msgData.from + ')">' + (msgData.from == app.uid ? '我' : msgData.fromNickname) + '</a>对<a href="javascript:changeReceiver(' + msgData.to + ')">' + (msgData.to == app.uid ? '你' : msgData.toNickname) + '</a>说：' + msgData.msg + '</li>'));
	}
	$("#privateChatPanel").scrollTop($("#privateChatPanel")[0].scrollHeight - $("#privateChatPanel").height());
}

function addPropMsg(msgData, type) {
	if (type == 1) {
		$('#giftMsgPanel ul').append($('<li>' + msgData + '</li>'));
	}
	else {
		$('#giftMsgPanel ul').append($('<li><a href="javascript:changeReceiver(' + msgData.from + ')">' + msgData.fromNickname + '</a> 送给 <a href="javascript:changeReceiver(' + msgData.to + ')">' + msgData.toNickname + '</a> ' + msgData.propName + ' <img src="' + msgData.propPic + '" width="60" height="60"> <b>x' + msgData.count + '</b></li>'));	
	}
	$("#giftMsgPanel").scrollTop($("#giftMsgPanel")[0].scrollHeight - $("#giftMsgPanel").height());

}

function jq_tabs(str) {
	$("#"+str+"Tab a").mouseover(function(){
		$("#"+str+"Tab a").removeClass("on");
		$(this).addClass("on");
		var key = $("#"+str+"Tab a").index(this);
		$("[id^='"+str+"Item']").hide();
		$("#"+str+"Item"+key).show();
	});
	$("#"+str+"Tab a").eq(0).trigger("mouseover");
}

function sendMsg() {
	swfobject.getObjectById("roomPlayer").doSendMsg({"msg" : $("#msgArea").val().trim(), "to" : $("#msgReceiver").val(), "private" : $("#privateMsg").attr("checked")});
	$("#msgArea").val('');
}

function sendGift() {
	if (!$("#chooseProp").attr('propId')) {return;}
	var num = parseInt($("#propNum").text());
	if (!num) {return};
	swfobject.getObjectById("roomPlayer").doSendGift($("#chooseProp").attr('propId'), num, $("#propTo").attr("to"));
}

function onChatMsg(errno, msg, msgData) {
	if (errno != 0) {
		addPrivateRoomMsg(msg, 1);
		return;
	};
	msgData.msg = fillFace(msgData.msg);
	if (msgData.private) {
		addPrivateRoomMsg(msgData, 2);
	}
	else {
		addPublicRoomMsg(msgData, 2);
	}
}

function onBanMsg(errno, msg, data) {

}

function onGiftMsg(errno, msg, data) {
	var errors = {200 : '该用户不在聊天室', 201 : '验证登录失败，请重新登录', 202 : '获取用户数据失败', 203 : '货币不足，请充值'};
	if (errno != 0) {addPropMsg(errors[errno], 1);return;};
	addPropMsg(data, 2);
}

function changeReceiver(uid) {
	var user = userList[uid];
	if(!$("#msgReceiver option[value=" + uid + "]").length) {
		$("#msgReceiver").append("<option value='" + uid + "'>" + user.nickname + "</option>");
	}
	$("#msgReceiver").val(uid);
}

function fillFace(msg) {
	for (var i = faces.length - 1; i >= 0; i--) {
		msg = msg.replace(faces[i].data, '<img src="' + faces[i].img + '">');
	};
	return msg;
}



