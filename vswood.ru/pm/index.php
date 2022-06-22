<?php 

session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}

$title = 'Личные сообщения';
$page = 'pm-chat';

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;
?>

<div class="window__row">

<!-- Онлайн -->
  <section class="online" id="online">
    <div class="pm-list-top">
      <form action="#" class="pm-search flex-row flex-alit-center">
      <input placeholder="Поиск" type="text" class="pm-search__text-box">  
      <button class="gray-text pm-search__button"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <form method="post" class="pm" id="pm" action="javascript:load_notifications();">
  	</form>
  </section>

  <!-- Чат -->
  <section class="chat" id="chat">
    <div id="user"></div>

    <div class="messages__list" id="messages__list">
    </div>
           
    <form id="mess-input" action="javascript:send();">             
    <input class="send-message-text" name="message" id="messages__text-box" type="text" placeholder="Сообщение" autocomplete="off" autofocus>
    <!-- <input class="send-message-button" type="submit" value=">"> -->
    <button class="send-message-button" type="submit"><i class="fas fa-arrow-right"></i></button>
    </form>
  </section>

  <!-- Команаты -->
  <section class="rooms" id="rooms">
    Здесь будет<br>информация<br>о переписке
  </section>

<!-- Меню комнат онлайна и чата -->
<div class="chat-menu">
  <button style="font-size: 1.5em;" class="button" type="button" id="onlineButton" onmousedown="viewOnlineDiv()"><i class="fas fa-user-clock"></i></button>
  <button style="font-size: 1.5em;" class="button" type="button" id="chatButton" onmousedown="viewChatDiv()"><i class="far fa-comment"></i></button>
  <button style="font-size: 1.5em;" class="button" type="button" id="roomsButton" onmousedown="viewRoomsDiv()"><i class="fas fa-table"></i></button>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<script src="../js/chat-buttons.js"></script>
<?php
echo '<script src="../js/pm.js?v='.time().'"></script>';
echo '<script src="../js/online.js?v='.time().'"></script>';
?>