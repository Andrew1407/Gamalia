$(document).ready(function () {
  $("body").css({
    opacity: 1,
    transition: "3s"
  });
});

$(".goods").each(function() {
  const desc = $(this).find(".goods-description");
  $(this).bind("click", function() {
    const width = $(document).width();
    if (width <= 620)
      desc.slideToggle(250);
  });
})

$(window).resize(function() {
  $(".goods").each(function() {
    const width = $(document).width();
    let display = width > 620 ? "block" : "none"
      $(this).find(".goods-description").css({ display })
  });
})
