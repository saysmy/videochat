function qqLogin(loginUrl) {
    var width = 700;
    var height = 500;
    var win = window.screen,left=(win.width- width)/2,top=(win.height - height - 60)/2;
    try{
        window.external.openLoginWindow('{"title":"QQ登录","from":"LoginUi","to":"Loginer","cmd":"openLoginWindow","ThirdUrl":"' + loginUrl + '","nWndWidth":'+width+',"nWndHeight":'+width+"}");
    }catch(s){
        window.open(loginUrl,"letv_coop_login","toolbar=0,status=0,resizable=1,width="+width+",height="+height+",left="+(left>0?left:0)+",top="+(top>0?top:0));
    }   
}