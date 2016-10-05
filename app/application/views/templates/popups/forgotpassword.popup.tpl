<!-- Forgot password popup -->
<div class="forgotPasswordFull" ng-controller="AccountCtrl">
    <div class="ForgotPasswordContainer"></div>
    <div class="ForgotPasswordPopup">
        <a href="#" class="forgotPasswordClosePopup forgotPasswordClosePopupIcon"><i class="fa fa-close"></i></a>
        <div class="center-margin padding-bottom-15">
            <img src="{$MEDIA_FILES_URL}images/logo.png" class="img-responsive center-margin">
        </div>
        <hr>
        <form class="forgotPasswordForm" id="forgotPasswordForm" name="forgotPasswordForm" method="post" ng-submit="forgotpassword();" novalidate>
            <div class="col-xs-12">
                <div class="emailfield">
                    <input type="email" class="email form-control" name="registeredEmail" id="registeredEmail" placeholder="Email" maxlength="50" ng-model="user.email" required />
                    
                </div>
                <div class="col-xs-12 no-padding margin-top-10 forgotPasswordBtn">
                    <button type="submit" class="btn btn-blue center-button" id="forgotPasswordBtn"> SUBMIT </button>
                </div>
                <div id="loadingPassword" class="text-center loading"></div>
                <div class="col-xs-12 no-padding margin-top-10 forgotPasswordText" style="display:none;font-size: 13px;color: black;">
                    <p>Check your email</p>
                    <p>You should receive an email containing instructions on how to create a new password</p>
                    <br/>
                    <p style="font-weight: bold">Didn't receive the email?</p>
                    <p>Check spam or bulk folders for a message coming from <span style="font-weight: bold;">r2i@zinnov.com</span></p>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Forgot password popup -->