const toggleButton = document.querySelector('.dark-light');
const colors = document.querySelectorAll('.color');

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