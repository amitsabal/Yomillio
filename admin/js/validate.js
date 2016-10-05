$(document).ready(function(){
	/*Required Validation*/
	$("*[data-validation*='required'][type!='radio'][type!='checkbox']").focusout(function(){
		if( $(this).val() == '' && !$.trim( $(this).val( ) ).length )
    	{
    		$(this).parents(".form-group").addClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>This field is required</span>");
    		return false;
		}
	});

	$("*[data-validation*='required'][type!='radio'][type!='checkbox']").change(function(){
		if( $(this).val() != '' && $.trim( $(this).val( ) ).length > 0 )
    	{
    		$(this).parents(".form-group").removeClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("");
    		return false;
		}
	});

	/*Radio Box Validation*/
	$("input[data-validation*='required'][type='radio']").focusout(function(){
		var name = $(this).attr("name");
		if( $("input[type='radio'][name='"+name+"']:checked").val() == "" || $("input[type='radio'][name='"+name+"']:checked").val() == undefined )
    	{
    		$(this).parents(".form-group").addClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>This field is required</span>");
    		return false;
		}
	});
	$("input[data-validation*='required'][type='radio']").change(function(){
		var name = $(this).attr("name");
		if( $("input[type='radio'][name='"+name+"']:checked").val() != "" || $("input[type='radio'][name='"+name+"']:checked").val() != undefined )
    	{
    		$(this).parents(".form-group").removeClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("");
    		return false;
		}
	});

	/*Checkbox Validation*/
	$("input[data-validation*='required'][type='checkbox']").focusout(function(){
		var name = $(this).attr("name");
		if( $("input[type='checkbox'][name='"+name+"']:checked").val() == "" || $("input[type='checkbox'][name='"+name+"']:checked").val() == undefined )
    	{
    		$(this).parents(".form-group").addClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>This field is required</span>");
    		return false;
		}
	});
	$("input[data-validation*='required'][type='checkbox']").change(function(){
		var name = $(this).attr("name");
		if( $("input[type='checkbox'][name='"+name+"']:checked").val() != "" || $("input[type='checkbox'][name='"+name+"']:checked").val() != undefined )
    	{
    		$(this).parents(".form-group").removeClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("");
    		return false;
		}
	});

	/*Select Validation*/
	$("select").on("select2-blur", function(e) { 
		var value = $(this).val();
        if ($(this).data("validation").indexOf("required") != -1)
        {
            if(value == "" || value == undefined)
            {
                $(this).parents(".form-group").addClass("has-error");
                $(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Please select a value</span>");
            }
        }
        else{
			$(this).parents(".form-group").removeClass("has-error");
			$(this).parents(".form-group").find(".errormessage").html("");
		}
    	return false;
	});

	$("select").on("change", function(e) { 
		var value = $(this).val();
		if ($(this).data("validation").indexOf("required") != -1)
        {
			if(value != "" && value != undefined)
			{
				$(this).parents(".form-group").removeClass("has-error");
				$(this).parents(".form-group").find(".errormessage").html("");
			}
		}
		else{
			$(this).parents(".form-group").removeClass("has-error");
			$(this).parents(".form-group").find(".errormessage").html("");
		}
    	return false;
    });

	$("select").select2({
	    allowClear: true
	});

	/*Date Validation*/
	$("*[data-validation*='date'][type!='radio'][type!='checkbox']").focusout(function(){
		var datevalue = $(this).val();
		var regx = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
		if(!datevalue.match(regx))
    	{
    		$(this).parents(".form-group").addClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Enter valid date</span>");
    		return false;
		}
		else
		{
			if($(this).data("validation:contains('dateLessThanToday')"))
			{
				var dateEntered = $(this).val();
				var date = dateEntered.substring(0, 2);
			    var month = dateEntered.substring(3, 5);
			    var year = dateEntered.substring(6, 10);
			 
			    var dateToCompare = new Date(year, month - 1, date);
			    var currentDate = new Date();

				if (dateToCompare >= currentDate) 
				{
		    		$(this).parents(".form-group").addClass("has-error");
		    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Date must be less than today's date</span>");
		    		return false;
				}
			}
			else if($(this).data("validation:contains('dateGreaterThanToday')"))
			{
				var dateEntered = $(this).val();
				var date = dateEntered.substring(0, 2);
			    var month = dateEntered.substring(3, 5);
			    var year = dateEntered.substring(6, 10);
			 
			    var dateToCompare = new Date(year, month - 1, date);
			    var currentDate = new Date();

				if (dateToCompare < currentDate) 
				{
		    		$(this).parents(".form-group").removeClass("has-error");
		    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Date must be greater than today's date</span>");
		    		return false;
				}
			}
		}
	});

	$("*[data-validation*='date'][type!='radio'][type!='checkbox']").change(function(){
		var datevalue = $(this).val();
		var regx = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
		if(!datevalue.match(regx))
    	{
    		$(this).parents(".form-group").removeClass("has-error");
    		$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'></span>");
		}

		if($(this).data("validation:contains('dateLessThanToday')"))
		{
			var dateEntered = $(this).val();
			var date = dateEntered.substring(0, 2);
		    var month = dateEntered.substring(3, 5);
		    var year = dateEntered.substring(6, 10);
		 
		    var dateToCompare = new Date(year, month - 1, date);
		    var currentDate = new Date();

			if (dateToCompare < currentDate) 
			{
	    		$(this).parents(".form-group").removeClass("has-error");
	    		$(this).parents(".form-group").find(".errormessage").html("");
	    		return false;
			}
		}
		else if($(this).data("validation:contains('dateGreaterThanToday')"))
		{
			var dateEntered = $(this).val();
			var date = dateEntered.substring(0, 2);
		    var month = dateEntered.substring(3, 5);
		    var year = dateEntered.substring(6, 10);
		 
		    var dateToCompare = new Date(year, month - 1, date);
		    var currentDate = new Date();

			if (dateToCompare >= currentDate) 
			{
	    		$(this).parents(".form-group").removeClass("has-error");
	    		$(this).parents(".form-group").find(".errormessage").html("");
	    		return false;
			}
		}
	});
	$('.date').each(function(index, item){
		var validation = $(this).data("validation");
		if(validation.indexOf("dateLessThanToday") != -1)
		{
			$(this).datepicker({
				format: "yyyy/mm/dd",
				startView: 0,
				endDate: "-1d",
			    autoclose: true,
			    todayHighlight: false
			});
		}
		else if(validation.indexOf("dateGreaterThanToday") != -1)
		{
			$(this).datepicker({
				format: "yyyy/mm/dd",
				startView: 0,
				startDate: "+0d",
			    autoclose: true,
			    todayHighlight: false
			});
		}
		else{
			$(this).datepicker({
				format: "yyyy/mm/dd",
				startView: 0,
			    autoclose: true,
			    todayHighlight: true
			});
		}
	});

	/*Password Validation*/
	$("*[data-validation*='equals'][type!='radio'][type!='checkbox']").focusout(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("equals") != -1)
			{
				var equalField = validationArray[i];
				equalField = equalField.replace("equals(","");
				equalField = equalField.replace(')"]','');
				if($(this).val() != $("#"+equalField).val())
				{
					$("#"+equalField).parents(".form-group").addClass("has-error");
					$("#"+equalField).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Field does not match</span>");
					$(this).parents(".form-group").addClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>Field does not match</span>");
				}
			}
		};
	});

	$("*[data-validation*='equals'][type!='radio'][type!='checkbox']").change(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("equals") != -1)
			{
				var equalField = validationArray[i];
				equalField = equalField.replace("equals(","");
				equalField = equalField.replace(')"]','');
				if($(this).val() == $("#"+equalField).val())
				{
					$("#"+equalField).parents(".form-group").removeClass("has-error");
					$("#"+equalField).parents(".form-group").find(".errormessage").html("");
					$(this).parents(".form-group").removeClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("");
				}
			}
		};
	});

	$("*[data-validation*='minlength'][type!='radio'][type!='checkbox']").focusout(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("minlength") != -1)
			{
				var minlength = validationArray[i];
				minlength = minlength.replace("minlength(","");
				minlength = minlength.replace(')"]','');
				if($(this).val().length < Number(minlength))
				{
					$(this).parents(".form-group").addClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>"+$(this).parents(".form-group").find(".control-label").text().replace(" : *","")+" should have atleast "+minlength+" characters</span>");
				}
			}
		};
	});

	$("*[data-validation*='minlength'][type!='radio'][type!='checkbox']").change(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("minlength") != -1)
			{
				var minlength = validationArray[i];
				minlength = minlength.replace("minlength(","");
				minlength = minlength.replace(')"]','');
				if($(this).val().length >= Number(minlength))
				{
					$(this).parents(".form-group").removeClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("");
				}
			}
		};
	});

	$("*[data-validation*='maxlength'][type!='radio'][type!='checkbox']").focusout(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("maxlength") != -1)
			{
				var maxlength = validationArray[i];
				maxlength = maxlength.replace("maxlength(","");
				maxlength = maxlength.replace(')"]','');
				if($(this).val().length > Number(maxlength))
				{
					$(this).parents(".form-group").addClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>"+$(this).parents(".form-group").find(".control-label").text().replace(" : *","")+" should not exceed "+maxlength+" characters</span>");
				}
			}
		};
	});

	$("*[data-validation*='maxlength'][type!='radio'][type!='checkbox']").change(function(){
		var validations = $(this).attr("data-validation");
		var validationArray = validations.split(",");
		for (var i = validationArray.length - 1; i >= 0; i--) 
		{
			if(validationArray[i].indexOf("maxlength") != -1)
			{
				var maxlength = validationArray[i];
				maxlength = maxlength.replace("maxlength(","");
				maxlength = maxlength.replace(')"]','');
				if($(this).val().length >= Number(maxlength))
				{
					$(this).parents(".form-group").removeClass("has-error");
    				$(this).parents(".form-group").find(".errormessage").html("");
				}
			}
		};
	});
    
    $("*[data-validation*='number'][type!='radio'][type!='checkbox']").focusout(function(){
        if ( isNaN( $(this).val() ) ) {
            $(this).parents(".form-group").addClass("has-error");
            $(this).parents(".form-group").find(".errormessage").html("Please enter numbers");
        }
	});
    
    $("*[data-validation*='number'][type!='radio'][type!='checkbox']").change(function(){
        if ( ! isNaN( $(this).val() ) ) {
            $(this).parents(".form-group").removeClass("has-error");
            $(this).parents(".form-group").find(".errormessage").html("");
        }
	});

	$("form").submit(function (e) {
		var url = "";
		var jsonData = "";
		if($("#validationUrl").size() == 1)
		{
			url = $("#validationUrl").val();
			jsonData = JSON.stringify($('form').serializeObject());
		}
		else
		{
			url = $(this).data("validationurl");
			jsonData = JSON.stringify($(this).serializeObject());
		}

		if(validate($(this),url, jsonData)){
			return true;
		}
		e.preventDefault();
		return false;
	});
});

