const goods = Array.from(document.querySelectorAll(".goods"));

window.addEventListener("resize", e => {
  const width = document.body.clientWidth;
  const fontSize = width <= 620 ? "0" : "180%";
  goods.forEach(x => x.style.fontSize = fontSize);
});

goods.forEach(x => x.addEventListener("click", e => {
  const width = document.body.clientWidth;
  if (width <= 620) {
    let { fontSize } = x.style
    fontSize = fontSize !== "140%" ? "140%" : "0";
    x.style.fontSize = fontSize;
  }
}));
