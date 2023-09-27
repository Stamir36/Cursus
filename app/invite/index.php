<?php 
  include_once "../php/config.php";
?>          
<html lang="ru" data-lt-installed="true">
<head>
    <meta charset="UTF-8">
    <title>Приглашение в чат</title>
    <link rel="shortcut icon" href="../cursus.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../dist/flowbite.min.css"/>
    <link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="../dist/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display&display=swap" rel="stylesheet">
</head>
    <body class="dark-mode dark">
    
    <div class="loader-container">
        <div role="status" class="loader">
        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
        </div>
    </div>  

    <div class="blur-container" style="--blur:12vw;">

    <div class="shape" style="--path:polygon(50.9% 37.2%, 43.5% 34.7%, 33.6% 26.1%, 39.2% 10.8%, 26.2% 0.0%, 4.8% 6.4%, 0.0% 30.4%, 20.7% 37.2%, 33.4% 26.3%, 43.2% 34.9%, 45.0% 35.6%, 43.6% 46.4%, 37.8% 59.5%, 21.8% 63.2%, 11.7% 76.1%, 22.9% 91.3%, 47.4% 91.3%, 54.0% 79.0%, 38.0% 59.6%, 43.9% 46.4%, 45.2% 35.5%, 50.9% 37.6%, 56.1% 36.8%, 59.8% 47.6%, 70.3% 61.9%, 87.7% 56.0%, 96.4% 37.4%, 88.6% 15.1%, 63.7% 16.7%, 55.2% 33.6%, 55.9% 36.6%, 50.9% 37.2%);"></div>

    <div class="shape" style="--path:polygon(50.9% 37.2%, 43.5% 34.7%, 33.6% 26.1%, 39.2% 10.8%, 26.2% 0.0%, 4.8% 6.4%, 0.0% 30.4%, 20.7% 37.2%, 33.4% 26.3%, 43.2% 34.9%, 45.0% 35.6%, 43.6% 46.4%, 37.8% 59.5%, 21.8% 63.2%, 11.7% 76.1%, 22.9% 91.3%, 47.4% 91.3%, 54.0% 79.0%, 38.0% 59.6%, 43.9% 46.4%, 45.2% 35.5%, 50.9% 37.6%, 56.1% 36.8%, 59.8% 47.6%, 70.3% 61.9%, 87.7% 56.0%, 96.4% 37.4%, 88.6% 15.1%, 63.7% 16.7%, 55.2% 33.6%, 55.9% 36.6%, 50.9% 37.2%);
        --offset:180deg;
        --speed: 6000ms;
        --background: linear-gradient( cyan, blue, green, purple, cyan);
        "></div>
    </div>

    <div id="app">
        <?php 
          $group_id = mysqli_real_escape_string($conn, $_GET['id']);
          $sql = mysqli_query($conn, "SELECT * FROM group_list WHERE identify = '{$group_id}'");
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
          }else{
            header("location: ../");
          }
          
          $users_group = $conn->query("SELECT DISTINCT outgoing_msg_id FROM messages WHERE incoming_msg_id = '$group_id'");
        ?>
        <div id="Modal"class="fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                <div class="modal-content theme_color_back" style="max-width: 30rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2 TitleWindowBold font_Wix" id="createTitle">Приглашение в группу</h3>
                    </div>

                    <div class="prl-2" id="window_form_group" style="max-height: 330px;">
                        <div id="form_group">
                            <div class="relative z-0 w-full mb-6 group">                                
                                <div class="flex items-center space-x-4">
                                    <img id="icon_group" class="objectFitCover wh-70 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500" src="../<? echo($row['icon']); ?>" alt="Bordered avatar">
                                    <div class="font-medium dark:text-white">
                                        <div><? echo($row['name']); ?></div>
                                        <p id="helper-text-explanation" class="mt-1 text-sm text-gray-500 dark:text-gray-400">Количество участников: <? echo($users_group->num_rows); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <?
                            if(empty(htmlspecialchars($_COOKIE["id"]))){
                                echo('<button onclick="login()" class="w-full relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                                            <span class="font_Wix relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 w-full">Войти в Unesell Account</span>
                                        </button>');
                            }else{
                                $targetValue = htmlspecialchars($_COOKIE["id"]);
                                $found = false;
                                while ($result = $users_group->fetch_assoc()) {
                                    $outgoingMsgId = $result['outgoing_msg_id'];

                                    $outgoingMsgId = intval($outgoingMsgId);
                                    $targetValue = intval($targetValue);

                                    if ($outgoingMsgId == $targetValue) {
                                        $found = true;
                                        break;
                                    }
                                }
                                if ($found) {
                                    echo('<p id="helper-text-explanation" class="mt-1 text-sm text-gray-500 dark:text-gray-400" style="left: 30px; position: absolute;">Вы уже состоите в этой группе</p>');
                                }else{
                                    echo('<button onclick="invite_group()" class="w-full relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                                            <span class="font_Wix relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 w-full">Вступить в группу</span>
                                        </button>');
                                }
                            }
                        ?>
                        
                        <button onclick="window.history.back();" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Отказаться</button>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            var loaderContainer = document.querySelector('.loader-container');
            loaderContainer.classList.add("fadeOut");
            loaderContainer.addEventListener('animationend', function() {
                loaderContainer.style.display = 'none';
            });
        });

        function invite_group(){
            location.href = "invite.php?id=<?php echo($_GET['id']); ?>&inapp=<?php echo($_GET['inapp']); ?>";
        }

        function login(){
            var currentUrl = window.location.href;
            location.href = "/login/?url=" + encodeURIComponent(currentUrl);
        }
    </script>

    <?php
        include 'context.menu.php';
    ?>
    </body>
</html>