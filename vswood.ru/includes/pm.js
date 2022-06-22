const screenWidth = window.screen.width;

const alert = '<div class="no-user">Выберите пользователя для общения</div>';
$("#messages__list").append(alert);
  
if (screenWidth <= 767) {
  viewOnlineDiv();
}
$(document).on('click', '.fa-arrow-left', function() {
  $("#messages__text-box").val('');
  $("#user").empty();
	$("#messages__list").empty();
	$("#messages__list").append(alert);
  if (screenWidth <= 767) {
    viewOnlineDiv();
  }
  $("input:radio[name=id]:checked").prop("checked", false);
});


function send()
{
//Считываем сообщение из поля ввода с id mess_to_add
var mess=$("#messages__text-box").val();
var id=$("input:radio[name=id]:checked").val();


// Отсылаем паметры
   $.ajax({
            type: "POST",
            url: "pm-chat-add.php",
            data: {"id": id, "mess": mess},
            // Выводим то что вернул PHP
            success: function(html)
            {
              //Если все успешно, загружаем сообщения
              load_messes('all');
              //Очищаем форму ввода сообщения
              $("#messages__text-box").val('');
            }
    });
}


$(document).on('click', '.delete-mess-radio', function() {
var id=$("input:radio[name=delete-mess-button]:checked").val();
   $.ajax({
            type: "POST",
            url: "pm-chat-delete.php",
            data: {"id": id},
            success: function(html) {
              //Если все успешно, загружаем сообщения
              load_messes('all');
            }
    });
});
$(document).on('click', '.edit-mess-radio', function() {
var id=$("input:radio[name=edit-mess-button]:checked").val();
var mess=$("input:radio[name=edit-mess-button]:checked").attr('data');
$('#messages__text-box').empty();
$('#messages__text-box').attr('value', mess);

$('.send-message-button').addClass('edit-message-button');
$('.send-message-button').removeClass('send-message-button');
   $.ajax({
            type: "POST",
            url: "pm-chat-edit.php",
            data: {"id": id},
            success: function(html) {
              //Если все успешно, загружаем сообщения
              load_messes('all');
            }
    });
});

function load_notifications()
{
var id=$("input:radio[name=id]:checked").val();
$.ajax({
            type: "POST",
            url:  "pm-chat-list-load.php",
            data: "id="+id,
            // Выводим то что вернул PHP
            success: function(html)
    				{
      //Очищаем форму ввода
      $("#pm").empty();
      //Выводим что вернул нам php
      $("#pm").append(html);
            }
    });
} 

function load_user()
{
var id=$("input:radio[name=id]:checked").val();
$.ajax({
            type: "POST",
            url:  "pm-chat-selected-load.php",
            data: "id="+id,
            // Выводим то что вернул PHP
            success: function(html)
    				{
                //Очищаем форму ввода
                $("#user").empty();
                //Выводим что вернул нам php
                $("#user").append(html);
            }
    });
}

var checkFocus = function() {
    if (( $('#messages__list')[0].scrollHeight - ($('#messages__list').scrollTop() + $('#messages__list').height())) <= (100)) {
        $("#messages__list").scrollTop(90000);
    } else {
        return false;
    }
}

var newid = 0;
var oldid = 0;

function load_messes(howMuch)
{
var id=$("input:radio[name=id]:checked").val();
newid = id;
if (howMuch == 'all') {
  document.cookie = "lastMess=0; max-age=3600; path=/";
}

if (id === undefined) {return false;}
$.ajax({
            type: "POST",
            url:  "pm-chat-load.php",
            data: {"id": id, "howMuch": howMuch},
            // Выводим то что вернул PHP
            success: function(html)
	    {
        if (howMuch == 'all') {
          $("#messages__list").empty();
        }
	      //Выводим что вернул нам php
	      $("#messages__list").append(html);
	      //Прокручиваем блок вниз(если сообщений много или если произошла смена пользователя)
	      checkFocus();

			if (oldid != newid) {
				oldid = newid;
				$("#messages__list").scrollTop(90000);
			} 

	    }

    });
}



// Подгрузка сообщений по клику на пользователя(хз как сделать без дублирования кода)
// На поиск и решение проблемы с этой хуйнёй ушло 4ч, за подробностями в лс
$(document).on('click', '.pm__radio', function() {

document.cookie = "lastMess=0; max-age=3600; path=/";

var id=$("input:radio[name=id]:checked").val();
newid = id;

if (id === undefined) {return false;}
$.ajax({
            type: "POST",
            url:  "pm-chat-load.php",
            data: "id=" + id,
            // Выводим то что вернул PHP
            success: function(html)
	    {

        load_user();
	      //Очищаем форму ввода
	      $("#messages__list").empty();
	      //Выводим что вернул нам php
	      $("#messages__list").append(html);
	      //Прокручиваем блок вниз(если сообщений много или если произошла смена пользователя)
	      checkFocus();
          if (screenWidth <= 767) {
            viewChatDiv();
          }
          $('#messages__list').animate({scrollTop : 90000},800);
      
	    }

    });
  });



//При загрузке страницы подгружаем сообщения
load_notifications();
//Ставим цикл на каждую секунду
setInterval(load_messes,1000);
setInterval(load_notifications,3000);