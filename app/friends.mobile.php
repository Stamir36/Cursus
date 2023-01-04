<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
  setcookie('chatopen', "", time() + 3600 * 24, "/");
?>          
<?php 
    $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = {$_SESSION['unique_id']}");
    if(mysqli_num_rows($sql) > 0){
    $row = mysqli_fetch_assoc($sql);
    }
?>

<html lang="ru" data-lt-installed="true">
<head>
    <meta charset="UTF-8">
    <title>Cursus - список чатов.</title>
    <link rel="shortcut icon" href="cursus.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="dist/style.css">

</head>
    <body>

    <div class="app">
    <div class="header" style="display: none;">
    <div class="logo">
        <img src="dist/cursus.svg" alt="">
    </div>

    <p class="name">Cursus</p>

    <div class="wrapper">
        <section class="users">
        <div class="search search-bar">
            <input type="text" placeholder="Введите имя для поиска...">
            <button><i class="fas fa-search"></i></button>
        </div>
        </section>
    </div>

        <div class="user-settings">
            <div class="dark-light">
                <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
            </div>
            <img class="user-profile" src="/data/users/avatar/<?php echo $row['avatar']; ?>" alt="">
        </div>
    </div>
    
    <div class="wrapper">
        <div class="conversation-area" style="width: 100%; display: flex;">

        <div class="users-list">
                <div class='msg' onclick='openChat(<?php echo($row['id']); ?>)'>
                
                    <div class='msg-profile'>
                        <div class="chat-avatar-css">
                            <i class="ni ni-single-02"></i>
                        </div>
                    </div>

                    <div class='msg-detail'>
                        <div class='msg-username'>Заметки</div>
                        <div class='msg-content'>
                            <span class='msg-message'>Моё личное пространство</span>
                        </div>
                    </div>
                </div>

                <div id="my-chats">
                    <div style="height: 80%; display: flex;">
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="100px" height="100px" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <path fill="cornflowerblue" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                            </path>
                        </svg>
                    </div>
                </div>

                <div id="all_users" style="display: none;">

                </div>
            </div>


            <button class="add" id="btmPlus" onclick="usersOpen();"></button>
            <div class="overlay"></div>
        </div>

        <div class="chat-area" style="display: none;">
            <iframe src="/app/cursus/nochat.php" style="height: 100%; border: 0px;" id="chatFrame" name="iframe">
                Загрузка приложения не удалась.
            </iframe>
        </div>
    </div>
    </div>
    <script src="dist/script.js"></script>
    <script src="jsMessenger/users.js"></script>
    <script src="/app/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script>
        let usersBlock = "my";
        function usersOpen(){
            if(usersBlock == "my"){
                document.getElementById("my-chats").style.display = "block";
                document.getElementById("all_users").style.display = "none";
                usersBlock = "all";
                document.getElementById("btmPlus").style.transform = "rotate(0deg)";
            }else{
                document.getElementById("all_users").style.display = "block";
                document.getElementById("my-chats").style.display = "none";
                usersBlock = "my";
                document.getElementById("btmPlus").style.transform = "rotate(-135deg)";
            }
        }
        
        $(document).contextmenu(function(e){
            window.frames.iframe.hideContextMenu();
        });
        $(document).click(function(){
            window.frames.iframe.hideContextMenu();
        });

            
        <?php
            if($_GET['chat'] != ""){
                echo("openChat(".$_GET['chat'].");");
            }
        ?>
    </script>
    <style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}
    .tb_button.hover {border:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000}
    .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow}
    .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}
    </style>
    </body>
</html>