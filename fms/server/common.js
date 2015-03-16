function mytrace(s){
    trace(s);
}

function jsonToString(obj){  
    switch(typeof(obj)){  
        case 'string':  
            return '"' + obj.replace(/(["\\])/g, '\\$1') + '"';  
        case 'array':  
            return '[' + obj.map(jsonToString).join(',') + ']';  
        case 'object':  
             if(obj instanceof Array){  
                var strArr = [];  
                var len = obj.length;  
                for(var i=0; i<len; i++){  
                    strArr.push(jsonToString(obj[i]));  
                }  
                return '[' + strArr.join(',') + ']';  
            }else if(obj==null){  
                return 'null';  

            }else{  
                var string = [];  
                for (var property in obj) string.push(jsonToString(property) + ':' + jsonToString(obj[property]));  
                return '{' + string.join(',') + '}';  
            }  
        case 'number':  
            return obj;  
        case false:  
            return obj;  
    }  
}

function mySetTimeout(func, timeout) {
    var id = setInterval(function() {
        clearInterval(id);
        func();
    }, timeout);
}

function getUserInfoByUid(uid) {
    for (var i = application.clients.length - 1; i >= 0; i--) {
        var client = application.clients[i];
        if (client.data && client.data.uid == uid) {
            return client.data;
        }
    }
    return null;
}
