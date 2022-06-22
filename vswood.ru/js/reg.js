$( document ).ready(function() {
    $("#regbtn").click(
        function(){
            sendAjaxForm('message', 'reg_form', 'reg_check.php');
            return false; 
        }
    );
});
 
function sendAjaxForm(message, reg_form, url) {
    $.ajax({
        url:     url, //url страницы
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: $("#"+reg_form).serialize(),  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
            result = $.parseJSON(response);
            $('#message').html(result.message);
        },
        error: function(response) { // Данные не отправлены
            $('#message').html('Ошибка. Данные не отправлены.');
        }
    });
}

    function checkParams() {
    var login = $('#login').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var password2 = $('#password2').val();
     
    if(login.length != 0 && email.length != 0 && password.length != 0 && password2.length != 0) {
        $('#regbtn').removeAttr('disabled');
    } else {
        $('#regbtn').attr('disabled', 'disabled');
    }
}