var isValid = false;
function validate($form, url, jsonData) 
{
    $form.find(".has-error").removeClass("has-error");
    $form.find(".errormessage").html("");
	$form.find("*[data-validation*='required'][type!='radio'][type!='checkbox']").focusout();
	$form.find("input[data-validation*='required'][type='radio']").focusout();
	$form.find("input[data-validation*='required'][type='checkbox']").focusout();
	$form.find("*[data-validation*='date'][type!='radio'][type!='checkbox']").focusout();
	$form.find("select").on("select2-blur");
	var count = $form.find(".has-error").size();
	if(count == 0)
	{
		if(url != ""){
			Ajax(jsonData, url, _showerrormessage, false, "POST", true);
		}
		else{
			return true;
		}
		return isValid;
	}
	return false;
}

function _showerrormessage(response)
{
	var jsonObj = JSON.parse(response);
	if(jsonObj.success == 1)
	{
		isValid = true;
		var callbackMethod = _showerrormessagecallback;
		if(isFunction(callbackMethod))
			callbackMethod(jsonObj);
	}
	else{
		for (var name in jsonObj.messages) 
		{
			$("#"+name).parents(".form-group").addClass("has-error");
			$("#"+name).parents(".form-group").find(".errormessage").html("<span class='inputerrormsg'>"+jsonObj.messages[name]+"</span>");
		}
		isValid = false;
	}
}

function isFunction(functionToCheck) {
 	if (typeof(functionToCheck) != "undefined"){
 		return true;
 	}
 	return false;
}