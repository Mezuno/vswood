$(document).ready(function(){


	$("#convert").on("click", function () {

    $("input.main__answers-test-box").each(function () {
        var $txtarea = $("<textarea />");
        $txtarea.attr("id", this.id);
        $txtarea.attr("rows", 8);
        $txtarea.attr("cols", 40);
        $txtarea.attr("name", "answersToNote'.$i.'");     
        $txtarea.val(this.value);
        $(this).replaceWith($txtarea);
    });
});

});

let fields = document.querySelectorAll('.field__file');
Array.prototype.forEach.call(fields, function (input) {

  input.addEventListener('change', function (e) {
    let countFiles = '';
    if (this.files && this.files.length >= 1){
      countFiles = this.files.length;
    }

    if (countFiles) {
      document.querySelector('.pers__upload-button').style.cssText = 'display:block';
    }
  });
});