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
    <title>Мои чаты</title>
    <link rel="shortcut icon" href="cursus.png" type="image/png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./dist/flowbite.min.css"/>
    <link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="dist/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display&display=swap" rel="stylesheet">

    <link rel="manifest" href="manifest.json">

    <script>
        // WEB APP - PWA Settings
        if('serviceWorker' in navigator){
            navigator.serviceWorker.register('service-worker.js');
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(function(registration) {
                console.log('Registration successful, scope is:', registration.scope);
            }).catch(function(err) {
                console.log('Service worker registration failed, error:', err);
            });
        } else {
            console.log("Service worker is not supported");
        }
    </script>
</head>
    <body>
    
    <div class="loader-container">
        <div role="status" class="loader">
        <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
        <span class="sr-only">Loading...</span>
        </div>
    </div>  

    <div class="app" id="app">

        <div id="ModalError" class="hidden fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                <div class="modal-content theme_color_back" style="max-width: 35rem;">
                    <div class="modal-header">
                    <h3 class="modal-title mt-2 font_Wix TitleWindowBold">Обратите внимание!</h3>
                    <button class="modal-close" data-modal-hide="modal"></button>
                    </div>
                    <h6 class="text-muted pl-5 pr-5" id="errortext">Очистить историю переписки?</h6>
                    <div class="modal-footer">
                    <button onclick="closeModalError()" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Закрыть</button>
                    </div>
                </div>
            </div> 
        </div>

        <div id="ModalUsers" class="hidden fixed inset-0 flex items-center justify-center z-50">
            <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                <div class="modal-content theme_color_back" style="max-width: 30rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2 TitleWindowBold font_Wix" id="createTitle">Выберите, с кем начать чат</h3>
                    </div>
                    
                    <div class="window_users" id="all_users">

                    </div>

                    <div class="prl-2" id="window_form_group" style="display: none; max-height: 330px;">
                        <div id="form_group">
                            <div class="relative z-0 w-full mb-6 group">                                
                                <div class="flex items-center space-x-4">
                                    <img id="icon_group" class="objectFitCover wh-70 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500" src="https://unesell.com/assets/img/polyans/ribbed-orange.svg" alt="Bordered avatar">
                                    <input onchange="getFiles(this.files)" style="display: none;" type="file" name="uploadfile" class="file_upload" id="file_upload" accept="image/jpeg,image/png">
                                    <div class="font-medium dark:text-white">
                                        <div class="font_Wix">Аватар группы</div>
                                        <button onclick="openImageUploader()" type="button" class="font_Wix px-3 py-2 mt-2 text-xs rounded-full font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Выбрать иконку с устройства</button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="GroupName" id="GroupName" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="GroupName" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Название группы</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="GroupLink" id="GroupLink" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="GroupLink" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ссылка группы</label>
                                <p id="helper-text-explanation" class="mt-1 text-sm text-gray-500 dark:text-gray-400 fs-10">Чтобы присоединиться: cursus.unesell.com/invite/?id=</p>
                            </div>

                            <button onclick="create_group()" class="font_Wix w-full relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-500 to-pink-500 group-hover:from-purple-500 group-hover:to-pink-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-purple-200 dark:focus:ring-purple-800">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0 w-full">Завершить создание группы</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button onclick="window_creace_group()" type="button" class="font_Wix text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="switchBtm">Создать группу</button>
                        <button onclick="closeModal()" type="button" class="font_Wix text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Отменить</button>
                    </div>
                </div>
            </div> 
        </div>

        <div class="header" id="app_header">
            <div class="logo">
                <img src="dist/cursus.svg" alt="">
            </div>

            <p class="name">Cursus</p>

            <div class="wrapper">
                <section class="users new_searchBar">
                    <div class="flex items-center">   
                        <label for="voice-search search" class="sr-only" id="searchIcon">Поиск</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" onchange="document.getElementById('searchBar').value = document.getElementById('searchInput').value;" class="font_Wix bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Поиск людей среди моих чатов..." required="">
                        </div>
                    </div>
                </section>
            </div>

            <div class="user-settings">
                <div class="flex items-center cdefault">
                    <i class="ml-2 fas fa-clock fa-lg" style="font-size: 18px;"></i>
                    <p class="ml-2" id="time">12:00</p>
                    <i class="ml-3 fas fa-battery-full fa-lg" style="font-size: 18px;"></i>
                    <p class="ml-2" id="battery">100%</p>
                </div>
                <div class="dark-light">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                </div>
                <img class="user-profile avatar" src="/data/users/avatar/<?php echo $row['avatar']; ?>" alt="" onclick="document.getElementById('nav-menu').classList.toggle('show-menu');">
            </div>

            <div class="user-menu" id="nav-menu">
                <div class="avablock"></div>
                <div class="dropdown-menu dropdown-menu-right widthNavStyle show" style="background: var(--border-color);padding: 0px;">
                    <div class="dropdown-user-details">
                    <div class="dropdown-user-cover" style="margin: -25px; width: 100%; left: -2px; position: relative;">
                        <img src="<?php echo($row["imgBackground"]);?>" alt="" style="margin-left: 2px;">
                        </div>
                            <div class="dropdown-user-avatar">
                            <img src="/data/users/avatar/<?php echo($row["id"]);?>.png">
                            </div>
                        <div class="dropdown-user-name"><?php echo($row["name"]);?></div>
                    </div>

                    <ul class="dropdown-user-menu" style="margin: 15px;width: 240px;">
                        <li><a href="/account/"> <i class="ni ni-single-02"></i> Мой профиль </a> </li>
                        <li><a href="/account/settings/"> <i class="ni ni-settings-gear-65"></i> Настройки аккаунта </a> </li>
                        <li><a href="/service/out.php"> <i class="ni ni-user-run"></i>Выйти с аккаунта</a></li>
                    </ul>
                </div>
            </div>

            <div>

            </div>
        </div>
        <div class="wrapper">
            <div class="conversation-area">
            
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Категория чатов</label>
                    <select id="tabs" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>Личные</option>
                        <option>Группы</option>
                    </select>
                </div>

                <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 sm:flex dark:divide-gray-700 dark:text-gray-400">
                    <li onclick="my_chat()" class="w-full">
                        <a id="my_chat" class="cpointer inline-block w-full p-4 text-gray-900 bg-gray-100 active dark:bg-gray-700 dark:text-white">Личные</a>
                    </li>
                    <li onclick="group_chat()" class="w-full">
                        <a id="group_chat" class="cpointer inline-block w-full p-4 bg-white hover:text-gray-700 hover:bg-gray-50 active dark:bg-gray-700 dark:text-white dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">Группы</a>
                    </li>
                </ul>

                <div class="users-list" id="list-user">
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

                    <div class='msg' onclick='openChat("0")'>
                    
                        <div class='msg-profile'>
                            <div class="chat-avatar-css">
                                <h3 style="font-size: medium;">AI</h3>
                            </div>
                        </div>

                        <div class='msg-detail'>
                            <div class='msg-username'>CursusBot</div>
                            <div class='msg-content'>
                                <span class='msg-message'>Чат бот на базе ИИ</span>
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
                </div>


                <div class="users-list" id="list-group" style="display: none;">

                    <div id="my-group" style="height: 100%;">
                        <div style="height: 80%; display: flex;">
                            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="100px" height="100px" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                <path fill="cornflowerblue" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                </path>
                            </svg>
                        </div>
                    </div>

                </div>

                <button class="add" id="btmPlus" onclick="new_chat();"></button>
                <div class="overlay"></div>
            </div>

            <div class="chat-area">
                <iframe src="/app/cursus/nochat.php" style="height: 100%; border: 0px;" id="chatFrame" name="iframe">
                    Загрузка приложения не удалась.
                </iframe>
            </div>
        </div>
    </div>
    
    <script src="dist/script.js"></script>
    <script src="jsMessenger/users.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function checkUniqueLink() {
            const groupLink = $('#GroupLink').val();
            $.ajax({
                type: 'POST',
                url: 'php/check_link.php',
                data: { GroupLink: groupLink },
                success: function(response) {
                    if (response === 'unique') {
                        $('#helper-text-explanation').text('Чтобы присоединиться: cursus.unesell.com/invite/?id=' + groupLink);
                    } else {
                        $('#helper-text-explanation').text('Ссылка уже занята. Пожалуйста, выберите другую.');
                    }
                }
            });
        }

        $('#GroupLink').on('input', checkUniqueLink);

        window.addEventListener('load', function() {
            var loaderContainer = document.querySelector('.loader-container');
            loaderContainer.classList.add("fadeOut");
            loaderContainer.addEventListener('animationend', function() {
                loaderContainer.style.display = 'none';
            });
        });
        
        function new_chat() {
            var modal = document.getElementById('ModalUsers');
            modal.classList.add('block');
            modal.classList.remove('hidden');
        }
        function closeModal(){
            var modal = document.getElementById('ModalUsers');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        }

        function openModelError(error) {
            document.getElementById('errortext').textContent = error;

            var modal = document.getElementById('ModalError');
            modal.classList.add('block');
            modal.classList.remove('hidden');
            closeModal();
        }

        function closeModalError(){
            var modal = document.getElementById('ModalError');
            modal.classList.remove('block');
            modal.classList.add('hidden');
            new_chat();
        }

        let usersBlock = "one";
        function window_creace_group(){
            if(usersBlock == "one"){
                document.getElementById("window_form_group").style.display = "block";
                document.getElementById("all_users").style.display = "none";
                document.getElementById("createTitle").textContent = "Создание общей комнаты";
                document.getElementById("switchBtm").textContent = "Начать личный чат";
                usersBlock = "group";
            }else{
                document.getElementById("all_users").style.display = "block";
                document.getElementById("window_form_group").style.display = "none";
                document.getElementById("createTitle").textContent = "Выберите, с кем начать чат";
                document.getElementById("switchBtm").textContent = "Создать группу";
                usersBlock = "one";
            }
        }

        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
            document.getElementById("chatFrame").src = "/app/cursus/friends.mobile.php";
            document.getElementById("serchbar").style.display = "none";
            document.documentElement.requestFullscreen();
        }
        window.addEventListener("unload", function() {
            navigator.sendBeacon("php/logout.php");
        });

        navigator.sendBeacon("php/login.php");

        $(document).contextmenu(function(e){
            window.frames.iframe.hideContextMenu();
        });
        $(document).click(function(){
            window.frames.iframe.hideContextMenu();
        });

        setInterval(function() {
            if (document.body.classList.contains("dark-mode")) {
                window.frames.iframe.dark_theme();
                document.getElementById("app").classList.add("dark");
            } else {
                window.frames.iframe.light_theme();
                document.getElementById("app").classList.remove("dark");
            }
        }, 10);
        
        <?php
            if($_GET['chat'] != ""){
                echo("openChat(".$_GET['chat'].");");
            }
            if($_GET['group'] != ""){
                echo("openGroup('".$_GET['group']."');");
            }
        ?>
    </script>

    <script>
        // Функция для открытия выбора изображения
        function openImageUploader() {
            document.getElementById('file_upload').click();
        }

        // Функция для отображения выбранного изображения
        function getFiles(files) {
            const file = files[0];
            if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('icon_group').src = e.target.result;
            };
            reader.readAsDataURL(file);
            }
        }

        if ('getBattery' in navigator) {
            navigator.getBattery().then(function(battery) {
                var batteryLevel = battery.level;
                console.log('Уровень заряда: ' + (batteryLevel * 100) + '%');
            });
        } else {
            console.log('Battery API не поддерживается в этом браузере.');
        }

    </script>


    <script type="module">
        // Firebase Messaging
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.0.0/firebase-app.js';
        import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging.js';

        const firebaseConfig = {
            apiKey: "AIzaSyCoj9xpaHuES994IWK4s33FMQq5G1vzK7Y",
            authDomain: "unesell.firebaseapp.com",
            projectId: "unesell",
            storageBucket: "unesell.appspot.com",
            messagingSenderId: "786154684558",
            appId: "1:786154684558:web:7f1b8c9ff0b420d13d89df",
            measurementId: "G-R9G9CJ76NX"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        // Запрос разрешения на отправку уведомлений
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Разрешение на отправку уведомлений получено.');
                // Получение токена устройства
                getToken(messaging, { vapidKey: 'BH6iN3V-s_bp1h6GB9kc5TT9cnHSle8LH36Q59AroPLeN1r0ZKB6aYIWi-Z9uyECo7-DKqe-r5bQHJJZT2L4eYg' }).then((currentToken) => {
                if (currentToken) {
                    console.log('Токен устройства:', currentToken);             
                    $.ajax({
                        url: 'php/device_id.php',
                        method: 'POST',
                        data: { currentToken: currentToken },
                        success: function(response) {
                            console.log('Токен успешно отправлен и обновлен в базе данных.');
                        },
                        error: function(xhr, status, error) {
                            console.log('Произошла ошибка при отправке токена: ' + error);
                        }
                    });
                } else {
                    console.log('Не удалось получить токен устройства.');
                }
                }).catch((error) => {
                    console.log('Ошибка при получении токена устройства:', error);
                });

                // Обработка входящих уведомлений
                onMessage(messaging, (payload) => {
                console.log('Получено входящее уведомление:', payload);
                    // Здесь вы можете обработать входящее уведомление
                });
            } else {
                console.log('Разрешение на отправку уведомлений отклонено.');
            }
        }).catch((error) => {
        console.log('Ошибка при запросе разрешения на отправку уведомлений:', error);
        });

    </script>

    <style>.tb_button {padding:1px;cursor:pointer;border-right: 1px solid #8b8b8b;border-left: 1px solid #FFF;border-bottom: 1px solid #fff;}
    .tb_button.hover {border:2px outset #def; background-color: #f8f8f8 !important;}.ws_toolbar {z-index:100000}
    .ws_toolbar .ws_tb_btn {cursor:pointer;border:1px solid #555;padding:3px}   .tb_highlight{background-color:yellow}
    .tb_hide {visibility:hidden} .ws_toolbar img {padding:2px;margin:0px}
    </style>

    <?php
        include 'context.menu.php';
    ?>
    </body>
</html>