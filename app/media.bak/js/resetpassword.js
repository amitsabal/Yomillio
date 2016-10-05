$(document).ready(function(){
    var alerts = function(){};
    alerts.type = {
        error : 'alert-danger',
        info : "alert-info"
    }
    alerts.add = function( message, type ) {
        if (type == undefined || type == null) {
            type = alerts.type.error;
        }
        var alert = '<div class="alerts">' +
                        '<div class="alert ' + type + ' alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong>Error!</strong> ' + message +
                        '</div>' +
                    '</div>';
        $("body").append(alert);
        hideAlertInterval = setInterval(hideAlerts,2000);
    }

    function hideAlerts() {
        $('.alerts').remove();
        clearInterval(hideAlertInterval);
    }

    var app_url = $(".app_url").val();
    $(".resultdiv").hide();
    $("#resetPasswordBtn").click(function(){
        var pwd = $.trim($("#newpassword").val());
        var email = $.trim($("#email").val());
        var passwordStrengthRegex = /((?=.*d)(?=.*[a-z])(?=.*[A-Z]).{8,15})/gm;
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
        if ($.trim($("#newpassword").val()) == '' || $.trim($("#confirmnewpassword").val()) == '' || $.trim($("#email").val()) == '') {
            alerts.add("All fields mandatory");
        }
        
        else if (!(regex.test(email))) {
            alerts.add("Invalid email format");
        }
        
        else if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*?[#?!@$%^&*-]).{8,}$/.test(pwd))) {
            alerts.add("Invalid Password! Password should contain atleast 1 Lowercase, 1 Uppercase, 1 Number, 1 Special character and should be 8 character long!");
        }
        
        else if ($.trim($("#newpassword").val()) != $.trim($("#confirmnewpassword").val())) {
            alerts.add("Passwords not matching!");
        }
        
        else{
            $("#resetPasswordBtn").attr('disabled', 'true');
            //save new password
            var JSONObject = {};
            JSONObject.password = $.trim($("#newpassword").val());
            JSONObject.email = $.trim($("#email").val());
            JSONObject.encryption_key = $(".encryption_key").val();
            JSONString = JSON.stringify(JSONObject);
            $.ajax({
                url : app_url+"user/updatepassword",
                type: "POST",
                data : JSONString,
                success: function(response, textStatus, jqXHR)
                {
                    console.log(response);
                    var JSONtext = response;
                    var JSONobject = JSON.parse(JSONtext);
                    $("#resetPasswordBtn").removeAttr('disabled');
                    if (JSONobject.success == 1) {
                        $(".resetpassworddiv").css('display','none');
                        $(".resultdiv").css('display','block');
                    }
                    else{
                        alerts.add(JSONobject.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $("#resetPasswordBtn").removeAttr('disabled');
                }
            });
        }
    })
})