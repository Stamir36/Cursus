const toggleButton = document.querySelector('.dark-light');
const colors = document.querySelectorAll('.color');

function my_chat(){
  document.getElementById('group_chat').classList.remove('text-gray-900', 'bg-gray-100');
  document.getElementById('group_chat').classList.add('bg-white', 'hover:text-gray-700', 'hover:bg-gray-50', 'dark:hover:text-white', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');

  document.getElementById('my_chat').classList.remove('bg-white', 'hover:text-gray-700', 'hover:bg-gray-50', 'dark:hover:text-white', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');
  document.getElementById('my_chat').classList.add('text-gray-900', 'bg-gray-100');

  document.getElementById("list-user").style.display = "contents";
  document.getElementById("list-group").style.display = "none";
}

function group_chat(){
  document.getElementById('my_chat').classList.remove('text-gray-900', 'bg-gray-100');
  document.getElementById('my_chat').classList.add('bg-white', 'hover:text-gray-700', 'hover:bg-gray-50', 'dark:hover:text-white', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');

  document.getElementById('group_chat').classList.remove('bg-white', 'hover:text-gray-700', 'hover:bg-gray-50', 'dark:hover:text-white', 'dark:bg-gray-800', 'dark:hover:bg-gray-700');
  document.getElementById('group_chat').classList.add('text-gray-900', 'bg-gray-100');

  document.getElementById("list-user").style.display = "none";
  document.getElementById("list-group").style.display = "contents";
}


colors.forEach(color => {
  color.addEventListener('click', e => {
    colors.forEach(c => c.classList.remove('selected'));
    const theme = color.getAttribute('data-color');
    document.body.setAttribute('data-theme', theme);
    color.classList.add('selected');
  });
});

toggleButton.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  if(document.body.classList.contains("dark-mode")){
    window.frames.iframe.dark_theme();
  }else{
    window.frames.iframe.light_theme();
  }
});

document.body.classList.toggle('dark-mode');

function openChat(id){
  if(id == "0" || id == 0){
    document.getElementById("chatFrame").src = "/app/cursus/chatBot.php?user_id=0";
  }else{
    document.getElementById("chatFrame").src = "/app/cursus/chat.messanger.php?user_id=" + id;

    document.getElementById("chatFrame").onload = function() {
      if(document.body.classList.contains("dark-mode")){
        window.frames.iframe.dark_theme();
      }else{
        window.frames.iframe.light_theme();
      }
    };
  }
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    parent.document.getElementById("app_header").style.display = "none";
    parent.openChat(id);
  }
  closeModal();
}

function openGroup(id){
  document.getElementById("chatFrame").src = "/app/cursus/group.messanger.php?group_id=" + id;
  document.getElementById("chatFrame").onload = function() {
    if(document.body.classList.contains("dark-mode")){
      window.frames.iframe.dark_theme();
    }else{
      window.frames.iframe.light_theme();
    }
  };
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    parent.document.getElementById("app_header").style.display = "none";
    parent.openChat(id);
  }
  closeModal();
}

function closeChat(){
  document.getElementById("chatFrame").src = "/app/cursus/nochat.php";
  document.getElementById("chatFrame").onload = function() {
    if(document.body.classList.contains("dark-mode")){
      window.frames.iframe.dark_theme();
    }else{
      window.frames.iframe.light_theme();
    }
  };

  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    parent.closeMobile();
    parent.document.getElementById("app_header").style.display = "flex";
  }
}

