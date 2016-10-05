jQuery(window).load(function(event) {
	imgResponsive();
})

var imgResponsive = function(){
	$('#page_content').find('img').attr('class', 'img-responsive');
	//$('#page_content').children('*').find('div').attr({'style':'width:100%','class':'padding-top-20'})
}