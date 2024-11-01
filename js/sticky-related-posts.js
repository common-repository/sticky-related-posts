jQuery(document).ready(function($){  
    $(".srp-hide").click(function(){
		$(this).text(function(i,text){
          return text === "Show Related Posts" ? "Hide Related Posts" : "Show Related Posts";
      })
    //$(".srp-boxfloat").slideToggle();
	
	 $(".srp-boxfloat").slideToggle("fast", function(){
            if ($(this).is(":visible")) {  // <---- DOESN'T WORK -------
             $(".relatedpost-btn").css('top','-15px');
            }
            else {
             $(".relatedpost-btn").css('top','-28px');
            }
        });
	
	
    });
	
	$(window).scroll(function () {
		 if ($(window).scrollTop() > 550) {
	$(".srp-fixedbar, .srp-fixedbar2").css('display','inline-block');
	$(".srp-fixedbar, .srp-fixedbar2").css('position','fixed');
		 }
	if ($(window).scrollTop() < 551) {
      $(".srp-fixedbar, .srp-fixedbar2").css('display','none');
		}
	});
	
	$(".srp-boxfloat").mousemove(function(e) {
	var gLeft = $(this).offset().left,
      pX = e.pageX;
	$(this).find('.boxfiller').width(pX - gLeft);
	});
	
		
});

