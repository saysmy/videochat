$(document).ready(function(){
	
	$(".t1 span").click(function(){
	  $(this).closest("div").toggleClass("on");
	});
	
	$(".details-open").click(function(){
	  $(this).closest("div").toggleClass("on");
	});
	
	$(".delivery li span").click(function(){
	  $(".delivery li").removeClass("on");
	  $(this).closest("li").addClass("on");	
	})
	
	$(".payItem em").click(function(){
	  $(".payItem").removeClass("on");
	  $(this).closest(".payItem").addClass("on");
	});
	
	$(".payBox h2 span").click(function(){
	  $(this).closest(".payBox").toggleClass("on");
	});
	
	$(".cate-sub dt a").click(function(){
	  $(".cate-sub dl").removeClass("on");
	  $(this).closest(".cate-sub dl").addClass("on");
	});
	
	//gotop
	$(".gotop").click(function(event) {
	  $('html,body').animate({scrollTop: 0},300)
	});
	
	$(".btn-2").click(function(){
	  $(".page-list").css({"display":"block"});	
	});
	
});