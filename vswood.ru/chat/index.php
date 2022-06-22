<?php 

session_start();
if (!isset($_COOKIE['key'])) {
	header('Location: ../');
}

$title = 'Чат';
$page = 'chat';

require_once $_SERVER['DOCUMENT_ROOT'].'/includes/links.php';
require_once $headerlink;

 ?>

<div class="window__row">

  <!-- Онлайн -->
  <section class="online" id="online">
    <div class="online__title flex-row flex-alit-center">Онлайн чатика:</div>
    <div class="online__list" id="online__list"></div>
  </section>

  <!-- Чат -->
  <section class="chat" id="chat">
    <div class="messages__list" id="messages__list">
    </div>
           
    <form action="javascript:send();">             
    <input class="send-message-text" name="message" id="messages__text-box" type="text" placeholder="Сообщение" autocomplete="off" autofocus>
    <input class="send-message-button" type="submit" value=">">
    </form>
  </section>

  <!-- Команаты -->
  <section class="rooms" id="rooms">
    Здесь будут комнаты
  </section>

<!-- Меню комнат онлайна и чата -->
<div class="chat-menu">
  <button style="font-size: 1.5em;" class="button" type="button" id="onlineButton" onmousedown="viewOnlineDiv()"><i class="fas fa-user-clock"></i></button>
  <button style="font-size: 1.5em;" class="button" type="button" id="chatButton" onmousedown="viewChatDiv()"><i class="far fa-comment"></i></button>
  <button style="font-size: 1.5em;" class="button" type="button" id="roomsButton" onmousedown="viewRoomsDiv()"><i class="fas fa-table"></i></button>
</div>

</div>



</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<script src="../js/chat-buttons.js"></script>
<script src="../js/chat.js"></script>