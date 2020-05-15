$(document).ready(function () {
  $("body").css({
    opacity: 1,
    transition: "3s"
  });
});

const patterns = {
  quantity: /^[\d]{1,10}$/,
  dest: /^.{1,80}$/
};

$(".form-input").each(function() {
  $(this).keyup(function() {
    const isMatched = patterns[$(this).attr("id")].test($(this).val());
    const matchedStyle = {};
    matchedStyle.borderColor = isMatched ? "rgb(5, 136, 16)" : "crimson";
    $(this).css(matchedStyle);
  })
});

