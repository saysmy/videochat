
function Source(rid) {

    this.service = NetServices.createGatewayConnection(ServerURL).getService("ChatService", this);
    //暂存刚接收到的请求
    this.unConnectedClients = {};
    //app刚启动时未连接成功的请求
    this.userConnectionCache = [];
    //标示本机客户端是否正在发布视频
    this.isClientPublishing = false;

    this.lastStream = null;

    this.mid = null;

    //获取源地址
    this.getSource_Result = function(resp) {

        mytrace("getSource:" + jsonToString(resp));

        if (resp.errno) {
            mytrace('getSource error:' + resp.errno + ' msg:' + resp.msg);
            application.shutdown();
        }
        else {

            var sip = resp.data.sip;

            this.cidPrefix = resp.data.cidPrefix;
            this.sourceUrl = 'rtmp://' + sip + '/' + application.name;
            this.sourceVideoUrl = 'rtmp://' + sip + '/live/' + application.name;

            //attach数据源            
            this.myNC.connect(this.sourceUrl);
            this.myNC.userBroadcast = this._userBroadcast;
            this.myNC.userConnectResp = this._userConnectResp;
            this.myNC.userCall = this._userCall;
            this.myNC.doPublish = this._transferPublish;
            this.myNC.banResp = this._banResp;
            this.myNC.source = this;

            //视频源
            this.myPlayNC.connect(this.sourceVideoUrl);
            this.myPlayNC.source = this;

        }
    }

    this.getSource_Status = function(result) {
        application.shutdown();
    }
    this.service.getSource(rid);
    
    //向数据源发起连接
    this.userConnect = function(sid, uid, rid, client) {
        var cid = client.id;

        mytrace("userConnect cid:" + cid + " uid:" + uid + " sid:" + sid + " rid:" + rid);

        this.unConnectedClients[cid] = client;

        cid = this._getCidForCall(cid);

        //实例刚启动时，可能数据源还未连接上
        if (!this.myNC.isConnected) {
            mytrace('userConnect NetConnection not connected');
            this.userConnectionCache.push([sid, uid, rid, client]);
            return;
        }

        this.myNC.call('userConnect', null, sid, uid, rid, cid);


    }

    //向数据源发起断开连接
    this.userDisconnect = function(cid) {

        mytrace("userDisconnect cid:" + cid);

        cid = this._getCidForCall(cid);
        this.myNC.call('userDisconnect', null, cid);
    }

    //检测是否存在视频
    this.checkVideo = function(cid) {

        mytrace("checkVideo cid:" + cid);

        cid = this._getCidForCall(cid);
        this.myNC.call('isPlaying', null, cid);
    }

    //发布视频
    this.publish = function(streamObj, uid) {

        mytrace("publish to source");

        this.isClientPublishing = true;
        this.mid = uid;

        //视频流发布专用连接
        this.myPublish_NSNC = new NetConnection();
        this.myPublish_NSNC.connect(this.sourceVideoUrl);
        this.myPublish_NSNC.onStatus = this._Publish_NSNC_onStatus;
        this.myPublish_NSNC.onBWDone = this._onBWDone;
        this.myPublish_NSNC.source = this;

        this._initPublishStream(streamObj);
        this.lastStream = streamObj;

        this.myNC.call('userPublish', null, uid);
    }

    this.unpublish = function(streamObj, uid) {
        mytrace('unpublish');

        this.myPublishNetStream.publish(false);
        this.myPublishNetStream.attach(false);
        this.lastStream = null;

        this.isClientPublishing = false;

        //关闭连接后数据流才会真正销毁 否则其他机器发布视频会失败
        this.myPublish_NSNC.close();

        this.mid = null;

        this.myNC.call('userUnpublish', null, uid);
    }

    //发送消息
    this.sendMsg = function(msgData, cid) {

        mytrace("sendMsg msgData:" + jsonToString(msgData) + " cid:" + cid);

        cid = this._getCidForCall(cid);
        this.myNC.call('sendMsg', null, msgData, cid);
    }

    //送礼物
    this.sendGift = function(propId, count, to, cid) {

        mytrace("sendGift propId:" + propId + " count:" + count + " to:" + to + " cid:" + cid);

        cid = this._getCidForCall(cid);
        this.myNC.call('sendGift', null, propId, count, to, cid);
    }

    //禁言
    this.ban = function(buid, cid) {

        mytrace("ban buid:" + buid + " cid:" + cid);

        this.myNC.call('ban', null, buid, this._getCidForCall(cid));
    }

    //踢出房间
    this.ti = function(tuid, cid) {

        mytrace('ti tuid:' + tuid + ' cid:' + cid);

        this.myNC.call('ti', null, tuid, this._getCidForCall(cid));
    }

    //设置为管理员
    this.setAdmin = function(auid, cid) {
        mytrace('setAdmin auid:' + auid + ' cid:' + cid);

        this.myNC.call('setAdmin', null, auid, this._getCidForCall(cid));
    }

    //转发数据源广播
    this._userBroadcast = function(cmd, errno, msg, data, type, cid) {

        mytrace("userBroadcast cmd:" + cmd + " type:" + type + " cid:" + cid + " data:" + jsonToString(data));

        if (type == USER_BROADCAST) {
            application.broadcastMsg(cmd, errno, msg, data);
        }
        else if (type == USER_BROADCAST_TO) {

            var client = this.source._getClient(cid);
            if (!client) {
                return;
            }

            client.call(cmd, null, errno, msg, data);
        }

        if (cmd == 'onPublish') {
            if (!this.source.isClientPublishing) {
                mytrace("onPublish initStream");
                this.source._initStream();
            }
        }
        else if (cmd == 'onUnpublish') {
            if (this.source.myStream) {
                mytrace('onUnpublish destroy stream');
                Stream.destroy(this.source.myStream);
                this.source.myStream = null;
            }
        }
        else if (cmd == 'onTi' && errno == 0) {//被踢出房间，则断开连接
            var client = this.source._getClient(data.tCid);
            if (!client) {
                return;
            }
            mySetTimeout(function() {
                application.disconnect(client);
            }, 100);
        }

    }

    //数据源连接响应
    this._userConnectResp = function(errno, msg, userInfo, cid) {

        mytrace("userConnectResp errno:" + errno + " userInfo:" + jsonToString(userInfo) + " cid:" + cid);

        var client = this.source.unConnectedClients[cid.substring(this.source.cidPrefix.length + 1)];
        if (!client) {
            mytrace("unConnectedClients not find client id:" + cid);
            client = this.source._getClient(cid);
            if (!client) {
                mytrace("can not find client id:" + cid);
                return;
            }
        }

        if (errno == 0) {
            client.data = userInfo;
            client.data.client = client;
            application.acceptConnection(client);
        }
        else {
            //这里客户端接收不到该状态
            // application.rejectConnection(client, {errno : errno});
            application.acceptConnection(client);
            //所以改用call调用通知
            client.call('onConnectStatus', null, errno, '', {});
            mySetTimeout(function() {
                application.disconnect(client);
            }, 100);
        }


        delete this.source.unConnectedClients[cid];
    }

    //转发数据源的数据
    this._userCall = function(cmd, errno, msg, data, cid) {

        mytrace("userCall cmd:" + cmd + " data:" + jsonToString(data) + " cid:" + cid);

        var client = this.source._getClient(cid);
        if (!client) {
            return;
        }

        client.call(cmd, null, errno, msg, data);
    }

    this._transferPublish = function() {
        mytrace("transfer Publish stream");
        this.source._initStream();
    }

    this._initStream = function() {
        this.myStream = Stream.get(streamName);
        if (!this.myStream){
            mytrace("Stream.get error");
            return;
        }
        this.myStream.onStatus = this._Stream_onStatus;
        this.myStream.play(streamName, -2, -1, false, this.myPlayNC);    
    }

    this._getClient = function(cid) {
        if (!this._checkCidBelong(cid)) {
            return;
        }
        cid = cid.substring(this.cidPrefix.length + 1);

        var client = null;
        for (var i = application.clients.length - 1; i >= 0; i--) {
            if (application.clients[i].id == cid) {
                client = application.clients[i];
                break;
            }
        };
        if (!client) {
            mytrace('can not find client id:' + cid);
            return;
        }
        return client;
    }

    this._NC_onStatus = function(info) {

        mytrace("NetConnection:" + info.code);

        switch (info.code) {
            case 'NetConnection.Connect.Success' :

                if (this.source.userConnectionCache.length) {
                    for (var i = 0; i < this.source.userConnectionCache.length; i++) {
                        var connectionArgu = this.source.userConnectionCache[i];

                        mytrace('userConnectCache:' + jsonToString(connectionArgu));

                        this.source.userConnect(connectionArgu[0], connectionArgu[1], connectionArgu[2], connectionArgu[3]);
                    };
                    this.source.userConnectionCache = [];
                }

                break;

            case 'NetConnection.Connect.Failed' :
            case 'NetConnection.Connect.Closed' :
                //重连
                this.source.myNC.connect(this.source.sourceUrl);

                break;
            case 'NetConnection.Connect.Rejected' :
                break;
        }
    }

    this._Play_NC_onStatus = function(info) {
        mytrace("Play NetConnection:" + info.code);
        switch (info.code) {
            case 'NetConnection.Connect.Success' :
                break;

            case 'NetConnection.Connect.Failed' :
            case 'NetConnection.Connect.Closed' :
                //重连
                this.connect(this.source.sourceVideoUrl);

                break;
            case 'NetConnection.Connect.Rejected' :
                break;
        }

    }

    this._Publish_NS_onStatus = function(info) {
        mytrace('publish netstream:' + info.code);
    }

    this._Publish_NSNC_onStatus = function(info) {
        mytrace("Publish NetStream NetConnection:" + info.code);
        switch (info.code) {
            case 'NetConnection.Connect.Success' :
                break;

            case 'NetConnection.Connect.Failed' :
            case 'NetConnection.Connect.Closed' :
                if (this.source.isClientPublishing) {//客户端
                    var userInfo = getUserInfoByUid(this.source.mid);
                    if (!userInfo) {
                        mytrace("cannot find moderator");
                        return;
                    }
                    userInfo.client.call('onPublishStatus', null, 1, '', {});
                }
                break;
            case 'NetConnection.Connect.Rejected' :
                break;
        }

    }

    this._Stream_onStatus = function(info) {
        mytrace('Stream:' + info.code);
    }

    this._initPublishStream = function(stream) {
        this.myPublishNetStream = new NetStream(this.myPublish_NSNC);
        this.myPublishNetStream.onStatus = this._Publish_NS_onStatus;
        this.myPublishNetStream.attach(stream);
        this.myPublishNetStream.publish(stream.name);       
    }

    this._onBWDone = function() {

    }

    this._getCidForCall = function(cid) {
        return this.cidPrefix + '_' + cid;
    }

    this._checkCidBelong = function(cid) {//判断cid是否属于本机
        mytrace('check belong prefix:' + cid.substring(0, cid.indexOf('_')));
        return cid.substring(0, cid.indexOf('_')) == this.cidPrefix;
    }

    this.myNC = new NetConnection();
    this.myNC.onStatus = this._NC_onStatus;

    this.myPlayNC = new NetConnection();
    this.myPlayNC.onStatus = this._Play_NC_onStatus;
    this.myPlayNC.onBWDone = this._onBWDone;

}

application.registerClass('Source', Source);