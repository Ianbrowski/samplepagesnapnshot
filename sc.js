// Smooth scroll for nav
const links = document.querySelectorAll('nav ul li a');
links.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    document.querySelector(link.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});
const hero = document.querySelector('.hero');

// Add your best photography URLs here
const images = [
  'https://picsum.photos/id/1011/1600/900',
  'https://picsum.photos/id/1015/1600/900',
  'https://picsum.photos/id/1016/1600/900',
  'https://picsum.photos/id/1019/1600/900'
];

let index = 0;

function changeBg() {
  index = (index + 1) % images.length;
  
  // Apply the new image
  hero.style.backgroundImage = `url('${images[index]}')`;
  
  // Trigger the fade animation
  hero.classList.remove('bg-fade');
  void hero.offsetWidth; // This "resets" the element to re-trigger animation
  hero.classList.add('bg-fade');
}

// Preload images to avoid flickering
images.forEach(image => {
  const img = new Image();
  img.src = image;
});

// Change every 5 seconds
setInterval(changeBg, 3000);
  // Check the URL for a success message
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('status') === 'success') {
      alert("Message sent successfully! We'll get back to you soon.");
  } else if (urlParams.get('status') === 'error') {
      alert("Oops! Something went wrong. Please try again.");
  }


// Portfolio lightbox
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const portfolioItems = document.querySelectorAll('.portfolio-item');
const closeBtn = document.querySelector('.lightbox .close');

portfolioItems.forEach(item => {
  item.addEventListener('click', () => {
    lightbox.style.display = 'flex';
    lightboxImg.src = item.src;
  });
});

closeBtn.addEventListener('click', () => {
  lightbox.style.display = 'none';
});

lightbox.addEventListener('click', e => {
  if(e.target === lightbox) lightbox.style.display = 'none';
});

// Scroll Reveal
const sections = document.querySelectorAll('.section');
window.addEventListener('scroll', () => {
  const triggerBottom = window.innerHeight * 0.85;
  sections.forEach(section => {
    const sectionTop = section.getBoundingClientRect().top;
    if(sectionTop < triggerBottom){
      section.classList.add('visible');
    }
  });
});
