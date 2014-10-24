define('room',['popCheckbox', 'user'], function(require, exports, module) {
	var faces = [{img : '/img/face/5.png', data : '{猪}'},{img : '/img/face/8.png', data : '{西瓜}'},{img : '/img/face/e1.png', data : '{爱}'},{img : '/img/face/e3.png', data : '{蛋糕}'},{img : '/img/face/e4.png', data : '{色}'},{img : '/img/face/e6.png', data : '{屎}'},{img : '/img/face/e7.png', data : '{花}'},{img : '/img/face/e8.png', data : '{笑}'}];
	var flower = {img : '/css/i33.jpg', data : '{花}'}
	var user = require('user');
	require('popCheckbox');
	$(document).ready(function(){	
		$(".roomChat tr:odd").css({"background":"#F4F4F4"});
		$(".roomUserItem li:odd").css({"background":"#F4F4F4"});
		
		jq_tabs("room");
		jq_tabs("roomUser");

		createSWF('roomVideo', 'roomPlayer', {uid : app.uid, rid : app.rid, sid : app.sid, appname : app.appname, sip : app.sip}, {width : 470, height : 330});

		$('#sendGiftBtn').click(function(){sendGift()})

		$("#sendMsgBtn").click(sendMsg);
		$("#msgArea").keydown(function(e){
			if (e.which == 13) {sendMsg()};
		})

		$("#face").popCheckbox(200, faces, function(item, index) {
			return $('<div style="dispaly:inline-block;text-align:center;float:left;cursor:pointer;margin:2px" index="' + index + '""><img src="' + item.img + '" style="width:24px;height:24px;"/></div>');
		}, function(item) {
			$("#msgArea").checkboxFill(item['data']);
		});

		$('#flower').click(function() {
			swfobject.getObjectById("roomPlayer").doSendMsg({"msg" : '{花}', "to" : $("#msgReceiver").val(), "private" : $("#privateMsg")[0].checked});
			return false;
		})

		$("#chooseProp").popCheckbox(200, prop, function(item, index) {
			return $('<div title="' + item.price + '泡泡币" style="dispaly:inline-block;text-align:center;float:left;cursor:pointer;margin:2px" index="' + index + '""><img src="' + item.img + '" style="width:60px;height:60px;"/><br/><div style="display:inline-block;">' + item.name + '</div></div>');
		}, function(item) {
			$("#chooseProp").text(item.name);
			$("#chooseProp").attr('propId', item.id);
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

		var is_flower_loading = false;
		$('#flower-loading').click(function() {
			if (is_flower_loading) {
				return false;
			};
			is_flower_loading = true;
			var me = this;
			loading_circle(12, 10000, 'flower-loading', function() {
				is_flower_loading = false;
				$(me).css('cursor', 'pointer');
			});
			$(this).css('cursor', 'default');
			$('#flower').trigger('click');
		})

		if(maxPropInfo) {
			updatePropMaxinfo(maxPropInfo);
		}
	});

	var loginUserList = {};
	var unLoginUserList = {};

	exports.onConnectSuccess = function() {
		addPublicRoomMsg('视频连接成功', 1);
	}

	exports.onConnectRejected = function(resp) {
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
			case 104:
				msg = "系统错误";
				debug(resp.msg);
		}
		addPublicRoomMsg('视频连接失败:' + msg, 1);
	}

	exports.onConnectClosed = function() {
		addPublicRoomMsg('视频连接已断开', 1);
	}

	exports.onVideoPublish = function() {
		addPublicRoomMsg('视频播放开始', 1);
	}

	exports.onVideoUnpublish = function() {
		addPublicRoomMsg('视频播放结束', 1);
	}

	exports.debug = function(msg) {
		console.log(msg);
	}

	exports.onLogin = function(user) {
		addUser(user, true);
		updateUserNum();
	}

	exports.onLogout = function(user) {
		removeUser(user);
		updateUserNum();
	}

	exports.onInitRoom = function(list) {
		debug(list);
		for (var i in list) {
			addUser(list[i], false);
		};
		updateUserNum();
	}

	var debug = exports.debug;

	function addUser(user, showPublicMsg) {
		if (user.uid != -1) {
			if (loginUserList[user.uid]) {
				debug('addUser:' + user.uid + ' already in room');
				return;
			}
			if (showPublicMsg) {	
				addPublicRoomMsg(user, 3);
			};
			if (user.uid == app.mid) {user.nickname = '主播'};
			loginUserList[user.uid] = user;
		}
		else {//未登录
			user.nickname = '匿名用户';user.role = 1;
			unLoginUserList[user.fid] = user;
		}
		var style = '';
		if (user.role == 3 || user.uid == app.mid) {
			var area = "roomUserItem0";
		}
		else {
			var area = "roomUserItem1";
		}
		user.dom = $('<li ' + (user.uid == -1 ? '' : 'login="true"') + '><a style="display:inline-block;width:95px;overflow:hidden" href="javascript:room.changeReceiver(' + user.uid + ')">' + user.nickname + '</a><i>' + (user.height ? user.height : '-') + '/' + (user.weight ? user.weight : '-') + '</i></li>');
		if (user.uid == -1 || $("#" + area + " ul li").length == 0) {
			$('#' + area + ' ul').append(user.dom);
		}
		else if ($('#' + area + ' ul li[login=true]:last').length == 0){
			$('#' + area + ' ul').append(user.dom);
		}
		else {
			$('#' + area + ' ul li[login=true]:last').after(user.dom);		
		}
	}

	function userAreaBg(id) {
		$('#' + id + ' li:odd').css({backgroundColor : 'rgb(244,244,244)'});
		$('#' + id + ' li:even').css({backgroundColor: 'white'});
	}

	function removeUser(user) {
		if (user.uid != -1) {
			addPublicRoomMsg(user.nickname + "退出聊天室", 1);
			loginUserList[user.uid].dom.remove();
			delete loginUserList[user.uid];
		}
		else {
			unLoginUserList[user.fid].dom.remove();
			delete unLoginUserList[user.fid];
		}
	}

	function updateUserNum() {
		var c_0 = 0, c_1 = 0;
		for (var uid in loginUserList) {
			if (loginUserList[uid].role == 3  || uid == app.mid) {c_0 ++;}
			else {c_1 ++;};
		}
		for (var k in unLoginUserList) {
			c_1 ++;
		};
		$("#c_0").text(c_0);
		$("#c_1").text(c_1);
		userAreaBg('roomUserItem0');
		userAreaBg('roomUserItem1');
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
		swfobject.embedSWF('/swf/' + swf+".swf?v=0.20", placehoder, attributes.width, attributes.height, swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
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
			table.append('<tr style="' + style + '"><th>' + date.getHours() + ':'  + date.getMinutes() + '</th><td><a href="javascript:room.changeReceiver(' + msgData.from + ')">' + msgData.fromNickname + '</a>' + (msgData.to == 0 ? '' : '对<a href="javascript:changeReceiver(' + msgData.to + ')">' + msgData.toNickname + '</a>') + '说：' + msgData.msg + '</td></tr>');
		}
		else {
			table.append("<tr style='" + style + "'><td colspan=2><a href='javascript:room.changeReceiver(" + msgData.uid + ")'>" + msgData.nickname + "</a>加入聊天室</td></tr>");
		}
		$("#publicChatPanel").scrollTop($("#publicChatPanel")[0].scrollHeight - $("#publicChatPanel").height());
	}

	function addPrivateRoomMsg(msgData, type) {
		if (type == 1) {
			$("#privateChatPanel ul").append($('<li>' + msgData + '</li>'));
		}
		else {
			$("#privateChatPanel ul").append($('<li><a href="javascript:room.changeReceiver(' + msgData.from + ')">' + (msgData.from == app.uid ? '我' : msgData.fromNickname) + '</a>对<a href="javascript:room.changeReceiver(' + msgData.to + ')">' + (msgData.to == app.uid ? '你' : msgData.toNickname) + '</a>说：' + msgData.msg + '</li>'));
		}
		$("#privateChatPanel").scrollTop($("#privateChatPanel")[0].scrollHeight - $("#privateChatPanel").height());
	}

	function addPropMsg(msgData, type) {
		if (type == 1) {
			$('#giftMsgPanel ul').append($('<li>' + msgData + '</li>'));
		}
		else {
			$('#giftMsgPanel ul').append($('<li><a href="javascript:room.changeReceiver(' + msgData.from + ')">' + msgData.fromNickname + '</a> 送给 <a href="javascript:room.changeReceiver(' + msgData.to + ')">' + msgData.toNickname + '</a> ' + msgData.propName + ' <img src="' + msgData.propPic + '" width="60" height="60"> <b>x' + msgData.count + '</b></li>'));	
		}
		$("#giftMsgPanel").scrollTop($("#giftMsgPanel")[0].scrollHeight - $("#giftMsgPanel").height());

	}

	function jq_tabs(str) {
		$("#"+str+"Tab a").click(function(){
			$("#"+str+"Tab a").removeClass("on");
			$(this).addClass("on");
			var key = $("#"+str+"Tab a").index(this);
			$("[id^='"+str+"Item']").hide();
			$("#"+str+"Item"+key).show();
			return false;
		});
		$("#"+str+"Tab a").eq(0).trigger("mouseover");
	}

	function sendMsg() {
		swfobject.getObjectById("roomPlayer").doSendMsg({"msg" : $.trim($("#msgArea").val()), "to" : $("#msgReceiver").val(), "private" : $("#privateMsg")[0].checked});
		$("#msgArea").val('');
	}

	function sendGift() {
		if (!$("#chooseProp").attr('propId')) {
			addPropMsg('请选择礼物', 1);
			return;
		}
		var num = parseInt($("#propNum").text());
		if (!num) {return};
		swfobject.getObjectById("roomPlayer").doSendGift($("#chooseProp").attr('propId'), num, $("#propTo").attr("to"));
	}

	exports.onChatMsg = function(errno, msg, msgData) {
		var errors = {100 : '该用户不再聊天室', 103 : '您已被禁言', 104 : '未登录'};
		if (errno == 104) {
			user.showLoginPanel();
			return;
		};
		if (errno != 0) {
			addPrivateRoomMsg(errors[errno], 1);
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

	function updatePropMaxinfo(propInfo) {
		var time = new Date;
		time.setTime(propInfo.time*1000);
		var timeStr =(time.getMonth() + 1 > 10 ? time.getMonth() + 1 : '0' + (time.getMonth() + 1)) + '.' + (time.getDate()  > 10 ? time.getDate() : '0' + time.getDate()) + ' ' + (time.getHours() > 10 ? time.getHours() : '0' + time.getHours()) + ':' + (time.getMinutes() > 10 ? time.getMinutes() : '0' + time.getMinutes());
		var dom = $('<span><a href="javascript:room.changeReceiver(' + propInfo.from + ')">' + propInfo.fromNickname + '</a> 送给 <a href="javascript:room.changeReceiver(' + propInfo.to + ')">' + propInfo.toNickname + '</a> <b>' + propInfo.count + '个</b>' + propInfo.propName + '（' + timeStr + '）</span>');
		$('.roomNotice span').remove();
		$('.roomNotice').append(dom);
	}

	exports.onGiftMsg = function(errno, msg, data) {
		var errors = {200 : '该用户不在聊天室', 201 : '验证登录失败，请重新登录', 202 : '获取用户数据失败', 203 : '货币不足，请充值'};
		if (errno == 201) {
			user.showLoginPanel();
		};
		if (errno != 0) {addPropMsg(errors[errno], 1);return;};
		var count = data.count;
		data.count = 1;
		for (var i = 0; i < count; i++) {
			addPropMsg(data, 2);
		}
		if (data.showProp) {
			updatePropMaxinfo(data);
		};
	}

	exports.changeReceiver = function(uid) {
		if(uid == -1) {
			return;
		}
		var user = loginUserList[uid];
		if(!$("#msgReceiver option[value=" + uid + "]").length) {
			$("#msgReceiver").append("<option value='" + uid + "'>" + user.nickname + "</option>");
		}
		$("#msgReceiver").val(uid);
	}

	function fillFace(msg) {
		for (var i = faces.length - 1; i >= 0; i--) {
			msg = msg.replace(new RegExp(faces[i].data, 'g'), '<img src="' + faces[i].img + '">');
		};
		msg = msg.replace(flower.data, '<img src="' + flower.img + '">');
		return msg;
	}

	function loading_circle(r, t, holder, finish) {
        var paper = Raphael(holder);

        paper.customAttributes.segment = function (x, y, r, a1, a2) {
            var flag = (a2 - a1) > 180;
            a1 = (a1 % 360) * Math.PI / 180;
            a2 = (a2 % 360) * Math.PI / 180;
            return {
                path: [["M", x, y], ["l", r * Math.cos(a1), r * Math.sin(a1)], ["A", r, r, 0, +flag, 1, x + r * Math.cos(a2), y + r * Math.sin(a2)], ["z"]],
                fill: "rgb(100,100,100)"
            };
        };
        var a1 = 270 + 1;
        var a2 = 270 + 360;
        var interval = 100;
        var step = Math.floor(360 / Math.floor(t / interval));
        var path = paper.path().attr({segment: [r, r, r, a1, a2], opacity : .2});
        var t = setInterval(function() {
            a1 += step;
            if (a2 <= a1) {
                clearInterval(t);
                paper.remove();
                finish();
                return;
            };
            path.attr({segment: [r, r, r, a1, a2], stroke: 'rgb(100,100,100)', opacity : .2});
        }, interval);
    }
})

seajs.use('room', function(room) {window.room = room});
