let fields2 = document.querySelectorAll('.change-header__input');
Array.prototype.forEach.call(fields2, function (input) {

  input.addEventListener('change', function (e) {
    let countFiles = '';
    if (this.files && this.files.length >= 1){
      countFiles = this.files.length;
    }

    if (countFiles) {
      document.querySelector('.change-header__button').style.cssText = 'display:block';
    }
  });
});