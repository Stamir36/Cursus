function launchColabNotebook() {
    const clientId = '786154684558-9hmlps6ckjf98c83ge0flg0fo7mn1apm.apps.googleusercontent.com'; // Замените на ваш клиентский идентификатор OAuth
    const redirectUri = 'https://unesell.com/redirect/'; // Замените на URI перенаправления вашего сайта
    const notebookUrl = 'https://colab.research.google.com/drive/1BnPDnLK52OPSOVL3TyE7S-_zqI2Nakx-?usp=sharing'; // Замените на URL вашего блокнота Google Colab
  
    // Открываем окно аутентификации Google OAuth 2.0
    if(getCookie('google_access_token') == ""){
      window.open(
        `https://accounts.google.com/o/oauth2/auth?client_id=${clientId}&redirect_uri=${redirectUri}&response_type=token&scope=https://www.googleapis.com/auth/drive`,
        'colab_auth',
        'width=500,height=600'
      );
    }
  
    // Функция, которая будет вызвана при получении токена доступа
    function handleAuthResponse() {
      const accessToken = getCookie('google_access_token');
      if (accessToken) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://colab.research.google.com/notebooks/api/execute');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
        xhr.send(JSON.stringify({
          notebookUrl: notebookUrl,
          mode: 'jupyter',
          params: {}
        }));
      }
    }
  
    // Функция для получения значения cookie по имени
    function getCookie(name) {
      const value = "; " + document.cookie;
      const parts = value.split("; " + name + "=");
      if (parts.length === 2) {
        return parts.pop().split(";").shift();
      }
    }
  
    // Обработка ответа от окна аутентификации Google OAuth 2.0
    window.addEventListener('message', function(event) {
      if (event.origin === window.location.origin) {
        const { type } = event.data;
        if (type === 'authResponse') {
          handleAuthResponse();
        }
      }
    });
  }
  