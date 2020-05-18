$(document).ready(function () {
  $("body").css({
    opacity: 1,
    transition: "3s"
  });
});

$("#input-image").change(function() {
  $(this).css("border-color", "rgb(42, 110, 165)")
    .parent()
    .css("border-color", "rgb(42, 110, 165)")
    .find("#output-image")
    .css("display", "block");
});

const patterns = {
  itemName: /^.{1,40}$/,
  price: /^\d{1,11}(\.\d{1,2})?$/,
  categories: /^[\.#\"\'А-ЯҐЄІЇA-Z'а-яґєіїa-z\d ]{1,18}(, [\.#\"\'А-ЯҐЄІЇA-Z'а-яґєіїa-z\d ]{1,18})*$/,
  discount: /^\d{1,2}(\.\d{1,2})?$/
};

$(".field").each(function() {
  $(this).find("input").keyup(function() {
    const isMatched = patterns[$(this).attr("name")].test($(this).val());
    const matchedStyle = {};
    matchedStyle.borderColor = isMatched ? "rgb(42, 110, 165)" : "crimson";
    $(this).css(matchedStyle)
      .parent()
      .css(matchedStyle);
  });
});
