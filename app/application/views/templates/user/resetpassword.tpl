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
        <input type="hidden" class="encryption_key" id="encryption_key" value="{if isset($response->result->encryption_key)}{$response->result->encryption_key}{/if}" />
        <div class="container resetpassworddiv" style="{if isset($response->result->id) && $response->result->id > 0}display:block{else}display:none{/if}">
            <div class="resetpasswordcontainer">
                <div class="floatleft">
                    <img src="{$MEDIA_FILES_URL}images/logo.png" class="center-image">
                </div>
                <div class="marginTop10 floatleft">
                    <span>Reset your password</span>
                </div>
                <!--<div class="marginTop10 floatleft">
                    <span>You have requested to reset the password <br/>for : <b>{$response->result->email}</b></span>
                </div>-->
                <div class="marginTop10 col-xs-12 floatleft" style="padding:0px;">
                        <div class="marginTop10">
                            <input type="email" class="email form-control" name="email" id="email" placeholder="Email" maxlength="50" required />
                        </div>
                        <div class="marginTop10">
                            <input type="password" class="newpassword form-control" name="newpassword" id="newpassword" placeholder="New password" maxlength="50" required />
                        </div>
                        <div class="marginTop10">
                            <input type="password" class="confirmnewpassword form-control" name="confirmnewpassword" id="confirmnewpassword" placeholder="Confirm new password" maxlength="50" required />
                        </div>
                        <div class="col-xs-12 marginTop10" style="padding-right: 0px;">
                            <button type="submit" class="btn btnblue floatright" id="resetPasswordBtn"> RESET </button>
                        </div>
                </div>
            </div>
        </div>
        
        <div class="container resultdiv" style="display:none">
            <div class="resetpasswordcontainer">
                <div class="floatleft">
                    <img src="{$MEDIA_FILES_URL}images/logo.png" class="center-image">
                </div>
                <div class="marginTop10 floatleft">
                    <span>Your password has been changed successfully. Please <a href="{$APP_BASE_URL}?resetPassword=true">login</a> to continue</span>
                </div>
            </div>
        </div>
        
        <div class="container expirediv" style="{if !(isset($response->result->id)) || $response->result == ''}display:block{else}display:none{/if}">
            <div class="resetpasswordcontainer">
                <div class="floatleft">
                    <img src="{$MEDIA_FILES_URL}images/logo.png" class="center-image">
                </div>
                <div class="marginTop10 floatleft">
                    <span>The link you followed expired. Please restart the password reset flow.</span>
                </div>
            </div>
        </div>
        <script src="{$MEDIA_FILES_URL}js/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="{$MEDIA_FILES_URL}js/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="{$MEDIA_FILES_URL}js/bower_components/angular/angular.min.js"></script>
        <script src="{$MEDIA_FILES_URL}js/main.js"></script>
        <script src="{$MEDIA_FILES_URL}js/resetpassword.js"></script>
	</body>
</html>