<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }

  setcookie('chatopen', $_GET['user_id'], time() + 3600 * 24, "/");
?>
<?php include_once "header.php"; ?>
<link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="dist/style.css">
<style>
    html, body, .chat-box{
        background-color: transparent;
    }
</style>

<body id="chat" class="dark-mode" style="background: transparent;">
  <div>
    <section class="chat-area">
      <header id="headers" style="
          background-image: linear-gradient(140deg, rgba(255,255,255,1) 40%, rgba(255,255,255,0) 100%), url('https://images.unsplash.com/photo-1558865869-c93f6f8482af?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMDkwOTV8MHwxfHNlYXJjaHw4fHxhbmltZSUyMGFydHxlbnwwfHx8fDE2NzgwOTA3NzU&ixlib=rb-4.0.3&q=80&w=1080'); background-position-y: 35%;background-blend-mode: unset;background-size: 100%;">
        <a onclick="window.history.back()" style="cursor: pointer;" id="backicon"><i class="fas fa-arrow-left" id="fabback"></i></a>

        <div class='msg-profile' style='margin-left: 15px;'>
          <div class='chat-avatar-css'>
            <h3 style="font-size: medium;">AI</h3>
          </div>
        </div>
        <div class='details'>
          <span id="nameUser">CursusBot</span>
          <p>Чат бот на базе ИИ</p>
        </div>

      </header>

      <div class="chat-box" style="padding-top: 90px;">
          <div style="height: 100%; display: flex;">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="100px" height="100px" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
              <path fill="cornflowerblue" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
              </path>
            </svg>
          </div>
      </div>
      
      <form class="formFile" id="formFile">
        <input class="file-input" type="file" id="sendFileDialog" name="file" accept="image/*,image/jpeg, image/gif" hidden>
      </form>

    <section class="progress-area"></section>
    <section class="uploaded-area"></section>
    <div class="infoSend chat-area-footer" style="display: none;" id="infoUploads">
      <p class="textupload" id="textInfos">Отправка изображения...</p>
    </div>
      <form action="#" class="typing-area chat-area-footer" style="position: fixed;align-items: normal;background: rgb(51 52 54);border-top: 0px;" id="textimput">
        <div class="menuvoice" id="contentWaite">
          <div id="preloader">
            <span></span>
            <span></span>
          </div>
          <p class="menuvoiceOne" style="height: 25px;margin-top: 8px;margin-left: 50px;">Ожидаем ответа CursusBot-a...</p>
        </div>

        <div style="display: contents;" id="contentMess">
          <input type="text" class="incoming_id" name="incoming_id" value="0" hidden="">
          <input type="text" name="message" class="input-field" placeholder="Ваше сообщение..." autocomplete="off" id="inputMess" style="border: 1px solid #a1a1a14d; border-radius: 30px;">
          <button class="active btnSend" id="sendButtun" style="border-radius: 50px;"><i class="fab fa-telegram-plane" style="padding-right: 3px; padding-top: 4px;"></i></button>  
        </div>

      </form>
    </section>

  </div>
  
  <script src="javascript/chat.js"></script>
  <script src="upload.js"></script>
  <script>

    function dark_theme(){
      document.getElementById("headers").style.backgroundImage = "linear-gradient(140deg, #27292d 50%, rgba(255,255,255,0) 100%),  url(https://images.unsplash.com/photo-1558865869-c93f6f8482af?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMDkwOTV8MHwxfHNlYXJjaHw4fHxhbmltZSUyMGFydHxlbnwwfHx8fDE2NzgwOTA3NzU&ixlib=rb-4.0.3&q=80&w=1080)";
      document.getElementById("nameUser").style.color = "#e7e7e7"; document.getElementById("fabback").style.color = "aliceblue";
      document.getElementById("textimput").style.background = "rgb(51 52 54)"; document.getElementById("inputMess").style.backgroundColor = "#4a4a4a";
      document.getElementById("inputMess").style.color = "aliceblue";
      document.getElementById("chat").style.display = "";
      document.body.classList.add('dark-mode');
    }

    function light_theme(){
      document.getElementById("headers").style.backgroundImage = "linear-gradient(140deg, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%),  url(https://images.unsplash.com/photo-1558865869-c93f6f8482af?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwyMDkwOTV8MHwxfHNlYXJjaHw4fHxhbmltZSUyMGFydHxlbnwwfHx8fDE2NzgwOTA3NzU&ixlib=rb-4.0.3&q=80&w=1080)";
      document.getElementById("nameUser").style.color = "black"; document.getElementById("inputMess").style.color = "black"; document.getElementById("inputMess").style.backgroundColor = "#e5ecef";
      document.getElementById("textimput").style.background = "rgb(245 245 245)"; document.getElementById("chat").style.display = "";
      document.getElementById("fabback").style.color = "darkcyan";
      document.body.classList.remove('dark-mode');
    }

    let colors = false;
    window.addEventListener('message', function(event) {
        if(colors){
            light_theme();
            colors = false;
        }else{
            dark_theme();
            colors = true;
        }
    });

    setInterval(() =>{
      $.ajax({
          url: 'php/bot.mess.php',
          method: 'get',         
          success: function(data){
            if(data == 1){
              document.getElementById("contentMess").style.display = "none";
              document.getElementById("contentWaite").style.display = "contents";
            }else{
              document.getElementById("contentWaite").style.display = "none";
              document.getElementById("contentMess").style.display = "contents";
            }
          }
      });
    }, 1000);

    <?php
      if($_GET["theme"] != "ligth"){
        echo "dark_theme();";
      }else{
        echo "light_theme();";
      }
    ?>
  </script> 
  <script src="/app/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="voice.js"></script>
  <script>
    $(document).contextmenu(function(e){
        parent.hideContextMenu();
    });
    $(document).click(function(){
        parent.hideContextMenu();
    });
  </script>
<?php
    include 'context.menu.php';
?>
</body>
</html>
