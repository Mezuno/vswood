
const onlineWindow = document.getElementById("online");
const chatWindow = document.getElementById("chat");
const roomsWindow = document.getElementById("rooms");
const onlineButton = document.getElementById("onlineButton");
const chatButton = document.getElementById("chatButton");
const roomsButton = document.getElementById("roomsButton");

// Функции для нижних кнопок
function viewOnlineDiv(){
  onlineWindow.style.display = "flex";
  onlineButton.style.border = "1px solid #fff";
  chatWindow.style.display = "none";
  chatButton.style.border = "1px solid rgba(0,0,0,0)";
  roomsWindow.style.display = "none";
  roomsButton.style.border = "1px solid rgba(0,0,0,0)";
};
function viewChatDiv(){
  onlineWindow.style.display = "none";
  onlineButton.style.border = "1px solid rgba(0,0,0,0)";
  chatWindow.style.display = "flex";
  chatButton.style.border = "1px solid #fff";
  roomsWindow.style.display = "none";
  roomsButton.style.border = "1px solid rgba(0,0,0,0)";
  $("#messages__list").scrollTop(90000);
};
function viewRoomsDiv(){
  onlineWindow.style.display = "none";
  onlineButton.style.border = "1px solid rgba(0,0,0,0)";
  chatWindow.style.display = "none";
  chatButton.style.border = "1px solid rgba(0,0,0,0)";
  roomsWindow.style.display = "flex";
  roomsButton.style.border = "1px solid #fff";
};