define('room',['popCheckbox', 'user', 'poshytip', 'common'], function(require, exports, module) {
	var faces = [{img : '/img/face/5.png', data : '{猪}'},{img : '/img/face/8.png', data : '{西瓜}'},{img : '/img/face/e1.png', data : '{爱}'},{img : '/img/face/e3.png', data : '{蛋糕}'},{img : '/img/face/e4.png', data : '{色}'},{img : '/img/face/e6.png', data : '{屎}'},{img : '/img/face/e8.png', data : '{笑}'}];
	var flower = {img : '/img/face/e7.png', data : '{花}'}
	var user = require('user');
	var common = require('common');
	common.include('/js/poshytip/tip-yellow/tip-yellow.css');

	var loginUserList = {};
	var unLoginUserList = {};

	$(document).ready(function(){	

		$('.smallLogo').show();
				
		jq_tabs("room");
		jq_tabs("roomUser");

		$('body').click(function(e) {
			var src = e.target ? e.target : e.srcElement;
			if (!$(src).hasClass('rname')) {
				$('#memberPanel').hide();
			}
		})

		//私聊
		$('#memberPanel .private').click(function() {
			var uid = $('#memberPanel').attr('uid');
			if (!uid) {
				return;
			}
			changeReceiver(uid);
		})

		//禁言
		$('#memberPanel .ban').click(function() {
			var uid = $('#memberPanel').attr('uid');
			if (!uid) {
				return;
			}			
			swfobject.getObjectById("roomPlayer").doBan(uid);
		})

		//设为管理员
		$('#memberPanel .admin').click(function() {
			var uid = $('#memberPanel').attr('uid');
			if (!uid) {
				return;
			}
			swfobject.getObjectById("roomPlayer").doSetAdmin(uid);
		})

		//踢出房间
		$('#memberPanel .ti').click(function() {
			var uid = $('#memberPanel').attr('uid');
			if (!uid) {
				return;
			}
			swfobject.getObjectById("roomPlayer").doTi(uid);
		})

		createSWF('roomVideo', 'roomPlayer', {uid : app.uid, rid : app.rid, sid : app.sid, appname : app.appname, sip : app.sip}, {width : 470, height : 330});

		$('#sendGiftBtn').click(function(){sendGift()})

		$("#sendMsgBtn").click(sendMsg);
		$("#msgArea").keydown(function(e){
			if (e.which == 13) {sendMsg()};
		})

		$("#face").popCheckbox({width : 200, offset : [0, -5]}, faces, function(item, index) {
			return $('<div style="dispaly:inline-block;text-align:center;float:left;cursor:pointer;margin:2px" index="' + index + '""><img src="' + item.img + '" style="width:24px;height:24px;"/></div>');
		}, function(item) {
			$("#msgArea").checkboxFill(item['data']);
		});

		$('#flower').click(function() {
			swfobject.getObjectById("roomPlayer").doSendMsg({"msg" : '{花}', "to" : $("#msgReceiver").val(), "private" : $("#privateMsg")[0].checked});
			return false;
		})

		$("#chooseProp").popCheckbox({width : 468, offset : [155, -25]}, prop, function(item, index) {
			return $('<a class="giftItem" title="' + item.price + '泡泡" style="' + (index%7 == 0 ? 'margin:10px 14px 10px 14px;' : 'margin:10px 7px;') + 'dispaly:inline-block;text-align:center;float:left;cursor:pointer;" index="' + index + '""><img src="' + item.imgPreview + '" style="width:48px;height:48px;"/><br/><div style="display:inline-block;">' + item.name + '</div></div>').poshytip({fade: false, slide : false,followCursor: true, showTimeout : 0});
		}, function(item) {
			$("#chooseProp").text(item.name);
			$("#chooseProp").attr('propId', item.id);
			$("#choosePropImg")[0].src = item.imgPreview;
		});

		$("#propNum").parent().parent().find('em').popCheckbox({width : 100}, [[1,1],[10, '10(十全十美)'],[30, '30(想你...)'],[66, '66(一切顺利)'],[188, '188(要抱抱)'],[520, '520(我爱你)'],[1314, '1314(一生一世)']], function(item, index) {
			return $('<div style="cursor:pointer;height : 25px;padding-left:4px">' + item[1] + '</div>');
		}, function(item) {
			$("#propNum").val(item[0]);
		})

		$("#panelArrow").click(function() {
			if($(this).hasClass('arrow_up')) {
				$(this).removeClass('arrow_up');
				$(this).addClass('arrow_down');
				$('#publicChatPanel').height("0px");
				$('#privateChatPanel').height('425px');
			}
			else {
				$(this).removeClass('arrow_down');
				$(this).addClass('arrow_up');
				$('#publicChatPanel').height("350px");
				$('#privateChatPanel').height('75px');
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
			_loading_circle(12, 45000, 'flower-loading', function() {
				is_flower_loading = false;
				$(me).css('cursor', 'pointer');
			});
			$(this).css('cursor', 'default');
			$('#flower').trigger('click');
		})

		if(maxPropInfo) {
			updatePropMaxinfo(maxPropInfo);
		}

		$('.like').click(function() {
            var rid = $(this).attr('rid');
            var me = $(this);
            $.ajax({
                  url : '/room/love/rid/' + rid,
                  dataType : 'json',
                  success : function(resp) {
                      if (resp.errno == NOT_LOGIN_ERR) {
                          user.showLoginPanel();
                      }
                      else if (resp.errno == 0){
                          var love_num = me.text();
                          if (resp.data.action == 'love') {
                              me.addClass('likeOn');
                              me.text(++love_num)
                          }
                          else {
                              me.removeClass('likeOn');
                              me.text(--love_num);
                          }
                      }
                  }
             })
        })

	});

	exports.onConnectSuccess = function() {
		addPublicRoomMsg('视频连接成功', ROOM_TIP_MSG);
	}

	exports.onConnectErrorStatus = function(resp) {
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
			case 104:
				msg = "连接断开";
				break;
		}
		debug(resp.msg);
		addPublicRoomMsg('视频连接失败:' + msg, ROOM_TIP_MSG);
	}

	exports.onConnectClosed = function() {
		addPublicRoomMsg('视频连接已断开', ROOM_TIP_MSG);
	}

	exports.onConnectAppShutDown = function() {
		addPublicRoomMsg('视频服务已关闭', ROOM_TIP_MSG);
	}

	exports.onConnectCallFailed = function() {
		addPublicRoomMsg('远程调用失败', ROOM_TIP_MSG);
	}

	exports.onVideoPublish = function() {
		addPublicRoomMsg('视频发布开始', ROOM_TIP_MSG);
	}

	exports.onVideoPlay = function() {
		addPublicRoomMsg('视频播放开始', ROOM_TIP_MSG);
	}

	exports.onVideoStop = function() {
		addPublicRoomMsg('视频播放结束', ROOM_TIP_MSG);
	}

	exports.onVideoUnpublish = function() {
		addPublicRoomMsg('视频发布结束', ROOM_TIP_MSG);
	}

	exports.debug = function(msg) {
		if (console)
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


	exports.onChatMsg = function(errno, msg, msgData) {
		var errors = {100 : '该用户不再聊天室', 103 : '您已被禁言', 104 : '未登录', 105 : '发言频率过于频繁，请稍后再试', 106 : '短时间内不能发相同内容', 107 : '悲剧～～您被管理员禁言了T.T'};
		if (errno == 104) {
			user.showLoginPanel();
			return;
		};
		if (errno != 0) {
			addPrivateRoomMsg(errors[errno], ROOM_TIP_MSG);
			return;
		};
		msgData.msg = fillFace(msgData.msg);
		if (msgData.private) {
			addPrivateRoomMsg(msgData, ROOM_TALK_MSG);
		}
		else {
			addPublicRoomMsg(msgData, ROOM_TALK_MSG);
		}
	}

	exports.onBan = function(errno, msg, data) {
		if (!errno) {
			if (app.uid == data.banUid) {
				addPrivateRoomMsg('您已被禁言10分钟', ROOM_TIP_MSG);
			}
			else {
				addPublicRoomMsg(data.banNickname + ' 被禁言10分钟', ROOM_TIP_MSG);
			}
		}
		else {
			addPrivateRoomMsg('禁言失败', ROOM_TIP_MSG);
		}
	}

	exports.onTi = function(errno, msg, data) {
		if (!errno) {
			if (app.uid == data.banUid) {
				addPrivateRoomMsg('您已踢出房间', ROOM_TIP_MSG);
			}
			else {
				if (app.uid == data.tUid) {
					addPrivateRoomMsg('您已被踢出房间', ROOM_TIP_MSG);
				}
				else {
					addPublicRoomMsg(data.tiNickname + ' 被踢出房间', ROOM_TIP_MSG);					
				}
				var user = loginUserList[data.tUid];
				if (user) {
					tiRemoveUser(user);
					updateUserNum();
				}
			}
		}
		else {
			addPrivateRoomMsg('踢人失败', ROOM_TIP_MSG);
		}
	}

	exports.onSetAdmin = function(errno, msg, data) {
		if (!errno) {
			if (app.uid == data.auid) {
				addPrivateRoomMsg('您已被提升为管理员', ROOM_TIP_MSG);
			}
			else {
				addPublicRoomMsg(data.aNickname + ' 被提升为管理员', ROOM_TIP_MSG);
			}

			//移动位置
			var user = loginUserList[data.auid];
			if (!user) {
				debug("auid:" + data.auid + " 不在房间");
				return;
			}
			user.type = ROOM_ADMIN_USER;
			$('#roomUserItem0').append(user.dom);
			updateUserNum();
		}
		else {
			addPrivateRoomMsg('设置管理员失败', ROOM_TIP_MSG);
		}
	}

	var liuguang_handler = null;
	exports.onGiftMsg = function(errno, msg, data) {
		var errors = {200 : '该用户不在聊天室', 201 : '验证登录失败，请重新登录', 202 : '获取用户数据失败', 203 : '货币不足，请充值'};
		if (errno == 201) {
			user.showLoginPanel();
		};
		if (errno != 0) {addPropMsg(errors[errno], ROOM_TIP_GIFT_MSG);return;};

		sendGiftDelay(data, 0);

		if (data.showProp) {
			updatePropMaxinfo(data);
		};

		if (data.count >= 66) {//显示流光图片
			if (liuguang_handler) {
				clearTimeout(liuguang_handler);
			}
			$('.liuguang .rname').text(data.fromNickname);
			$('.liuguang .rname').click(function() {
				clickUser(data.from, this);
			});
			$('.liuguang img').attr('src', data.propPic);
			$('.liuguang .gift-num').text(data.count);
			$('.liuguang').show();
			liuguang_handler = setTimeout(function() {
				$('.liuguang').hide();
			}, 20000);	
		}

		head.refreshUserInfo();
	}

	exports.clickUser = function(uid, dom) {
		//当前登录的用户为普通用户 或者 选中用户不为普通用户
		if (app.type == ROOM_COMMON_USER || !(loginUserList[uid].type == ROOM_COMMON_USER)) {
			changeReceiver(uid);
		}
		else {
			$(dom).append($('#memberPanel'));
			$('#memberPanel .nickname').text(loginUserList[uid].nickname);
			if (loginUserList[uid].vip_level == VIP_LEVEL_USER) {
				$(dom).find('h1').addClass('vip');
			}
			else {
				$(dom).find('h1').removeClass('vip');
			}

			$('#memberPanel').attr('uid', uid);
			//房间主或者主播
			if (loginUserList[app.uid].type == ROOM_OWN_USER || loginUserList[app.uid].type == ROOM_MODERATOR_USER) {
				$('#memberPanel .admin').show();
			}
			else {
				$('#memberPanel .admin').hide();
			}
			
			$('#memberPanel').show();
		}
	}

	function updatePropMaxinfo(propInfo) {
		var time = new Date;
		time.setTime(propInfo.time*1000);
		var timeStr =(time.getMonth() + 1 > 10 ? time.getMonth() + 1 : '0' + (time.getMonth() + 1)) + '.' + (time.getDate()  > 10 ? time.getDate() : '0' + time.getDate()) + ' ' + (time.getHours() > 10 ? time.getHours() : '0' + time.getHours()) + ':' + (time.getMinutes() > 10 ? time.getMinutes() : '0' + time.getMinutes());
		var dom = $('<span><a href="javascript:room.changeReceiver(' + propInfo.from + ')">' + propInfo.fromNickname + '</a> 送给 <a href="javascript:room.changeReceiver(' + propInfo.to + ')">' + propInfo.toNickname + '</a> <b>' + propInfo.count + '个</b>' + propInfo.propName + '（' + timeStr + '）</span>');
		$('.roomNotice span').remove();
		$('.roomNotice').append(dom);
	}

	function addUser(user, showPublicMsg) {
		if (user.uid != UNLOGIN_UID) {
			if (loginUserList[user.uid]) {
				debug('addUser:' + user.uid + ' already in room');
				return;
			}
			if (showPublicMsg) {	
				addPublicRoomMsg(user, ROOM_USER_IN_MSG);
			};
			if (user.uid == app.mid) {user.nickname = '主播'};
			loginUserList[user.uid] = user;
		}
		else {//未登录
			user.nickname = '匿名用户';
			unLoginUserList[user.cid] = user;
		}
		var style = '';
		if (user.type == ROOM_ADMIN_USER || user.type == ROOM_MODERATOR_USER || user.type == ROOM_OWN_USER) {
			var area = "roomUserItem0";
		}
		else {
			var area = "roomUserItem1";
		}
		var type = '';
		if (user.uid == UNLOGIN_UID) {
			type = 'unlogined';
		}
		else if (user.vip_level == VIP_LEVEL_USER) {
			type = 'vip'
		}
		else {
			type = 'login';
		}
		user.dom = $('<li type="' + type + '" class="' + (type == 'vip' ? 'vip' : '') + '""><a class="rname" href="javascript:void(0)" style="width:95px;" onclick="room.clickUser(' + user.uid + ' ,this)">' + user.nickname + '</a><i>' + (user.height ? user.height : '-') + '/' + (user.weight ? user.weight : '-') + '</i><em></em></li>');
		if (user.uid == UNLOGIN_UID || $("#" + area + " ul li").length == 0) {
			$('#' + area + ' ul').append(user.dom);
		}
		else if (user.vip_level == VIP_LEVEL_USER) {
			if ($('#' + area + ' ul li[type=vip]:last').length == 0) {
				$('#' + area + ' ul').prepend(user.dom);
			}
			else {
				$('#' + area + ' ul li[type=vip]:last').after(user.dom);
			}
		}
		else {
			if ($('#' + area + ' ul li[type=login]:last').length == 0) {
				if ($('#' + area + ' ul li[type=vip]:last').length == 0) {
					$('#' + area + ' ul').prepend(user.dom);	
				}
				else {
					$('#' + area + ' ul li[type=vip]:last').after(user.dom);
				}
			}
			else {
				$('#' + area + ' ul li[type=login]:last').after(user.dom);
			}
		}
	}

	function userAreaBg(id) {
		$('#' + id + ' li:odd').css({backgroundColor : 'rgb(244,244,244)'});
		$('#' + id + ' li:even').css({backgroundColor: 'white'});
	}

	function removeUser(user) {
		if (user.uid != UNLOGIN_UID) {
			addPublicRoomMsg(user.nickname + "退出聊天室", ROOM_TIP_MSG);
			loginUserList[user.uid].dom.remove();
			delete loginUserList[user.uid];
		}
		else {
			unLoginUserList[user.cid].dom.remove();
			delete unLoginUserList[user.cid];
		}
	}

	function tiRemoveUser(user) {
		loginUserList[user.uid].dom.remove();
		delete loginUserList[user.uid];		
	}

	function updateUserNum() {
		var c_0 = 0, c_1 = 0;
		for (var uid in loginUserList) {
			if (loginUserList[uid].type == ROOM_ADMIN_USER  || loginUserList[uid].type == ROOM_MODERATOR_USER || loginUserList[uid].type == ROOM_OWN_USER) {c_0 ++;}
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
		swfobject.embedSWF('/swf/' + swf+".swf?v=0.25", placehoder, attributes.width, attributes.height, swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
	}


	var publicRoomFlag = false;
	function addPublicRoomMsg(msgData, type) {
		var table = $("#publicChatPanel table");
		var style = '';
		if (publicRoomFlag) {style="background-color:rgb(244,244,244)"};
		publicRoomFlag = !publicRoomFlag;
		if (type == ROOM_TIP_MSG) {
			table.append("<tr><td colspan=2>" + msgData + "</td></tr>");
		}
		else if(type == ROOM_TALK_MSG) {
			var date = new Date();
			date.setTime(msgData.timestamp);
			table.append('<tr style="' + style + '"><th>' + date.getHours() + ':'  + date.getMinutes() + '</th><td><span class="rname" onclick="room.clickUser(' + msgData.from + ', this)">' + msgData.fromNickname + '</span>' + (msgData.to == 0 ? '' : '对<span class="rname" onclick="room.clickUser(' + msgData.to + ', this)">' + msgData.toNickname + '</span>') + '说：' + msgData.msg + '</td></tr>');
		}
		else {
			table.append("<tr style='" + style + "'><td colspan=2><span class='rname' onclick='room.clickUser(" + msgData.uid + ", this)'>" + msgData.nickname + "</span>加入聊天室</td></tr>");
		}
		$("#publicChatPanel").scrollTop($("#publicChatPanel")[0].scrollHeight - $("#publicChatPanel").height());
	}

	function addPrivateRoomMsg(msgData, type) {
		if (type == ROOM_TIP_MSG) {
			$("#privateChatPanel ul").append($('<li>' + msgData + '</li>'));
		}
		else if (type == ROOM_TALK_MSG){
			$("#privateChatPanel ul").append($('<li><a href="javascript:void(0)" onclick="room.clickUser(' + msgData.from + ', this)">' + (msgData.from == app.uid ? '我' : msgData.fromNickname) + '</a>对<a onclick="room.clickUser(' + msgData.to + ', this)">' + (msgData.to == app.uid ? '你' : msgData.toNickname) + '</a>说：' + msgData.msg + '</li>'));
		}
		$("#privateChatPanel").scrollTop($("#privateChatPanel")[0].scrollHeight - $("#privateChatPanel").height());
	}

	function addPropMsg(msgData, type) {
		if (type == ROOM_TIP_GIFT_MSG) {
			$('#giftMsgPanel').append($('<li>' + msgData + '</li>'));
		}
		else if (type == ROOM_SEND_GIFT_MSG){
			var time = new Date;
			time.setTime(msgData.time * 1000);
			$('#giftMsgPanel').append($('<li><span class="time">'+ time.getHours() + ':' + time.getMinutes() +'</span>&nbsp;&nbsp;<a class="rname" href="javascript:void(0)" onclick="room.clickUser(' + msgData.from + ', this)">' + msgData.fromNickname + '</a> 送给 <a href="javascript:void(0)" class="rname" onclick="room.clickUser(' + msgData.to + ', this)">' + msgData.toNickname + '</a> ' + msgData.propName + ' <img src="' + msgData.propPic + '" width=48 height=48> <b>x' + msgData.loop + '</b></li>'));	
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
		var msg = $.trim($("#msgArea").val());
		if (msg.length > 50) {
			addPrivateRoomMsg("每次发送文本不能超过50个字符", ROOM_TIP_MSG);
			return;
		}
		swfobject.getObjectById("roomPlayer").doSendMsg({"msg" : msg, "to" : $("#msgReceiver").val(), "private" : $("#privateMsg")[0].checked});
		$("#msgArea").val('');
	}

	function sendGift() {
		if (!$("#chooseProp").attr('propId')) {
			addPropMsg('请选择礼物', ROOM_TIP_GIFT_MSG);
			return;
		}
		var num = parseInt($("#propNum").val());
		if (!num) {return};
		swfobject.getObjectById("roomPlayer").doSendGift($("#chooseProp").attr('propId'), num, $("#propTo").attr("to"));
	}


	function sendGiftDelay(data, loop) {
		if (data.count == loop) {
			return;
		}
		data.loop = ++loop;
		addPropMsg(data, ROOM_SEND_GIFT_MSG);
		setTimeout(function() {sendGiftDelay(data, loop);}, 5);
	}

	function changeReceiver(uid) {
		var user = loginUserList[uid];
		if(!$("#msgReceiver option[value=" + uid + "]").length) {
			$("#msgReceiver").append("<option value='" + uid + "'>" + user.nickname + "</option>");
		}
		$("#msgReceiver").val(uid);		
	}

	exports.changeReceiver = changeReceiver;

	function fillFace(msg) {
		for (var i = faces.length - 1; i >= 0; i--) {
			msg = msg.replace(new RegExp(faces[i].data, 'g'), '<img src="' + faces[i].img + '">');
		};
		msg = msg.replace(flower.data, '<img src="' + flower.img + '">');
		return msg;
	}

	function _loading_circle(r, t, holder, finish) {
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
        var interval = 200;
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
