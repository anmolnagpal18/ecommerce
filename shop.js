// Toggle mobile menu
function toggleMenu() {
  document.getElementById("nav-links").classList.toggle("active");
}



function openSearch() {
  document.getElementById("searchOverlay").classList.add("active");
}

function closeSearch() {
  document.getElementById("searchOverlay").classList.remove("active");
}

// Dropdown toggle
document.addEventListener("DOMContentLoaded", () => {
  const userDropdown = document.getElementById("userDropdown");

  userDropdown.addEventListener("click", function (e) {
    e.stopPropagation();
    this.classList.toggle("show");
  });

  document.addEventListener("click", function () {
    userDropdown.classList.remove("show");
  });
});







const slides = document.querySelectorAll('.slide');
const prev = document.querySelector('.prev');
const next = document.querySelector('.next');
let current = 0;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove('active');
    if (i === index) {
      slide.classList.add('active');
      slide.style.visibility = 'visible'; // Ensure visibility is set
    } else {
      slide.style.visibility = 'hidden'; // Hide other slides initially
    }
  });
}

function nextSlide() {
  current = (current + 1) % slides.length;
  showSlide(current);
}

function prevSlide() {
  current = (current - 1 + slides.length) % slides.length;
  showSlide(current);
}

next.addEventListener('click', nextSlide);
prev.addEventListener('click', prevSlide);

// Auto slide every 4 seconds
setInterval(nextSlide, 4000);

// Initial call to ensure the first slide is visible without delay
showSlide(current);






// card animation


  const cards = document.querySelectorAll('.product-card.slide-up');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1
  });

  cards.forEach(card => observer.observe(card));




// Add to cart button
// function manage_cart(pid,type){
//   var qty=jQuery("#qty").val();
//   jQuery.ajax({
//     url: "manage_cart.php",
//     type: "POST",
//     data: 'pid=' + pid + '&qty=' + qty + '$type='+ type,
//     success: function(result){
//       jQuery('.cart-count').html($result);

//     }
//   });
// }
function manage_cart(pid, type) {
  let quantity = document.getElementById("quantity").value;

  fetch('manage_cart.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'pid=' + pid + '&qty=' + quantity + '&type=' + type
  })
  .then(response => response.text())
  .then(data => {
      alert("Product added to cart!");

      // Update cart count in header
      const cartCount = document.getElementById('cart_count');
      if (cartCount && !isNaN(data)) {
          cartCount.textContent = data;
      }
  })
  .catch(error => console.error('Error:', error));
}