function closeMobile(){
  document.getElementById("chatFrame").src = "/app/cursus/friends.mobile.php";
}

  // если нет создаем элемент с атрибутом contenteditable
  if (!window.Clipboard) {
    var pasteCatcher = document.createElement("div");
      
    // Firefox вставляет все изображения в элементы с contenteditable
    pasteCatcher.setAttribute("contenteditable", "");
      
    pasteCatcher.style.display = "none";
    document.body.appendChild(pasteCatcher);
  
    // элемент должен быть в фокусе
    pasteCatcher.focus();
    document.addEventListener("click", function() { pasteCatcher.focus(); });
  } 
  // добавляем обработчик событию
  window.addEventListener("paste", pasteHandler);
  
  function pasteHandler(e) {
  // если поддерживается event.clipboardData (Chrome)
        if (e.clipboardData) {
        // получаем все содержимое буфера
        var items = e.clipboardData.items;
        if (items) {
          // находим изображение
          for (var i = 0; i < items.length; i++) {
              if (items[i].type.indexOf("image") !== -1) {
                // представляем изображение в виде файла
                var blob = items[i].getAsFile();
                // создаем временный урл объекта
                var URLObj = window.URL || window.webkitURL;
                var source = URLObj.createObjectURL(blob);                
                // добавляем картинку в DOM
                createImage(source);
              }
          }
        }
    // для Firefox проверяем элемент с атрибутом contenteditable
    } else {      
        setTimeout(checkInput, 1);
    }
  }
  
  function checkInput() {
      var child = pasteCatcher.childNodes[0];   
    pasteCatcher.innerHTML = "";    
    if (child) {
  // если пользователь вставил изображение – создаем изображение
        if (child.tagName === "IMG") {
          createImage(child.src);
        }
    }
  }
  
  function createImage(source) {
    var pastedImage = new Image();
    pastedImage.onload = function() {
        // теперь у нас есть изображение из буфера
    }
    pastedImage.src = source;
  }

  function create_group() {
    const groupName = document.getElementById('GroupName').value;
    const groupLink = document.getElementById('GroupLink').value;
    const fileInput = document.getElementById('file_upload');
    const formData = new FormData();
  
    // Проверка на пустые поля и выбор изображения
    if (groupName.trim() === '') {
      openModelError('Введите название группы.');
      return;
    }
  
    if (groupLink.trim() === '') {
      openModelError('Введите ссылку на группу.');
      return;
    }
  
    if (!fileInput.files[0]) {
      openModelError('Выберите изображение для аватара группы.');
      return;
    }
  
    checkLinkUniqueness(groupLink, function(isUnique) {
      if (isUnique) {
        // Если ссылка уникальна, добавляем данные в FormData
        formData.append('GroupName', groupName);
        formData.append('GroupLink', groupLink);
        formData.append('uploadfile', fileInput.files[0]);
  
        // Отправка запроса на сервер
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'new.group.php', true);
  
        xhr.onload = function() {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
              document.getElementById('GroupName').value = '';
              document.getElementById('GroupLink').value = '';
              fileInput.value = ''; // Очищаем выбранный файл
              closeModal();
              openGroup(groupLink);
            } else {
              openModelError('Произошла ошибка: ' + response.error);
            }
          }
        };
  
        xhr.send(formData);
      } else {
        openModelError('Ссылка уже занята. Пожалуйста, выберите другую.');
      }
    });
  }
  
  // Функция для проверки уникальности ссылки на сервере
  function checkLinkUniqueness(groupLink, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/check_link.php', true);
  
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        const response = xhr.responseText;
        callback(response === 'unique');
      } else {
        openModelError('Ошибка при проверке уникальности ссылки.');
        callback(false);
      }
    };
  
    xhr.send('GroupLink=' + encodeURIComponent(groupLink));
  }

  function updateClockAndBattery() {
    var currentTime = new Date();
    var hours = currentTime.getHours().toString().padStart(2, '0');
    var minutes = currentTime.getMinutes().toString().padStart(2, '0');
    var timeString = hours + ':' + minutes;
    document.getElementById('time').textContent = timeString;
    getBatteryLevel().then(function(level) {
      document.getElementById('battery').textContent = level;
    });
}

  function getBatteryLevel() {
    if ('getBattery' in navigator) {
      return navigator.getBattery().then(function(battery) {
        var level = Math.round(battery.level * 100);
        return level + '%';
      });
    } else {
      return 'Не поддерживается';
    }
  }
  setInterval(updateClockAndBattery, 1000);
