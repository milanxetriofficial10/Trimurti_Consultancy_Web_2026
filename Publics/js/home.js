
let slides = document.querySelectorAll('.slide');
let dots = document.querySelectorAll('.dots span');
let index=0;

// Show slide function
function showSlide(n){
    slides.forEach(s=>s.classList.remove('active'));
    dots.forEach(d=>d.classList.remove('active'));
    slides[n].classList.add('active');
    dots[n].classList.add('active');
}

// Auto slide
function nextSlide(){
    index = (index+1) % slides.length;
    showSlide(index);
}
let slideInterval = setInterval(nextSlide,4000);

// Dot click
dots.forEach((dot,i)=>{
    dot.addEventListener('click',()=>{
        index=i;
        showSlide(i);
        clearInterval(slideInterval); // stop auto-slide after manual click
        slideInterval = setInterval(nextSlide,4000); // restart auto-slide
    });
});


function openModal(src){
    document.getElementById("imgModal").style.display = "flex";
    document.getElementById("modalImg").src = src;
    document.getElementById("downloadBtn").href = src;
}

function closeModal(){
    document.getElementById("imgModal").style.display = "none";
}
