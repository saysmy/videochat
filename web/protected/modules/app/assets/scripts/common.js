function getOS() {
    var a = navigator.userAgent.toLowerCase();
    var b = /android|iphone|ipad|ipod|windows phone|symbianos|nokia|bb/;
    var c = /linux|windows|mac|sunos|solaris/;
    var d = b.exec(a) || c.exec(a);
    return null == d ? "other" : d[0];
}