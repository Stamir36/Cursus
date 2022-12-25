<?php
 setcookie('chatopen', "", time() + 3600 * 24, "/");
?>
<link rel="stylesheet" href="dist/style.css">
<style>
    @font-face {
        font-family: Unecoin;
        src: url(../../assets/fonts/font_bolt.ttf);
    }

    html,body{
        height:100%;
        padding:0;
        margin:0;
        font-family: Unecoin;
        background-color: transparent;
        cursor: default;
    }
    *{
        box-sizing:border-box;
    }
    .box{
        font-family: Unecoin;
        text-align-last: center;
        color: #fff;
    }

    .container{
    
        width:100%;
        height:100%;
        background-color: transparent;
        
        display:flex;
        justify-content:center;
        align-items:center;
        
    }
</style>
<link rel="stylesheet" href="/app/assets/vendor/nucleo/css/nucleo.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="dist/style.css">
<body class="dark-mode" style="background: transparent;">
    <div class="container">
    <div class="box">
        <img src="dist/noChatImg.png" alt="">
        <p id="text">Выберите чат, чтобы начать переписку</p>
    </div>
    </div>
</body>

<script src="/app/assets/vendor/jquery/dist/jquery.min.js"></script>

<script>
    let colors = false;
    window.addEventListener('message', function(event) {
        if(colors){
            document.getElementById("text").style.color = "#fff";
            colors = false;
            document.body.classList.add('dark-mode');
        }else{
            document.getElementById("text").style.color = "#000";
            colors = true;
            document.body.classList.remove('dark-mode');
        }
    });

    function dark_theme(){
        document.getElementById("text").style.color = "#fff"; document.body.classList.add('dark-mode');
    }

    function light_theme(){
        document.getElementById("text").style.color = "#000"; document.body.classList.remove('dark-mode');
    }
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