// for slideshow
let slideIndex = 0;
showSlides();

// function to change slideshow pictures every 3 seconds
function showSlides() {
  let i;
  
  let slides = document.getElementsByClassName("mySlides");
  // not to show slides
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    

  // show an slide
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 3000); // Change image every 3 seconds
}