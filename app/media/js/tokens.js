(function () {
  var app = angular.module("chaipoint.tokens", []);

  app.factory('AuthTokenFactory', function AuthTokenFactory($window) {
    'use strict';
    var store = $window.localStorage;
    var key = 'auth-token';
    var email = 'email';
    return {
      getToken: getToken,
      setToken: setToken,
      removeToken: removeToken,
      getEmail: getEmail,
      setEmail: setEmail,
      removeEmail: removeEmail

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


      function getEmail() {
          return store.getItem(uName);
      }

      function setEmail(email) {
          if (email) {
              store.setItem(uName, email);
          } else {
              store.removeItem(uName);
          }
      }

      function removeEmail() {
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