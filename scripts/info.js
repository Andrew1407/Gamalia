$(document).ready(function () {
  $("body").css({
    opacity: 1,
    transition: "3s"
  });
});

const patterns = {
  email: /^([_a-z\d\.-]+)@([_a-z\d]+)\.([a-z]{2,8})(\.[a-z]{2,8})*$/,
  initials: /^[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19})* [А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19}(-[А-ЯҐЄІЇA-Z]['а-яґєіїa-z]{1,19})*$/,
  phone_number: /^\+?[\d]{6,12}$/,
  passwd: /^.{5,16}$/
};

$(".editable").each(function() {
  $(this).click(function() {
    const text = $(this).text();
    const isPasswd = $(this).attr("id") === "info-passwd";
    const inputVal = isPasswd ? "" : text.trim();
    $(this)
      .parent()
      .find("input")
      .val(inputVal);
    $(this)
      .css("display", "none")
      .parent()
      .find("input")
      .css("display", "block")
      .keyup(function({ key }) {
        if (key == "Escape")
          $(this)
            .css("display", "none")
            .parent()
            .find(".editable")
            .css("display", "block");
            
        const test = $(this).attr("id");
        const pattern = patterns[test];
        const input = $(this).val();
        const isMatched = pattern.test(input);
        if (key === "Enter") {
          const outputField = $(this)
            .css("display", "none")
            .parent()
            .find(".editable")
            .css("display", "block");
          const fieldVal = outputField.text();
          if (isMatched && input !== fieldVal) {
            $("#info-btn").css("display", "block");
            const infoChanged = JSON
              .parse($("#infoChanged")
                .val()
              );
            infoChanged[test] = input;
            $("#infoChanged")
              .val(JSON.stringify(infoChanged));
          }
          outputField.text(!isPasswd && isMatched ? input : fieldVal);
        } else {
          const matchedStyle = {};
          matchedStyle.borderColor = isMatched ? "rgb(42, 165, 42)" : "crimson";
          $(this).css(matchedStyle);      
        }
      });
  });
});
