const formSend = document.getElementById("formFile"),
fileInput = document.querySelector(".file-input"),
progressArea = document.querySelector(".progress-area"),
uploadedArea = document.querySelector(".uploaded-area");

fileInput.onchange = ({target})=>{
  let file = target.files[0]; //getting file [0] this means if user has selected multiple files then get first one only
  if(target.files[0].size <= 2000000){
    if(file){
      let fileName = file.name; //getting file name
      if(fileName.length >= 12){ //if file name length is greater than 12 then split it and add ...
        let splitName = fileName.split('.');
        fileName = splitName[0].substring(0, 13) + "... ." + splitName[1];
      }
      uploadFile(fileName); //calling uploadFile with passing file name as an argument  
    }
  }else{
    document.getElementById("infoUploads").classList.add("fileUploadGo");
    document.getElementById("textInfos").textContent = "Файл слишком большой, уменьшите его до 2 мб.";
    setTimeout(() => document.getElementById("infoUploads").classList.remove("fileUploadGo"), 3000);
  }
}

// file upload function
function uploadFile(name){
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/upload.php");
  let data = new FormData(formSend);
  xhr.send(data);

  document.getElementById("infoUploads").classList.add("fileUploadGo");
  document.getElementById("textInfos").textContent = "Отправка изображения...";
  setTimeout(() => document.getElementById("infoUploads").classList.remove("fileUploadGo"), 3000);
}
