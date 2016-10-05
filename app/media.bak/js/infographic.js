jQuery(window).load(function(event) {
	bindInfographicEvent();
})

$(document).ready(function(){
});
$( window ).resize(function() {
});
$(document).keyup(function(event) { 
    if (event.which == 27) 
    {
    	if($('.viewFullInfographicImg').is(":visible")){
    		$('.closeFullImgIcon').click(); 
    	}
    	
    }
});

var bindInfographicEvent = function(){

	$('.infographicImg').unbind('click');
	$('.infographicImg').bind('click', function(event){
		event.preventDefault();
		$('.viewFullInfographicImg').show();
	})
	$('.closeFullImgIcon, .infographicContainer').unbind('click');
	$('.closeFullImgIcon, .infographicContainer').bind('click', function(event){
		event.preventDefault();
		$('.viewFullInfographicImg').hide();
	})
}