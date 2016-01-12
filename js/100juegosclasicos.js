function autoClick(){
	var i = 0;
	if($('.carousel-inner .item:visible').next('.carousel-inner .item').length != 0)
		i=$('.carousel-inner .item:visible').next('.carousel-inner .item').index();
	$('.carousel-inner .item').hide();$('.carousel-inner .item:eq('+i+')').fadeIn();return false;
}
(function(args){
	$('#myCarousel, #myCarousel div.content a').click(function(){$('.modalize').show();return false;});
	$('.modalize').click(function(){$('.modalize').hide()});
	$('.button-left').click(function(event){ var index = $('.thumbs-img:visible:first').index(); if(index>0 && index <6){$('.thumbs-img:eq('+(index+5)+')').hide();$('.thumbs-img:eq('+(index-1)+')').show();return false;}});
	$('.button-right').click(function(event){ var index = $('.thumbs-img:visible:last').index(); if(index <10){$('.thumbs-img:eq('+(index-5)+')').hide();$('.thumbs-img:eq('+(index+1)+')').show();return false;}});
	setInterval("autoClick();",5000);
})();
