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
<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display&display=swap" rel="stylesheet">

<link rel="shortcut icon" href="ai.avatar.png" type="image/png" />


<link rel="stylesheet" href="dist/style.css">
<style>
    html, body, .chat-box{
        background-color: transparent;
    }
    .theme_color_back{
      background: var(--border-color);
    }
    .theme_color_back_hover:hover{
      background: var(--chat-text-bg);
    }
    .text_color{
      color: var(--chat-text-color);
    }
    @media (max-width: 780px){
      .infoSend {
          position: absolute !important;
          bottom: 75px !important;
          font-family: Unecoin !important;
          height: auto !important;
      }
    }
</style>

<body id="chat" class="dark-mode" style="background: transparent;"> <!-- transparent -->
  <div>
    <div id="ModalConfirm" class="hidden fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
        <div class="modal" style="display: contents;">
          <div class="modal-content theme_color_back" style="max-width: 35rem;">
            <div class="modal-header">
              <h3 class="modal-title mt-2 font_Wix">Удаление истории</h3>
              <button class="modal-close" data-modal-hide="modal"></button>
            </div>
            <h6 class="text-muted pl-5 pr-5 font_Wix">Очистить историю переписки?</h6>
            <div class="modal-footer">
              <button onclick="sendData_Clear()" type="button" class="font_Wix text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Да, очистить</button>
              <button onclick="closeModal()" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Отменить</button>
            </div>
          </div>
        </div> 
    </div>
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

        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button" style="right: 20px; position: absolute;">
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
        </button>

        <!-- Dropdown menu -->
        <div id="dropdownDots" class="theme_color_back z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600" style="right: 20px; position: absolute;">
            <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton">
              <li>
                <a onclick="clear_history()" style="cursor: pointer;" class="theme_color_back_hover block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Очистить историю</a>
              </li>
            </ul>
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
      <p class="textupload" id="textInfos">Команды для бота:</p>
      <div style="display: -webkit-box;">
          <span class="command_help bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300" onclick="document.getElementById('inputMess').value = '/help';">/help</span> <p class="font_Wix" style="font-size: 14px; display: contents;"> - Список актуальных команд </p>
      </div>
      <div style="display: -webkit-box;">
          <span class="command_help bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300" onclick="document.getElementById('inputMess').value = '/imageline ';">/imageline {prompt}</span> <p class="font_Wix" style="font-size: 14px; display: contents;"> - Генерация изображения </p>
      </div>
      <div style="display: -webkit-box;">
          <span class="command_help bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300" onclick="document.getElementById('inputMess').value = '/translate [ru|en] to [ru|en] ';">/translate [ru|en] to [ru|en] {ваш текст}</span> <p class="font_Wix" style="font-size: 14px; display: contents;"> - Перевод текста </p>
      </div>
    </div>

      <form action="#" class="typing-area chat-area-footer" style="position: fixed;align-items: normal;background: rgb(51 52 54);border-top: 0px;" id="textimput">
        <div class="menuvoice" id="contentWaite">
          <div id="preloader">
            <span></span>
            <span></span>
          </div>
          <p class="menuvoiceOne" style="height: 25px;margin-top: 5px;margin-left: 50px;">Ожидаем ответа CursusBot-a...</p>
        </div>

        <div style="display: contents;" id="contentMess">
          <input type="text" class="incoming_id" name="incoming_id" value="0" hidden="">
          <input type="text" name="message" oninput="command_check()" class="input-field" placeholder="Введите команду &quot;/&quot; или сообщение..." autocomplete="off" id="inputMess" style="border: 1px solid #a1a1a14d; border-radius: 30px; margin-left: auto; font-family: 'Wix Madefor Display', sans-serif;">
          <button class="active btnSend" id="sendButtun" style="border-radius: 50px;"><i class="fab fa-telegram-plane" style="padding-right: 3px; padding-top: 4px;"></i></button>  
        </div>

      </form>
    </section>

  </div>
  
  <script src="javascript/chat.js"></script>
  <script src="colab.js"></script>
  <script src="upload.js"></script>
  <script>

    function sendData_Clear(){
      $.ajax({
          url: 'php/clear.history.bot.php',
          method: 'get',         
          success: function(data){
            closeModal();
          }
      });
    }

    function clear_history() {
      var modal = document.getElementById('ModalConfirm');
      modal.classList.add('block');
      modal.classList.remove('hidden');
    }

    function closeModal(){
      var modal = document.getElementById('ModalConfirm');
      modal.classList.remove('block');
      modal.classList.add('hidden');
    }

    function command_check(){
      input = document.getElementById('inputMess').value;

      if(input.charAt(0) === "/"){
        document.getElementById("infoUploads").classList.add("showMessageMenu");
      }else{
        document.getElementById("infoUploads").classList.remove("showMessageMenu");
      }
    }

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
              document.getElementById("infoUploads").classList.remove("showMessageMenu");
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
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
