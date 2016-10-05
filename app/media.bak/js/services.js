'use strict'

rti_app.service('noty', ['$rootScope', function( $rootScope ) {
        var queue = [];
        return {
            queue: queue,
            add: function( msg, type, icon ) {
                
                for(var i = 0; i < this.queue.length; i++)
                    this.remove();
                
                var item = {};
                item.body = msg;
                item.type = type;
                item.icon = icon;
                if(type == undefined) item.type = 'info';
                if(icon == undefined) item.icon = 'info';
                this.queue.push(item);
                
                
                setTimeout(this.remove,2000);
            },
            remove: function(){                
                // remove the alert after 2000 ms
                $('.alerts .alert').eq(0).remove();
                queue.shift();
            },
            success: function( msg ) {                
                this.add(msg, 'success', 'check');
            },
            error: function( msg ) {
                this.add(msg, 'danger', 'exclamation');
            },
            info: function( msg ) {
                this.add(msg);
            },
            pop: function(){
                return this.queue.pop();       
            },
            close: function(index){
                $('.alerts .alert').eq(index).remove();
            }
        };
    }]);



rti_app.factory('AuthInterceptor',['AuthTokenFactory',function AuthInterceptor(AuthTokenFactory) {
    'use strict';

    return {
        request: addToken,
        response: function(response) {
            
            return response;
        }
    };

    function addToken(config)
    {
        var token = AuthTokenFactory.getToken();
        if (token) {
                config.headers = config.headers || { }; // existing headers or new ones.
                config.headers.Authorization = 'X-token ' + token;
                config.headers['X-token'] = token;
        }
        
        return config;
    }
}]);



rti_app.factory('AuthTokenFactory', function AuthTokenFactory($window) {
    'use strict';
    var store = $window.localStorage;
    var key = 'auth-token';
    var user = 'user';
    return {
        getToken: getToken,
        setToken: setToken,
        removeToken: removeToken,
        getUser: getUser,
        setUser: setUser,
        removeUser: removeUser,
        isValidUser : isValidUser,
        isValidToken : isValidToken,
        clearAll : clearAll
    };

    function getToken() {
      return store.getItem(key);
    }

    function setToken(token) {
        if (token) {
            store.setItem(key, token);
        } else {
            store.removeItem(key);
        }
    }

    function removeToken() {
      return store.removeItem(key);
    }
    
    function getUser() {
        try {
            var s = store.getItem(user)
            if (s == null) {
                return null;
            }
            s = s.replace(/\\n/g, "\\n")  
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
            // remove non-printable and other non-valid JSON chars
            s = s.replace(/[\u0000-\u0019]+/g,""); 
            return JSON.parse(s);
        }catch(e) {
            alerts.add(e);
            console.log(e);
            //this.removeUser();
            //this.removeToken();
            return store.getItem(user)
        }
    }

    function setUser(cUser) {
        if (cUser) {
            store.setItem(user, JSON.stringify(cUser));
        } else {
            store.removeItem(user);
        }
    }

    function removeUser() {
        return store.removeItem(user);
    }
    
    function isValidUser() {
        var user = this.getUser();
        
        if (user == null) return false;
        return true;
    }
    
    function isValidToken() {
        var user = this.getUser();
        var curTime = new Date().getTime();
        if (user == null || (user.expires_at*1000) < curTime ) {
            return false;
        }
        
        return true;
    }
    
    function clearAll() {
        store.clear();
    }
});