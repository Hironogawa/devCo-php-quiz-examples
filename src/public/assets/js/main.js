window.onload = function () {
  // Fade page in
  const body = document.querySelector("body");
  body.style.opacity = 0;
  setTimeout(() => {
    body.style.transition = "opacity 1s";
    body.style.opacity = 1;
  }, 500);
};
