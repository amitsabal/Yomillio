<html>
	<head>
        <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
        <link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="{$MEDIA_FILES_URL}js/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/resetpassword.css">
    
	<script type="text/javascript">
        var $APP_BASE_URL = "{$APP_BASE_URL}";
        var $MEDIA_FILES_URL = "{$MEDIA_FILES_URL}";
        
        //localStorage.clear();
        {if isset($smarty.session) && isset($smarty.session.session_user)}
            localStorage.setItem('user', {if isset($smarty.session.session_user->id)}'{$smarty.session.session_user->id}'{else}''{/if});
            localStorage.setItem('expires-at', {if isset($smarty.session.session_user->expires_at)}'{$smarty.session.session_user->expires_at}'{else}''{/if});
            localStorage.setItem('auth-token', {if isset($smarty.session.session_token)}'{$smarty.session.session_token}'{else}''{/if});
        {else}
            localStorage.removeItem('user');
            localStorage.removeItem('auth-token');
            localStorage.removeItem('expires-at');
            //localStorage.clear();
        {/if}
        
    </script>
	</head>
    <body>
        <input type="hidden" class="app_url" id="app_url" value="{$APP_BASE_URL}" />
        <input type="hidden" class="encryption_key" id="encryption_key" value="" />
        {if (isset($response->is_activated)) && $response->is_activated == 1}
        <div class="container resultdiv">
            <div class="resetpasswordcontainer">
                <div class="floatleft">
                    <img src="{$MEDIA_FILES_URL}images/logo.png" class="center-image">
                </div>
                <div class="marginTop10 floatleft">
                    <span>{$response->message}.<br/> Please <a href="{$APP_BASE_URL}">login</a> to continue</span>
                </div>
            </div>
        </div>
        {else}
        <div class="container expirediv">
            <div class="col-xs-12">
                <div class="col-xs-12 col-md-offset-5">
                    <img src="{$MEDIA_FILES_URL}images/logo.png" class="center-image">
                </div>
                <div class="marginTop10 col-xs-12 col-md-offset-4">
                    <span>{$response->message}</span>
					<br/>
					<span>Please click on <a href="{$APP_BASE_URL}account/resetactivationkey/{$response->activation_key}">link</a> to get new activation key!</span>
                </div>
            </div>
        </div>
		{/if}
        <script src="{$MEDIA_FILES_URL}js/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{$MEDIA_FILES_URL}js/bower_components/angular/angular.min.js"></script>
        <script src="{$MEDIA_FILES_URL}js/main.js"></script>
	</body>
</html>