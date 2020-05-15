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
});

$(window).resize(function() {
  $(".goods").each(function() {
    const width = $(document).width();
    let display = width > 620 ? "block" : "none";
    $(this).find(".description-main").css({ display });
  });
});

const goods = $(".goods");
const flexJustify = {};
flexJustify.justifyContent = goods.length % 3 === 1 ? "space-between" : "space-around";
$("#goods-area").css(flexJustify);

// input search
$("#main-header-goods-search").keyup(function() {
  const input = $(this).val();
  let counter = 0;
  $(".goods").each(function() {
    const name = $(this)
      .find(".name-searchable")
      .text()
      .toLowerCase();
    const categories = $(this)
      .find(".categories-searchable")
      .text()
      .toLowerCase();
    let display = "none"; 
    if (input === "" || 
      categories.includes(input) ||
      name.includes(input)) {
        display = "block";
        counter = input.length ? counter + 1 : goods.length;
      } 
    $(this).css("display", display);
  });
const flexJustify = {};  
flexJustify.justifyContent = counter % 3 === 1 ? 
  "space-between" : "space-around";
$("#goods-area").css(flexJustify);
});
