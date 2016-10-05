'use strict'

app.service('noty', ['$rootScope', function( $rootScope ) {
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
                
                
                setTimeout(this.remove,5000);
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



app.factory('AuthInterceptor',['AuthTokenFactory',function AuthInterceptor(AuthTokenFactory) {
    'use strict';

    return {
        request: addToken,
        response: function(response) {
            // do something on success
            if (response.data != undefined && response.data.error) {
                if (response.data.message == "SESSION_EXPIRED") {
                    //$state.go("login");
                }
                if (response.data.message == "Invalid token") {
                    //$state.go("login");
                }
            }
            
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

app.factory('noCacheInterceptor', function () {
    return {
        request: function (config) {
            //console.log(config.method);
            //console.log(config.url);
            if(config.method=='GET'){
                var separator = config.url.indexOf('?') === -1 ? '?' : '&';
                config.url = config.url+separator+'noCache=' + new Date().getTime();
            }
            //console.log(config.method);
            //console.log(config.url);
            return config;
       }
    };
});



app.factory('AuthTokenFactory', function AuthTokenFactory($window) {
    'use strict';
    var store = $window.localStorage;
    var key = 'admin-auth-token';
    var uName = 'admin-username';
    var uId = 'admin-user-id';
    return {
        getToken: getToken,
        setToken: setToken,
        removeToken: removeToken,
        getUsername: getUsername,
        setUsername: setUsername,
        removeUsername: removeUsername,
        getAdminUserId: getAdminUserId,
        setAdminUserId: setAdminUserId,
        removeAdminUserId: removeAdminUserId,
        isLoggedIn: isLoggedIn
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

    function getUsername() {
        return store.getItem(uName);
    }

    function setUsername(username) {
        if (username) {
            store.setItem(uName, username);
        } else {
            store.removeItem(uName);
        }
    }

    function removeUsername() {
        return store.removeItem(uName);
    }
    
    function getAdminUserId() {
        return store.getItem(uId);
    }

    function setAdminUserId(userId) {
        if (userId) {
            store.setItem(uId, userId);
        } else {
            store.removeItem(uId);
        }
    }

    function removeAdminUserId() {
        return store.removeItem(uId);
    }
    
    function isLoggedIn() {
        if (this.getToken() == null) {
                return false;
        }
        return true;
    }
});

app.run(['$rootScope', '$state', 'AuthTokenFactory', '$http', function ($rootScope, $state, AuthTokenFactory, $http) {
	$rootScope.$on('$stateChangeStart', function (event, toState, toParams) {
        //console.log("STATE",toState, toParams);
		$rootScope.layout = toState.data.layout;
        
        toState.data.params = toParams;
        //console.log(toState);
		var requireLogin = toState.data.requireLogin;
        var token = AuthTokenFactory.getToken();
        
        $rootScope.username = AuthTokenFactory.getUsername();
        $rootScope.token = token;
        $rootScope.page = toState.data.page;
        $rootScope.requireLogin = requireLogin;
        //console.log("TOKEN",token);
        
        //$http.defaults.headers.common.Authorization = 'X-token ' + token;
        
		if (requireLogin && (typeof token === 'undefined' || token == null) ) {
		  	event.preventDefault();		  	
			$rootScope.layout = "login";
			$state.go('login');
		}
        
        if (toState.name == "login") {
            AuthTokenFactory.removeToken();
            AuthTokenFactory.removeUsername();
            AuthTokenFactory.removeAdminUserId();
        }
	});

}]);