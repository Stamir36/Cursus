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

<body id="chat" style="background: transparent;">
  <script> document.getElementById("chat").style.display = "none"; </script>
  <div>
    <section class="chat-area">
        <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
          $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = {$user_id}");
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
        <a href="users.php" class="back-icon" style="cursor: pointer;"><i class="fas fa-arrow-left" id="fabback"></i></a>

        <?php
          if($_GET['user_id'] == $_COOKIE['id']){
            echo("
              <div class='msg-profile' style='margin-left: 15px;'>
                  <div class='chat-avatar-css'>
                      <i class='ni ni-single-02'></i>
                  </div>
              </div>
              <div class='details'>
                <span>Заметки</span>
                <p>Моё личное пространство</p>
              </div>
              <div style='display: none;'>
                <span id='nameUser'>".$row['name']."</span>
                <p id='status'>".$row['status']."</p>
              </div>
            ");
          }else{
            echo("
              <img style='border-radius: 30px; border: 3px solid antiquewhite;' src='/data/users/avatar/".$row['avatar']."'>
              <div class='details'>
                <span id='nameUser'>".$row['name']."</span>
                <p id='status'>".$row['status']."</p>
              </div>
            ");
          }
        ?>

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
        <a class="active btnSend" onclick="sendFiles()" style="align-items: center; justify-content: center; display: flex; width: 45px; height: 40px; border-radius: 30px; cursor: pointer;"><i class="fa fa-paperclip"></i></a>
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden="">
        <input type="text" name="message" class="input-field" placeholder="Ваше сообщение..." autocomplete="off" id="inputMess" style="border: 1px solid #a1a1a14d; border-radius: 30px;">
        <button class="active btnSend" id="sendButtun" style="border-radius: 50px;"><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>

  </div>
  
  <script src="javascript/chat.js"></script>
  <script src="upload.js"></script>
  <script>
    
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
    }

    function light_theme(){
      document.getElementById("headers").style.backgroundImage = "linear-gradient(140deg, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%),  url(<?php echo $row['imgBackground']; ?>";
      document.getElementById("nameUser").style.color = ""; document.getElementById("fabback").style.color = ""; document.getElementById("inputMess").style.backgroundColor = "#e5ecef";
      document.getElementById("textimput").style.background = ""; document.getElementById("inputMess").style.color = "black"; document.getElementById("chat").style.display = "";
      document.body.classList.remove('dark-mode');
    }

    light_theme();

  </script> 
  <script src="/app/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script>                
    setInterval(() =>{
      $.ajax({
        url: 'php/status.c.php',
        success: function(data) {
          document.getElementById("status").textContent = data.status;
        }
      });
    }, 500);

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
