const header = document.querySelector("header");

function fixedNavbar() {
  console.log("Current Y Offset:", window.pageYOffset);
  header.classList.toggle("scrolled", window.pageYOffset > 0);
}

// Gọi hàm một lần để áp dụng lớp "scrolled" nếu cần
fixedNavbar();
window.addEventListener("scroll", fixedNavbar);

let menuBtn = document.querySelector("#menu-btn");
let userBtn = document.querySelector("#user-btn");

menuBtn.addEventListener("click", function () {
  let nav = document.querySelector(".navbar");
  nav.classList.toggle("active");
});

userBtn.addEventListener("click", function () {
  let userBox = document.querySelector(".user-box");
  userBox.classList.toggle("active");
});
// --------home-page-slider--------
("user strict");
const leftArrow = document.querySelector(".left-arrow .bxs-left-arrow");
const rightArrow = document.querySelector(".right-arrow .bxs-right-arrow");
const slider = document.querySelector(".slider");

// ----------scroll to right ---------
function scrollRight() {
  if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
    slider.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else {
    slider.scrollBy({
      left: window.innerWidth,
      behavior: "smooth",
    });
  }
}
// ----------scroll to left ----------
function scrollLeft() {
  slider.scrollBy({
    left: -window.innerWidth,
    behavior: "smooth",
  });
}
let timerId = setInterval(scrollRight, 7000);
// ------------reset timer to scroll right------------
function resetTimer() {
  clearInterval(timerId);
  timerId = setInterval(scrollRight, 7000);
}
// ------------scroll event------------
slider.addEventListener("click", function (ev) {
  if (ev.target === leftArrow) {
    scrollLeft();
    resetTimer();
  }
});

slider.addEventListener("click", function (ev) {
  if (ev.target === rightArrow) {
    scrollRight();
    resetTimer();
  }
});
// const icons = document.querySelectorAll(".thumb .box-container .box i");

// icons.forEach((icon) => {
//   icon.addEventListener("click", function () {
//     // Lấy phần tử cha .box của biểu tượng vừa nhấn
//     const box = this.closest(".box");
//     // Tìm ảnh trong ptử .box
//     const img = box.querySelector("img");
//     // Xoaykhi nhấn
//     img.style.transform = img.style.transform === 'rotateY(180deg)' ? 'rotateY(0deg)' : 'rotateY(180deg)';

//   });
// });
// -----------------testiminial slider---------------------
let sliders = document.querySelectorAll(".testimonial-item");
let index = 0;

function nextSlide() {
  sliders[index].classList.remove("active");
  index = (index + 1) % sliders.length;
  sliders[index].classList.add("active");
}

function prevSlide() {
  sliders[index].classList.remove("active");
  index = (index - 1 + sliders.length) % sliders.length;
  sliders[index].classList.add("active");
}

document.querySelector(".right-arrow").addEventListener("click", nextSlide);
document.querySelector(".left-arrow").addEventListener("click", prevSlide);
