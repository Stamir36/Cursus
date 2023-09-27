const searchBar = document.querySelector("#searchInput"),
searchIcon = document.querySelector("#searchIcon"),
mychat = document.querySelector("#my-chats"),
mygroup = document.querySelector("#my-group"),
usersList = document.querySelector("#all_users");


searchIcon.onclick = ()=>{
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=>{
  let searchTerm = searchBar.value;
  if(searchTerm != ""){
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();

  xhr.open("POST", "jsMessenger/search.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          mychat.innerHTML = data;
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
}

// Все пользователи в системе
setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "jsMessenger/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

// Пользователи, с которым ведётся чат.
setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "jsMessenger/my.chat.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            mychat.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);


// Группы, в которых мы участвуем.
setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "jsMessenger/group.chat.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            mygroup.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);