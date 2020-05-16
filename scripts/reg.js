$(document).ready(function () {
  $("body").css({
    opacity: 1,
    transition: "3s"
  });
});

const patterns = {
  email: /^([a-z_\d\.-]+)@([a-z\d]+)\.([a-z]{2,8})(\.[a-z]{2,8})*$/,
  initials: /^[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19})* [А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19})*$/,
  phone: /^\+?[\d]{6,12}$/,
  passwd: /^.{5,16}$/
};

$(".form-input").each(function() {
  const parent = $(this);
  $(this)
    .find("input")
    .keyup(function() {
      const isMatched = patterns[parent.attr("id")].test($(this).val());
      const matchedStyle = {};
      matchedStyle.borderColor = isMatched ? "rgb(42, 165, 42)" : "crimson";
      parent.css(matchedStyle);
      $(this).css(matchedStyle);
    });
});
