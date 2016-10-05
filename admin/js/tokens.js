(function () {
  var app = angular.module("chaipoint.tokens", []);

  app.factory('AuthTokenFactory', function AuthTokenFactory($window) {
    'use strict';
    var store = $window.localStorage;
    var key = 'auth-token';
    var uName = 'username';
    return {
      getToken: getToken,
      setToken: setToken,
      removeToken: removeToken,
      getUsername: getUsername,
      setUsername: setUsername,
      removeUsername: removeUsername

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

  });

  app.factory('AuthInterceptor', function AuthInterceptor(AuthTokenFactory) {
    'use strict';

    return {
      request: addToken
    };

    function addToken(config) {
      var token = AuthTokenFactory.getToken();
      //console.log("AuthInterceptor --",$token);
      if (token) {
        config.headers = config.headers || {}; // existing headers or new ones.
        config.headers.Authorization = 'Bearer ' + token;
      }
      return config;
    }
  });

})();