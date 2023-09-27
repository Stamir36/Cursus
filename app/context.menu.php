<!--
  <div class="menu">
    <ul class="menu-list">
      <li class="menu-item"><button class="menu-button" onclick="document.execCommand('copy')">&nbsp;&nbsp;Копировать</button></li>
      <li class="menu-item"><button class="menu-button" onclick="paste()">&nbsp;&nbsp;Вставить</button></li>
      <li class="menu-item"><button class="menu-button" onclick="window.history.back()">&nbsp;&nbsp;Вернуться назад</button></li>
      <li class="menu-item"><button class="menu-button menu-button--delete" onclick="document.location.href = '/../../../../../../../../../../../';">&nbsp;&nbsp;Главная страница</button></li>
    </ul>
  </div>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">


  <style>
    *,
    *:after,
    *:before {
      box-sizing: border-box;
    }
    .menu {
      flex-direction: column;
      background: var(--border-color);
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(64, 64, 64, 0.15);
      width: 250px;
      display: none;
      position: absolute;
      margin: 0;
      padding: 0;
      border-radius: 5px;
      list-style: none;
      overflow: hidden;
      z-index: 999999;
    }

    .menu-list {
      margin: 0;
      display: block;
      width: 100%;
      padding: 8px;
    }
    .menu-list + .menu-list {
      border-top: 1px solid #ddd;
    }

    .menu-sub-list {
      display: none;
      padding: 8px;
      background-color: var(--color-bg-secondary);
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(64, 64, 64, 0.15);
      position: absolute;
      left: 100%;
      right: 0;
      z-index: 100;
      width: 100%;
      top: 0;
      flex-direction: column;
    }
    .menu-sub-list:hover {
      display: flex;
    }

    .menu-item {
      position: relative;
    }

    .menu-button {
      font: inherit;
      border: 0;
      padding: 8px 8px;
      padding-right: 36px;
      width: 100%;
      border-radius: 8px;
      display: flex;
      align-items: center;
      position: relative;
      color: var(--button-color);
      background: var(--border-color);
      cursor: pointer;
    }
    .menu-button:hover {
      background-color: var(--button-bg-color);
    }
    .menu-button:hover + .menu-sub-list {
      display: flex;
    }
    .menu-button:hover svg {
      stroke: var(--color-text-primary);
    }
    .menu-button svg {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      stroke: var(--color-text-primary-offset);
    }
    .menu-button svg:nth-of-type(2) {
      margin-right: 0;
      position: absolute;
      right: 8px;
    }
    .menu-button--delete:hover {
      color: var(--color-red);
    }
    .menu-button--delete:hover svg:first-of-type {
      stroke: var(--color-red);
    }
    .menu-button--orange svg:first-of-type {
      stroke: var(--color-orange);
    }
    .menu-button--green svg:first-of-type {
      stroke: var(--color-green);
    }
    .menu-button--purple svg:first-of-type {
      stroke: var(--color-purple);
    }
    .menu-button--black svg:first-of-type {
      stroke: var(--color-black);
    }
    .menu-button--checked svg:nth-of-type(2) {
      stroke: var(--color-purple);
    }
  </style>

  <script>
    $(document).ready(function(){
    //Show contextmenu:
    $(document).contextmenu(function(e){
      //Get window size:
      var winWidth = $(document).width();
      var winHeight = $(document).height();
      //Get pointer position:
      var posX = e.pageX;
      var posY = e.pageY;
      //Get contextmenu size:
      var menuWidth = $(".menu").width();
      var menuHeight = $(".menu").height();
      //Security margin:
      var secMargin = 10;
      //Prevent page overflow:
      if(posX + menuWidth + secMargin >= winWidth
      && posY + menuHeight + secMargin >= winHeight){
        //Case 1: right-bottom overflow:
        posLeft = posX - menuWidth - secMargin + "px";
        posTop = posY - menuHeight - secMargin + "px";
      }
      else if(posX + menuWidth + secMargin >= winWidth){
        //Case 2: right overflow:
        posLeft = posX - menuWidth - secMargin + "px";
        posTop = posY + secMargin + "px";
      }
      else if(posY + menuHeight + secMargin >= winHeight){
        //Case 3: bottom overflow:
        posLeft = posX + secMargin + "px";
        posTop = posY - menuHeight - secMargin + "px";
      }
      else {
        //Case 4: default values:
        posLeft = posX + secMargin + "px";
        posTop = posY + secMargin + "px";
      };
      //Display contextmenu:
      $(".menu").css({
        "left": posLeft,
        "top": posTop
      }).show();
      //Prevent browser default contextmenu.
      return false;
    });
    //Hide contextmenu:
    $(document).click(function(){
      $(".menu").hide();
      window.frames.iframe.hideContextMenu();
      parent.hideContextMenu();
    });
  });

  let activeElement;

  function hideContextMenu(){
    $(".menu").hide();
  }

  async function paste(){
    const clipboardItems = await navigator.clipboard.readText();
    if(activeElement == "searchBar"){
        document.getElementById("searchBar").value = document.getElementById("searchBar").value + clipboardItems;
    }
    if(activeElement == "inputMess"){
        document.getElementById("inputMess").value = document.getElementById("inputMess").value + clipboardItems;
    }
  }

  setInterval(() =>{
    try{
      activeElement = document.activeElement.attributes.id.nodeValue;
    }catch{
      activeElement = "none";
    }
  }, 500);

  </script>
-->