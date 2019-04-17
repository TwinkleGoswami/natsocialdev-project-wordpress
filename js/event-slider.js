var slideIndex = 1;
jQuery(document).ready(function(){
showDivs(slideIndex);
});
function plusSlides1(n) {
  showDivs(slideIndex += n);
}

function currentSlide(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
	if(document.getElementsByClassName("mySlides_event_slide").length>0){
 	  var i;
	  var mySlides_event_slide = document.getElementsByClassName("mySlides_event_slide");
	  var dots = document.getElementsByClassName("demo");
	  var captionText = document.getElementById("caption1");
	  if (n > mySlides_event_slide.length) {slideIndex = 1}
	  if (n < 1) {slideIndex = mySlides_event_slide.length}
	  for (i = 0; i < mySlides_event_slide.length; i++) {
		 mySlides_event_slide[i].style.display = "none";
	  }
	  for (i = 0; i < dots.length; i++) {
		 dots[i].className = dots[i].className.replace(" active1", "");
	  }
	  
	  mySlides_event_slide[slideIndex-1].style.display = "block";
	  dots[slideIndex-1].className += " active1";
	  captionText.innerHTML = dots[slideIndex-1].alt;
	}
}
