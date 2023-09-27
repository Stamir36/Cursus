<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
  setcookie('chatopen', $_GET['group_id'], time() + 3600 * 24, "/");
  $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
?>
<?php include_once "header.php"; ?>
<link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="./dist/flowbite.min.css"/>
<link rel="stylesheet" href="dist/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display&display=swap" rel="stylesheet">
<style>
    html, body, .chat-box{
        background-color: transparent;
    }
</style>

<body id="chat" class="dark-mode" style="background: transparent;">
  <div>

  <input type="text" id="textToCopy" style="display: none;" value="https://unesell.com/app/cursus/invite/?id=<? echo($_GET['group_id']); ?>" readonly>

  <div id="alert" style="border: 1px solid;" class="alert-chat flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
      <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg dark:bg-blue-800 dark:text-blue-200">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
          <span class="sr-only">Info icon</span>
      </div>
      <div class="ml-3 text-sm font-normal font_Wix">Пригласительная ссылка была скопированна</div>
  </div>

  <div id="ModalConfirm" class="hidden fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
        <div class="modal" style="display: contents;">
          <div class="modal-content theme_color_back" style="max-width: 35rem;">
            <div class="modal-header">
              <h3 class="modal-title mt-2 font_Wix" style="font-weight: 600; font-size: 16px;">Выйти с групового чата?</h3>
              <button class="modal-close" data-modal-hide="modal"></button>
            </div>
            <h6 class="text-muted pl-5 pr-5 font_Wix">Это удалит полностью все ваши сообщения, файлы и записи отправленные ранее. Уверены?</h6>
            <div class="modal-footer">
              <button onclick="sendData_Clear()" type="button" class="font_Wix text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Да, выйти с группы</button>
              <button onclick="closeModal()" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Отменить</button>
            </div>
          </div>
        </div> 
    </div>


    <div id="ModalGames" class="hidden fixed inset-0 flex items-center justify-center z-50">
      <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
        <div class="modal" style="display: contents;">
          <div class="modal-content theme_color_back" style="max-width: 30rem;">
            <div class="modal-header">
              <h3 class="modal-title mt-2 TitleWindowBold font_Wix" id="createTitle">Начать совместную игру</h3>
              <img src="dist/gamepad.svg" style="margin: 4px;" class="w-8 h-8"></svg>
            </div>

            <div class="prl-2 grid grid-cols-3 gap-4 p-4 lg:grid-cols-4" style="min-height: 150px; max-height: 330px;">

              <div onclick="location.href = 'games/hack/?group_id=<? echo($group_id); ?>';" class="rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:hover:bg-gray-600 dark:bg-gray-700" style="width: 170px;">
                <img src="./games/hack/logo.jpg" alt="game icon" style="border-radius: 0.5rem 0.5rem 0 0;">
                <div class="font-medium text-center text-gray-500 dark:text-gray-400 p-1">Hack</div>
              </div>

            </div>

            <div class="modal-footer">
              <button onclick="closeModalGame()" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Закрыть окно</button>
            </div>
         </div>
       </div> 
    </div>


    <section class="chat-area">
        <?php 
          $sql = mysqli_query($conn, "SELECT * FROM group_list WHERE identify = '{$group_id}'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: users.php");
          }
        ?>
      <header id="headers" style="
          background-image: linear-gradient(140deg, rgba(255,255,255,1) 40%, rgba(255,255,255,0) 100%),  url(<?php
            echo $row['imgBackground']
          ?>);background-position-y: 35%;background-blend-mode: unset;background-size: 100%;">
        <a onclick="window.history.back(); parent.closeChat();" class="back-icon" style="cursor: pointer;"><i class="fas fa-arrow-left" id="fabback"></i></a>

        <?php
          $users_group = $conn->query("SELECT DISTINCT outgoing_msg_id FROM messages WHERE incoming_msg_id = '$group_id'");
          echo("
            <img style='border-radius: 30px; border: 3px solid antiquewhite;' class='objectFitCover' src='./".$row['icon']."'>
            <div class='details' data-popover-target='popover-group' data-popover-placement='bottom'>
              <span id='nameUser'>".$row['name']."</span>
              <p id='status'>Участников: ".$users_group->num_rows."</p>
            </div>
          ");
        ?>

      <div data-popover id="popover-group" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-80 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
            <div class="p-3">
                <div class="flex">
                    <div class="mr-3 shrink-0">
                        <img class="p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 objectFitCover" src="./<? echo($row['icon']); ?>" alt="logo" style="margin: 0px;" >
                    </a>
                    </div>
                    <div>
                        <p class="mb-1 text-base font-semibold leading-none text-gray-900 dark:text-white font_Wix">
                            <a><? echo($row['name']); ?></a>
                        </p>
                        <p class="mb-3 text-sm font-normal font_Wix">
                            @<? echo($row['identify']); ?>
                        </p>
                        <p class="mb-4 text-sm font_Wix"><? echo("Участников: ".$users_group->num_rows); ?></p>
                    </div>
                </div>
            </div>
            <div data-popper-arrow></div>
        </div>

        <button onclick="WindowGameList();" class="inline-flex items-center text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button" style="right: 60px; position: absolute;">
          <img src="dist/gamepad.svg" style="color: var(--button-color); margin: 0px;" class="w-6 h-6"></svg>
        </button>

        <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots" class="inline-flex items-center p-1.5 text-sm font-medium text-center text-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button" style="right: 20px; position: absolute;">
          <svg style="color: var(--button-color);" class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
        </button>

        <!-- Dropdown menu -->
        <div id="dropdownDots" class="theme_color_back z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600" style="right: 20px; position: absolute;">
            <ul class="py-2 text-sm" aria-labelledby="dropdownMenuIconButton">
              <li>
                  <a onclick="showNotification()" style="cursor: pointer;" class="theme_color_back_hover block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Пригласить пользователей</a>
                </li>  
              <li>
                <a onclick="clear_history()" style="cursor: pointer;" class="theme_color_back_hover block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Выйти из группы и очистить</a>
              </li>
            </ul>
        </div>

      </header>

      <div class="flex -space-x-4 avatar-groups">
        <?php
          if ($users_group->num_rows > 0) {
              $count = 0;
              while ($user_avatar = $users_group->fetch_assoc()) {
                  if ($count < 3) {
                      echo('<img class="objectFitCover w-10 h-10 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 avatar-img-group" src="/data/users/avatar/'.$user_avatar['outgoing_msg_id'].'.png" alt="avatar">');
                      $count++;
                  } else {
                      break;
                  }
              }

              if ($users_group->num_rows > 3) {
                  $countsuser = $users_group->num_rows - 3;
                  echo('<a class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800">+'.$countsuser.'</a>');
              }
          } else {
              echo "Нет пользователей";
          }
        ?>
      </div>

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
        <a class="active btnSend" id="start" style="align-items: center; justify-content: center; display: flex; width: 45px; height: 40px; border-radius: 30px; cursor: pointer;"><i class="fa fa-microphone"></i></a>
        <a class="active btnSend" id="stop" style="display: none; background: #ff7e7e; align-items: center; justify-content: center; width: 45px; height: 40px; border-radius: 30px; cursor: pointer;"><i class="fa fa-stop"></i></a>

        <div class="menuvoice" id="contentVoice">
          <p class="menuvoiceOne">Запись сообщения...</p>
          <p class="menuvoiceTwo" id="voiceRecordTime">00:00</p>
        </div>

        <div style="display: contents;" id="contentMess">
          <a class="active btnSend" onclick="sendFiles()" style="align-items: center; justify-content: center; display: flex; width: 45px; height: 40px; border-radius: 30px; cursor: pointer;"><i class="fa fa-paperclip"></i></a>
          <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $group_id; ?>" hidden="">
          <input type="text" name="message" class="input-field input_textBox" placeholder="Ваше сообщение..." autocomplete="off" id="inputMess">
          <button class="active btnSend" id="sendButtun" style="border-radius: 10px;"><i class="fab fa-telegram-plane"></i></button>  
        </div>
      </form>
    </section>

  </div>
  
  <script src="javascript/chat-group.js"></script>
  <script src="upload.js"></script>
  <script>
    function sendData_Clear(){
      $.ajax({
          url: 'php/exit.group.php',
          method: 'POST',
          data: { chat: '<? echo($_GET['group_id']); ?>' },
          success: function(data) {
              closeModal();
              window.history.back();
              parent.closeChat();
          }
      });
    }

    function showNotification() {
        var tempInput = document.createElement('input');
        tempInput.setAttribute('value', "https://unesell.com/app/cursus/invite/?id=<? echo($_GET['group_id']); ?>");
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        const alertElement = document.getElementById('alert');
        alertElement.style.right = '10px';
        alertElement.classList.remove('hidden');
        alertElement.click();
        setTimeout(function() {
            hideNotification();
        }, 3000);
    }

    function hideNotification() {
        const alertElement = document.getElementById('alert');
        alertElement.style.right = '-500px';
    }

    function clear_history() {
      var modal = document.getElementById('ModalConfirm'); modal.classList.add('block'); modal.classList.remove('hidden');
    }

    function closeModal(){
      var modal = document.getElementById('ModalConfirm'); modal.classList.remove('block'); modal.classList.add('hidden');
    }

    function WindowGameList() {
      var modal = document.getElementById('ModalGames'); modal.classList.add('block'); modal.classList.remove('hidden');
    }

    function closeModalGame(){
      var modal = document.getElementById('ModalGames'); modal.classList.remove('block'); modal.classList.add('hidden');
    }

    function sendFiles(){
      document.getElementById("sendFileDialog").click();
    }

    function dark_theme(){
      document.getElementById("headers").style.backgroundImage = "linear-gradient(140deg, #27292d 50%, rgba(255,255,255,0) 100%),  url(<?php echo $row['imgBackground']; ?>";
      document.getElementById("nameUser").style.color = "#e7e7e7"; document.getElementById("fabback").style.color = "aliceblue";
      document.getElementById("textimput").style.background = "rgb(51 52 54)"; document.getElementById("inputMess").style.backgroundColor = "#4a4a4a";
      document.getElementById("inputMess").style.color = "aliceblue";
      document.getElementById("chat").style.display = "";
      document.body.classList.add('dark-mode');
      document.body.classList.add('dark');
    }

    function light_theme(){
      document.getElementById("headers").style.backgroundImage = "linear-gradient(140deg, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%),  url(<?php echo $row['imgBackground']; ?>";
      document.getElementById("nameUser").style.color = ""; document.getElementById("fabback").style.color = ""; document.getElementById("inputMess").style.backgroundColor = "#e5ecef";
      document.getElementById("textimput").style.background = "#dadada"; document.getElementById("inputMess").style.color = "black"; document.getElementById("chat").style.display = "";
      document.body.classList.remove('dark-mode');
      document.body.classList.remove('dark');
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
