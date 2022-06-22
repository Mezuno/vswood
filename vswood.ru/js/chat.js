const screenWidth = window.screen.width;

if (screenWidth <= 767) {
  viewChatDiv();
}

function send()
{
//Считываем сообщение из поля ввода с id mess_to_add
var mess=$("#messages__text-box").val();
// Отсылаем паметры
   $.ajax({
            type: "POST",
            url: "chat-add.php",
            data:"mess="+mess,
            // Выводим то что вернул PHP
            success: function(html)
    {
      //Если все успешно, загружаем сообщения
      load_messes();
      //Очищаем форму ввода сообщения
      $("#messages__text-box").val('');
            }
    });
}

var firstload = true;


function load_messes()
{
$.ajax({
            type: "POST",
            url:  "chat-load.php",
            data: "req=ok",
            // Выводим то что вернул PHP
            success: function(html)
    {
      //Очищаем форму ввода
      $("#messages__list").empty();
      //Выводим что вернул нам php
      $("#messages__list").append(html);
      //Прокручиваем блок вниз(если сообщений много)
      if (firstload) {
        $("#messages__list").scrollTop(90000);
        firstload = false;
      }
      if(checkFocus()) {$("#messages__list").scrollTop(90000);}
    }

    });
}

var checkFocus = function() {
    if (( $('#messages__list')[0].scrollHeight - ($('#messages__list').scrollTop() + $('#messages__list').height())) <= (100)) {
        return true;
    } else {
        return false;
    }
}

function add_online() {
  $.ajax ({
            type: "POST",
            url:  "online-add.php",
            data: "req=ok",
          success: function(html){}
  });
}
function load_online()
{
$.ajax({
            type: "POST",
            url:  "online-load.php",
            data: "req=ok",
            // Выводим то что вернул PHP
            success: function(html)
    {
      //Очищаем форму ввода
      $("#online__list").empty();
      //Выводим что вернул нам php
      $("#online__list").append(html);
            }
    });
} 



//При загрузке страницы подгружаем онлайн
add_online();
load_online();
//Ставим цикл на каждые 3 секунды
setInterval(add_online,1000);
setInterval(load_online,3000);
//При загрузке страницы подгружаем сообщения
load_messes();
//Ставим цикл на каждую секунду
setInterval(load_messes,1000);