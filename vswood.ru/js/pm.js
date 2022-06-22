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

var newMessCheckInterval = setInterval(add_new_messes,1000);

function send()
{
//Считываем сообщение из поля ввода с id mess_to_add
var mess=$("#messages__text-box").val();
var id=$("input:radio[name=id]:checked").val();

clearInterval(newMessCheckInterval);

// Отсылаем паметры
   $.ajax({
            type: "POST",
            url: "pm-chat-add.php",
            data: {"id": id, "mess": mess},
            // Выводим то что вернул PHP
            success: function(html)
            {
              add_new_messes(true);
              newMessCheckInterval = setInterval(add_new_messes,1000);
              load_notifications();
              //Очищаем форму ввода сообщения
              $("#messages__text-box").val('');
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
// Функция получения $_GET параметров
function $_GET(key) {
  var p = window.location.search;
  p = p.match(new RegExp(key + '=([^&=]+)'));
  return p ? p[1] : false;
}
if ($_GET('id')) {
  load_user();
  load_messes(true);
  $("#messages__list").scrollTop(90000);
}

var newid = 0;
var oldid = 0;

function load_messes(scroll)
{
var id=$("input:radio[name=id]:checked").val();
if (id == undefined && $_GET('id') != undefined) id = $_GET('id');
newid = id;
$("#messages__list").empty();
document.cookie = "lastMess=0; max-age=3600; path=/";

if (id === undefined) {return false;}
$.ajax({
            type: "GET",
            url:  "pm-chat-load.php",
            data: {"id": id},
            // Выводим то что вернул PHP
            success: function(html)
	    {
        $("#messages__list").empty();
        //Выводим что вернул нам php
        $("#messages__list").append(html);
	      //Прокручиваем блок вниз(если сообщений много или если произошла смена пользователя)
	      checkFocus();

			if (oldid != newid) {
				oldid = newid;
				$("#messages__list").scrollTop(90000);
			} 
      if (scroll) {
				$("#messages__list").scrollTop(90000);
      }
        
	    }

    });
}


function add_new_messes(scroll)
{
var id=$("input:radio[name=id]:checked").val();

if (id === undefined) {return false;}
$.ajax({
            type: "GET",
            url:  "pm-chat-load-new.php",
            data: "id="+id,
            // Выводим то что вернул PHP
            success: function(html)
	    {
        if (scroll) {
          $("#messages__list").scrollTop(90000);
        }
        //Выводим что вернул нам php
        $("#messages__list").append(html);
	      //Прокручиваем блок вниз(если сообщений много или если произошла смена пользователя)
	      checkFocus();

	    }

    });
}

$(document).on('click', '#delete-all-chat-button', function(){
  var id=$('#delete-all-chat-button').val();
  $.ajax({
          type: "POST",
          url: "pm-chat-delete-all.php",
          data: "id="+id,
          success: function(html) {
            $("#messages__list").empty();
            load_messes('all', false);
          }
  });
});


// Подгрузка сообщений по клику на пользователя(хз как сделать без дублирования кода)
// На поиск и решение проблемы с этой хуйнёй ушло 4ч, за подробностями в лс
$(document).on('click', '.pm__radio', function() {
clearInterval(newMessCheckInterval);
$("#messages__list").empty();
document.cookie = "lastMess=0; max-age=3600; path=/";

var id=$("input:radio[name=id]:checked").val();
history.pushState("", "", "?id="+id);

newid = id;

if (id === undefined) {return false;}
$.ajax({
            type: "GET",
            url:  "pm-chat-load.php",
            data: {"id": id},
            // Выводим то что вернул PHP
            success: function(html)
	    {
        if (html == '<div class="no-user">Здесь пока нет сообщений</div>') {
          $("#messages__list").empty();
          $("#messages__list").append(html);
        }
        load_user();
	      //Выводим что вернул нам php
	      $("#messages__list").append(html);
	      //Прокручиваем блок вниз(если сообщений много или если произошла смена пользователя)
	      checkFocus();
          if (screenWidth <= 767) {
            viewChatDiv();
          }
          $('#messages__list').scrollTop(90000);
          newMessCheckInterval = setInterval(add_new_messes,1000);
	    }

    });
  });



  $(document).on('click', '.delete-mess-radio', function() {
    clearInterval(newMessCheckInterval);
    var id=$("input:radio[name=delete-mess-button]:checked").val();
       $.ajax({
                type: "POST",
                url: "pm-chat-delete.php",
                data: {"id": id},
                success: function(html) {
                  //Если все успешно, загружаем сообщения
                  load_messes(false);
                  newMessCheckInterval = setInterval(add_new_messes,1000);
                }
        });
    });
    
    
    // Edit messages
    $(document).on('click', '.edit-mess-radio', function() {
    var id=$("input:radio[name=edit-mess-button]:checked").val();
    var mess=$("input:radio[name=edit-mess-button]:checked").attr('data');
    $('#messages__text-box').val('');
    $('#messages__text-box').val(mess);
    $('#messages__text-box').focus();
    
    $('#mess-input').attr('action', 'javascript:edit();');
    $('.send-message-button').empty();
    $('.send-message-button').append('<i class="fas fa-pen"></i>');
    });
    
    function edit() {
      clearInterval(newMessCheckInterval);
      var id=$("input:radio[name=edit-mess-button]:checked").val();
      console.log(id);
      var mess=$("#messages__text-box").val();
      console.log(mess);
      $.ajax({
                  type: "POST",
                  url:  "pm-chat-edit.php",
                  data: {"id": id, "mess": mess},
                  // Выводим то что вернул PHP
                  success: function(html) {
                    $("#messages__text-box").val('');
                    $("#messages__text-box").attr('value', '');
                    $('#mess-input').attr('action', 'javascript:send();');
                    $('.send-message-button').empty();
                    $('.send-message-button').append('<i class="fas fa-arrow-right"></i>');
                    load_messes(false);
                    newMessCheckInterval = setInterval(add_new_messes,1000);
                  }
          });
    }
    
    
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
    if (id == undefined && $_GET('id') != undefined) id = $_GET('id');
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

//При загрузке страницы подгружаем сообщения
load_notifications();
//Ставим цикл на каждую секунду
var loadChatList = setInterval(load_notifications,3000);

$(document).on('keyup', '.pm-search__text-box', function(e) {
  var key = e.key ;
  if (key === 'Backspace' || key === 'Delete') {
    load_notifications();
  }
  clearInterval(loadChatList);
  var searchUser = $('.pm-search__text-box').val();
  var pmItems = document.querySelectorAll('.pm__item');
  var pmRadios = document.querySelectorAll('.pm__radio');
  
  
  $('#pm__list').empty();
  pmRadios.forEach(element => {
    if (element.outerHTML.indexOf(searchUser) !== -1) {
      document.querySelector('#pm__list').appendChild(element);
    }
  });
  pmItems.forEach(element => {
    if (element.outerHTML.indexOf(searchUser) !== -1) {
      document.querySelector('#pm__list').appendChild(element);
    }
  });
  
});

$(document).on('click', '.pm-search__button', function() {
  clearInterval(loadChatList);
  var searchUser = $('.pm-search__text-box').val();
  var pmItems = document.querySelectorAll('.pm__item');
  var pmRadios = document.querySelectorAll('.pm__radio');

  $('#pm__list').empty();
  pmRadios.forEach(element => {
    if (element.outerHTML.indexOf(searchUser) !== -1) {
      document.querySelector('#pm__list').appendChild(element);
    }
  });
  pmItems.forEach(element => {
    if (element.outerHTML.indexOf(searchUser) !== -1) {
      document.querySelector('#pm__list').appendChild(element);
    }
  });

});