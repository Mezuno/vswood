function add_online() {
    $.ajax ({
              type: "POST",
              url:  "../includes/online-add.php",
              data: "req=ok",
            success: function(html){}
    });
  }
  setInterval(add_online,10000);