const URL = 'voice.php';

/*
let div = document.createElement('div');
div.id = 'messages';
let start = document.createElement('button');
start.id = 'start';
start.innerHTML = 'Start';
let stop = document.createElement('button');
stop.id = 'stop';
stop.innerHTML = 'Stop';
document.body.appendChild(div);
document.body.appendChild(start);
document.body.appendChild(stop);
*/

let min = 0; let textMin = "";
let sec = 0; let textSec = "";

navigator.mediaDevices.getUserMedia({ audio: true})
    .then(stream => {
        const mediaRecorder = new MediaRecorder(stream);

        document.querySelector('#start').addEventListener('click', function(){
            mediaRecorder.start();
            min = 0; textMin = "00";
            sec = 0; textSec = "00";
            document.getElementById("voiceRecordTime").textContent = textMin + ":" + textSec;

            document.getElementById("start").style.display = "none"; 
            document.getElementById("stop").style.display = "flex";
            document.getElementById("contentMess").style.display = "none";
            document.getElementById("contentVoice").style.display = "flex";

            setInterval(() =>{
                document.getElementById("voiceRecordTime").textContent = textMin + ":" + textSec;
                
                if(min < 10){
                    textMin = "0" + String(min);
                }else{
                    textMin = String(min);;
                }
                
                if(sec < 10){
                    textSec = "0" + String(sec);
                }else{
                    textSec = String(sec);
                }
            }, 500);
        });

        let audioChunks = [];
        mediaRecorder.addEventListener("dataavailable",function(event) {
            audioChunks.push(event.data);
        });

        document.querySelector('#stop').addEventListener('click', function(){
            mediaRecorder.stop();

            document.getElementById("start").style.display = "flex";
            document.getElementById("stop").style.display = "none";
            document.getElementById("contentMess").style.display = "contents";
            document.getElementById("contentVoice").style.display = "none";
        });

        mediaRecorder.addEventListener("stop", function() {
            const audioBlob = new Blob(audioChunks, {
                type: 'audio/wav'
            });

            let fd = new FormData();
            fd.append('voice', audioBlob);
            sendVoice(fd);
            audioChunks = [];
        });

    });

async function sendVoice(form) {
    let promise = await fetch(URL, {
        method: 'POST',
        body: form});
    if (promise.ok) {
        let response =  await promise.json();
    }
}

setInterval(() =>{
    sec = sec + 1;
    if(sec == 60){
        sec = 0;
        min = min + 1;
    }
}, 1000);