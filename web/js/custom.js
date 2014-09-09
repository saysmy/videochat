$(document).ready(function(){
	
	$(".mainBig > dl:nth-child(3)").css({"margin-right":"0"});
	
	var docHeight = $(document).height();
	var docWidth = $(document).width();
	var winHeight = $(window).height();
	$(".sliderPanel").css({
		'left':((docWidth)-60)/2
	});
	
	
	$("#alipay").click(function(){
	  $("#nbank").removeClass("on");
	  $(this).addClass("on");
	  $(".nbankList").css({"display":"none"});
	  return false;
	})
	$("#nbank").click(function(){
	  $("#alipay").removeClass("on");
	  $(this).addClass("on");
	  $(".nbankList").css({"display":"block"})
	  return false;
	})
		 
});