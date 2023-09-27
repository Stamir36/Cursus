<?php 
  session_start();
  include_once "../../php/config.php";
  setcookie('chatopen', $_GET['group_id'], time() + 3600 * 24, "/");

  $group_id = mysqli_real_escape_string($conn, $_GET['group_id']);
  $sql = mysqli_query($conn, "SELECT * FROM group_list WHERE identify = '{$group_id}'");
  if(mysqli_num_rows($sql) > 0){
    $row = mysqli_fetch_assoc($sql);
  }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Hack. Игры на Cursus</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css'><link rel="stylesheet" href="./style.css">
  <link href="https://fonts.googleapis.com/css2?family=Wix+Madefor+Display&display=swap" rel="stylesheet">
  <style>
    .text-xl {
      font-size: 1rem !important;
    }
    .text-sm {
      font-size: 12px !important;
    }
  </style>
</head>
<body style="font-family: 'Wix Madefor Display', sans-serif;">

<div class='_audio'></div>

<div class='game px-12'>
  <div :class="{'active': !game.mainMenu &amp;&amp; game.tutorial == true}" class='tutorial fixed bg-red-100 inset-0 z-30 flex items-center justify-center'>
    <div :class="{'active': game.tutorialProgress == 0 &amp;&amp; !game.mainMenu &amp;&amp; game.tutorial == true}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--one.gif")'></div>
      <div class='content'>
        <h2>Добро пожаловать в Hack</h2>
         <p class='mb-4'>В Hack ваша цель проста. Проходите колоду каждого этапа, пока не дойдете до конца. Сделайте это, используя программное обеспечение в своей технической колоде, взламывая узлы данных и приобретая новые обновления.</p>
         <p class='text-green'>Давайте рассмотрим некоторые основы</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 1}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--two.gif")'></div>
      <div class='content'>
        <h2>Техническая колода</h2>
        <p class='mb-4'>В нижней части экрана вы найдете свою техническую колоду. Это ваши игровые карты, которые помогут вам пройти каждый этап. Одновременно у вас может быть только определенное количество технологий, поэтому тщательно выбирайте, что взять и оставить.</p>        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 2}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--three.gif")'></div>
      <div class='content'>
      <h2>Форматирование</h2>
         <p class='mb-4'>Справа от вашей технической колоды находится слот формата. Если вы поместите карту из вашей технической колоды в этот слот, она выйдет из игры и освободит место в вашей руке. После форматирования карты ее больше нельзя будет получить.</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 3}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--four.gif")'></div>
      <div class='content'>
        <h2>Хакер</h2>
        <p class='mb-4'>Вы берете на себя роль хакера. Ваша хакерская карта находится в левом верхнем углу пользовательского интерфейса. Карта содержит ваши текущие данные и текущие баллы целостности.</p>
        <p class='text-green'>Если ваши очки целостности упадут до нуля, вас обнаружат, и игра окончена.</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 4}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--five.gif")'></div>
      <div class='content'>
        <h2>Брандмауэр</h2>
        <p class='mb-4'>Справа от вашего хакера находится брандмауэр. Цель брандмауэров — блокировать входящий урон от наступательных программ на сцене. Чтобы загрузить модуль, просто перетащите его из технической колоды в слот модуля. На карте отображается общая сумма, которую может заблокировать модуль межсетевого экрана.</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 5}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--six.gif")'></div>
      <div class='content'>
      <h2>Палуба сцены</h2>
        <p class='mb-4'>Это колода основного этапа. Чтобы перейти к этапу далее, необходимо пройти все карты. Хакер может взаимодействовать с различными картами, перетаскивая на них технику или просто щелкая по ним мышью.</p> <p class="text-align=justify">Карты основного этапа - это колода, которая позволяет пройти этап далее.
        <p class='text-green'>Давайте рассмотрим некоторые типы карт</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 6}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--eight.gif")'></div>
      <div class='content'>
        <h2>Наступательные карты</h2>
        <p class='mb-4'>Эти карты атакуют вас и уменьшают ваши очки целостности. Между модулем брандмауэра и противником можно увидеть его намерения. Чтобы продвинуться вперед, необходимо уничтожить карту нападения. Для этого перетащите наступательные карты на противника из своей технологической колоды. Количество наносимого урона будет зависеть от числа проникновения используемой карты.</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 7}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--nine.gif")'></div>
      <div class='content'>
        <h2>Данные</h2>
        <p class='mb-4'>Карточки данных можно щелкнуть, чтобы добавить их в свое хранилище данных. Затем эти данные могут быть использованы в "темной паутине" для приобретения дополнительного программного обеспечения, аппаратных средств или обновлений.</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 8}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--ten.gif")'></div>
      <div class='content'>
        <h2>Добытчик данных и узлы данных</h2>
        <p class='mb-4'>На колоде сцены вы найдете узлы данных, содержащие определенное количество информации. Используйте на них добытчик данных, чтобы собрать данные, или просто щелкните на них, чтобы пропустить и перейти на карту далее</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 9}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--eleven.gif")'></div>
      <div class='content'>
        <h2>Исцеление</h2>
        <p class='mb-4'>Вы можете восстановить свою целостность несколькими способами. Вы можете разыграть карты восстановления из своей колоды технологий или используя любую из карт перечисления игр</p>
        <div @click="enJin.audioController.play('take'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='Пропустить text-white absolute right-2 top-2 underline cursor-pointer'>
          Пропустить
        </div>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress++" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Продолжить</button>
      </div>
    </div>
    <div :class="{'active': game.tutorialProgress == 10}" class='tutorial_screen absolute'>
      <div class='gif bg-cover bg-center' style='background-image: url("https://assets.codepen.io/217233/hack--tutorial--one.gif")'></div>
      <div class='content'>
        <h2>Начало взлома</h2>
        <p class='mb-4'>Это основы. По мере того как вы начнете играть, вы будете изучать стратегии, позволяющие выбрать лучшие улучшения для текущей ситуации. Если вам снова понадобится помощь, нажмите на значок помощи в правом верхнем углу. Удачи и приятного времяпрепровождения.</p>
        <button @click="enJin.audioController.play('openShop'), game.tutorialProgress = 0, game.tutorial = false, game.tutorialDone()" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Play</button>
      </div>
    </div>
  </div>
  <div class='footer absolute bottom-4 text-description left-48 text-center'>
    Группа: «<a class="text-md text-green"><? echo($row['name']); ?></a>»
  </div>
  <div :class="{'active': achievementEarned}" class='game_achievement z-30 text-white absolute bottom-0 right-0 p-2 flex items-center gap-5'>
    <img class='h-8 w-8 mb-3' src='https://assets.codepen.io/217233/hack--achComplete.svg'>
    <div>
      <h3>Достижение разблокировано</h3>
      <div class='game_achievement__name'>
        {{completedAchievement.name}}
      </div>
      <div class='game_achievement__description'>
        {{completedAchievement.description}}
      </div>
    </div>
  </div>
  <div :class="{'active': game.mainMenu}" class='game_intro h-screen flex items-center z-30 absolute top-0 left-0 w-full'>
    <div :class="{'active': game.gameCreation}" class='hack--pattern absolute top-0 right-0 h-full'>
      <img src='https://assets.codepen.io/217233/hack--pattern_2.png'>
    </div>
    <div :class="{'active': !game.mainMenu}" class='m-auto introWrapper flex items-center realtive z-10'>
      <span :class="{'active': !game.init}" @click="game.init = true, enJin.audioController.play('take'), enJin.audioController.play('intro');" class='gamePreload text-center absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full cursor-pointer'>
        <img class='h-12 mb-3' src='https://assets.codepen.io/217233/hack--headphones.svg'>
        <span class='text-2xl text-white'>Эта игра содержит звук</span>
        <span class='text-md text-green'>Нажмите в любом месте, чтобы начать</span>
      </span>
      <div :class="{'active': game.init}" class='gameInit'>
        <div class='game_intro__menu text-center flex flex-col'>
          <div class='flash absolute bg-white w-full h-full left-0 top-0'></div>
          <div class='logo mb-2 flex justify-center'>
            <img class='h-12 mb-1 -mr-1' src='https://assets.codepen.io/217233/hackerLogoPart1.svg'>
            <img class='h-12 mb-1' src='https://assets.codepen.io/217233/hackerLogoPart1.svg'>
            <img class='h-12 mb-1 ml-2' src='https://assets.codepen.io/217233/hackerLogoPart2.svg'>
          </div>
          <span class='author text-description'>Группа: «<a class="text-md text-green"><? echo($row['name']); ?></a>»</span>
          <div class='menu text-white text-xl space-y-1 mt-12'>
            <h3 :class="{'active': game.gameCreation}" @click="game.gameCreation = true, game.gameAchievements = false, enJin.audioController.play('take')" @mouseenter="enJin.audioController.play('cardHover')">Новая игра</h3>
            <h3 :class="{'active': game.gameAchievements}" @click="enJin.audioController.setFrequency(game.lowerFrequency), game.gameAchievements = true, game.gameCreation = false, enJin.audioController.play('take')" @mouseenter="enJin.audioController.play('cardHover')">Достижения</h3>
            <a @mouseenter="enJin.audioController.play('cardHover')" onclick="window.history.back();">Выйти из игры</a>
          </div>
        </div>
      </div>
      <div :class="{'active': game.gameCreation}" class='game_intro__newgame text-white text-2xl'>
        <div class='inner'>
          <h4 @click="game.gameAchievements = false, game.gameCreation = false, enJin.audioController.play('trash')" @mouseenter="enJin.audioController.play('cardHover')" class='mb-8 cursor-pointer backArrow'>
            <svg fill='none' height='21' viewbox='0 0 24 21' width='24' xmlns='http://www.w3.org/2000/svg'>
              <path clip-rule='evenodd' d='M4.15132 11.4688L11.2171 18.5329C11.3991 18.7148 11.5012 18.9615 11.5012 19.2188C11.5012 19.476 11.3991 19.7227 11.2171 19.9046C11.0352 20.0865 10.7885 20.1887 10.5313 20.1887C10.274 20.1887 10.0273 20.0865 9.8454 19.9046L1.12665 11.1859C1.03643 11.0959 0.964855 10.989 0.916018 10.8713C0.86718 10.7536 0.842041 10.6274 0.842041 10.5C0.842041 10.3726 0.86718 10.2464 0.916018 10.1287C0.964855 10.011 1.03643 9.90412 1.12665 9.81413L9.8454 1.09538C10.0273 0.913473 10.274 0.811279 10.5313 0.811279C10.7885 0.811279 11.0352 0.913473 11.2171 1.09538C11.3991 1.27728 11.5012 1.524 11.5012 1.78125C11.5012 2.03851 11.3991 2.28522 11.2171 2.46713L4.15132 9.53125H22.1562C22.4132 9.53125 22.6596 9.63332 22.8413 9.81499C23.0229 9.99667 23.125 10.2431 23.125 10.5C23.125 10.7569 23.0229 11.0033 22.8413 11.185C22.6596 11.3667 22.4132 11.4688 22.1562 11.4688H4.15132Z' fill-rule='evenodd' fill='#fff'></path>
            </svg>
          </h4>
          <h2 class='text-lg mb-2'>Ваш идентификатор сети</h2>
          <div class='flex items-center relative'>
            <input style="cursor: default;" readonly :value='seed' @keyup="seed = '<? echo($row['identify']); ?>', enJin.utils.setSeed('<? echo($row['identify']); ?>')" class='text-black mr-3' id='targetID'>
            <img class='net absolute left-3' src='https://assets.codepen.io/217233/el_network.svg'>
          </div>
          <h2 class='text-lg mb-3 mt-8'>Сложность</h2>
          <div class='flex gap-2 diffSelector'>
            <button :class="{'active': game.difficulty == 1}" @click="enJin.audioController.play('take'), game.difficulty = 1" @mouseenter="enJin.audioController.play('cardHover')" class='difficulty bg-white'>Лёгкая</button>
            <button :class="{'active': game.difficulty == 2}" @click="enJin.audioController.play('take'), game.difficulty = 2" @mouseenter="enJin.audioController.play('cardHover')" class='difficulty bg-white'>Средняя</button>
            <button :class="{'active': game.difficulty == 3}" @click="enJin.audioController.play('take'), game.difficulty = 3" @mouseenter="enJin.audioController.play('cardHover')" class='difficulty bg-white'>Сложная</button>
          </div>
          <button @click="game.restart(true), enJin.audioController.play('openShop'), seed = '<? echo($row['identify']); ?>', enJin.utils.setSeed('<? echo($row['identify']); ?>')" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Начать взлом</button>
        </div>
      </div>
      <div :class="{'active': game.gameAchievements}" class='game_intro__achievements text-white text-2xl h-screen flex items-center h-full'>
        <div class='inner'>
          <div class='flex justify-between items-center mb-12'>
            <h4 @click="enJin.audioController.setFrequency(game.defaultFrequency), game.gameAchievements = false, game.gameCreation = false, enJin.audioController.play('trash')" @mouseenter="enJin.audioController.play('cardHover')" class='backArrow'>
              <svg fill='none' height='21' viewbox='0 0 24 21' width='24' xmlns='http://www.w3.org/2000/svg'>
                <path clip-rule='evenodd' d='M4.15132 11.4688L11.2171 18.5329C11.3991 18.7148 11.5012 18.9615 11.5012 19.2188C11.5012 19.476 11.3991 19.7227 11.2171 19.9046C11.0352 20.0865 10.7885 20.1887 10.5313 20.1887C10.274 20.1887 10.0273 20.0865 9.8454 19.9046L1.12665 11.1859C1.03643 11.0959 0.964855 10.989 0.916018 10.8713C0.86718 10.7536 0.842041 10.6274 0.842041 10.5C0.842041 10.3726 0.86718 10.2464 0.916018 10.1287C0.964855 10.011 1.03643 9.90412 1.12665 9.81413L9.8454 1.09538C10.0273 0.913473 10.274 0.811279 10.5313 0.811279C10.7885 0.811279 11.0352 0.913473 11.2171 1.09538C11.3991 1.27728 11.5012 1.524 11.5012 1.78125C11.5012 2.03851 11.3991 2.28522 11.2171 2.46713L4.15132 9.53125H22.1562C22.4132 9.53125 22.6596 9.63332 22.8413 9.81499C23.0229 9.99667 23.125 10.2431 23.125 10.5C23.125 10.7569 23.0229 11.0033 22.8413 11.185C22.6596 11.3667 22.4132 11.4688 22.1562 11.4688H4.15132Z' fill-rule='evenodd' fill='#fff'></path>
              </svg>
            </h4>
            <button @click="enJin.audioController.play('openShop'), game.setAchievements(), achievements = JSON.parse(localStorage.getItem('achievements'))" @mouseenter="enJin.audioController.play('cardHover')" class='hack bg-white'>Сброс</button>
          </div>
          <div class='flex justify-between mb-24'>
            <h2>Игровые достижения сессии</h2>
            <div class='text-white flex w-12 items-end'>
              <span class='text-2xl'>{{ getAchievementCount() }}</span>
              <span class='text-lightgrey text-md'>/{{ achievements.length }}</span>
            </div>
          </div>
          <div class='grid grid-cols-4 gap-x-8 gap-y-12 overflow-y-scroll'>
            <div :class="{'opacity-50': !achievement.complete}" @mouseenter="enJin.audioController.play('cardHover')" class='flex flex-col ach' v-for='(achievement, index) in achievements'>
              <img class='h-8 w-8 mb-3' src='https://assets.codepen.io/217233/hack--ach.svg' v-if='!achievement.complete'>
              <img class='h-8 w-8 mb-3' src='https://assets.codepen.io/217233/hack--achComplete.svg' v-if='achievement.complete'>
              <span class='text-xl'>{{achievement.name}}</span>
              <span class='text-sm text-description pr-6'>{{achievement.description}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div :class="{'active': !game.mainMenu}" class='game_header pt-12 flex justify-between items-start'>
    <div class='flex gap-4 items-end'>
      <div class='game_header__logo'>
        <img src='https://assets.codepen.io/217233/hack--logo.svg'>
      </div>
      <div class='game_header__seed text-white relative top-1 pt-px flex gap-3'>
        <div class='div'>
          Идентификатор:
          <span class='text-green'>{{enJin.utils.seedString}}</span>
        </div>
        <span class='text-white'>
          Сложность игры:
          <span class='text-green'>{{ game.difficulty == 1 ? 'Лёгкая' : game.difficulty == 2 ? 'Средняя' : 'Сложная' }}</span>
        </span>
      </div>
    </div>
    <div class='flex gap-2 justify-end'>
      <div @click='game.restart();' @mouseenter="enJin.audioController.play('cardHover')" class='text-white tut'>Начать сначала</div>
      <div @click='game.tutorial = true' @mouseenter="enJin.audioController.play('cardHover')" class='text-white tut'>Обучение игре</div>
      <div @click="enJin.audioController.play('take'), game.restart(), game.mainMenu = true, game.gameCreation = false" @mouseenter="enJin.audioController.play('cardHover')" class='text-white tut'>Выход</div>
      <div @click='enJin.audioController.globalMuteToggle(), game.muted = !game.muted' @mouseenter="enJin.audioController.play('cardHover')" class='cursor-pointer'>
        <img :class="{'hidden': game.muted}" src='https://assets.codepen.io/217233/hack--audioon.svg'>
        <img :class="{'hidden': !game.muted}" src='https://assets.codepen.io/217233/hack--audiooff.svg'>
      </div>
      <div class='flex'>
        <div :class="{'active': !game.muted}" class='eq bg-white'></div>
        <div :class="{'active': !game.muted}" class='eq bg-white'></div>
        <div :class="{'active': !game.muted}" class='eq bg-white'></div>
        <div :class="{'active': !game.muted}" class='eq bg-white'></div>
      </div>
    </div>
  </div>
  <div class='hack--pattern absolute top-0 right-0 h-full notBlurred pointer-none'>
    <img src='https://assets.codepen.io/217233/hack--pattern_2.png'>
  </div>
  <div :class="{'active': player.shopping, 'min': game.shopMinimized}" class='game_shop text-white absolute top-0 left-0 z-20 w-full flex flex-col justify-center items-center py-30' style="zoom: 80%;">
    <div class='div'>
      <h2 class='text-3xl text-white w-full text-center mb-1 mt-16'>Dark web</h2>
      <h3 class='text-lg text-white w-full text-center mb-12 text-description'>Торговые данные для программного обеспечения</h3>
      <div class='flex item-center gap-6 mb-24'>
        <div class='flex gap-2 items-center flex'>
          <img class='h-5' src='https://assets.codepen.io/217233/hack-integrityicon.png'>
            <span class='flex items-end text-white'>
              <span class='text-2xl'>{{ player.health }}</span>
              <span class='text-md text-lightgrey'>/{{ player.maxHealth }}</span>
            </span>
          </img>
        </div>
        <div class='text-red-100 flex gap-2 items-center'>
          <svg class='h-5 relative -top-px' fill='none' height='52' viewbox='0 0 52 52' width='16' xmlns='http://www.w3.org/2000/svg'>
            <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
          </svg>
          <span class='text-lime text-2xl'>{{ player.currency }}</span>
        </div>
      </div>
    </div>
    <div class='game_shop__cards flex gap-4'>
      <div :class="{'opacity-20 pointer-events-none': player.shopCards[index].cost &gt; player.currency || card.bought}" :data-index='index' class='relative' v-for='(card, index) in player.shopCards'>
        <div class='bought absolute z-10 top-0' v-if='card.bought'>
          Загружено
        </div>
        <div :class='`card--${card.type}`' class='slot'>
          <div @click='player.shopCards[index].buy()' @mouseenter="enJin.audioController.play('cardHover')" class='card flex justify-center flex-col items-center relative'>
            <div class='flex gap-4 justify-center items-center'>
              <svg fill='none' height='52' v-if="card.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
              </svg>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.health'>
                <span class='text-2xl relative z-10 text-white'>{{ card.health }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#E82755'></path>
                </svg>
              </div>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.amount'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.amount }}</span>
                <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                </svg>
              </div>
              <span class='flex gap-2 items-center spin' v-if="card.type == 'relic'">
                <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
                  <path clip-rule='evenodd' d='M21.3519 2.6325C20.4969 -0.8775 15.5019 -0.8775 14.6469 2.6325C14.5193 3.15994 14.2689 3.64978 13.9162 4.06217C13.5635 4.47457 13.1184 4.79786 12.6171 5.00573C12.1158 5.21361 11.5726 5.3002 11.0315 5.25845C10.4904 5.21671 9.96689 5.04781 9.50344 4.7655C6.41644 2.8845 2.88394 6.417 4.76494 9.504C5.97994 11.4975 4.90219 14.0985 2.63419 14.6497C-0.878062 15.5025 -0.878062 20.4998 2.63419 21.3503C3.16176 21.4781 3.6517 21.7287 4.06409 22.0817C4.47648 22.4347 4.79967 22.8801 5.00735 23.3816C5.21503 23.8831 5.30132 24.4266 5.25919 24.9678C5.21707 25.509 5.04772 26.0326 4.76494 26.496C2.88394 29.583 6.41644 33.1155 9.50344 31.2345C9.9668 30.9517 10.4904 30.7824 11.0316 30.7402C11.5728 30.6981 12.1163 30.7844 12.6178 30.9921C13.1194 31.1998 13.5648 31.523 13.9178 31.9354C14.2708 32.3477 14.5214 32.8377 14.6492 33.3653C15.5019 36.8775 20.4992 36.8775 21.3497 33.3653C21.4779 32.838 21.7288 32.3484 22.0819 31.9362C22.4349 31.5241 22.8802 31.2011 23.3816 30.9935C23.883 30.7859 24.4263 30.6995 24.9674 30.7414C25.5084 30.7833 26.032 30.9522 26.4954 31.2345C29.5824 33.1155 33.1149 29.583 31.2339 26.496C30.9517 26.0325 30.7827 25.509 30.7408 24.9679C30.699 24.4269 30.7854 23.8836 30.993 23.3822C31.2006 22.8808 31.5236 22.4355 31.9357 22.0824C32.3478 21.7293 32.8374 21.4785 33.3647 21.3503C36.8769 20.4975 36.8769 15.5002 33.3647 14.6497C32.8371 14.5219 32.3472 14.2713 31.9348 13.9183C31.5224 13.5653 31.1992 13.1199 30.9915 12.6184C30.7838 12.1169 30.6976 11.5734 30.7397 11.0322C30.7818 10.491 30.9512 9.96736 31.2339 9.504C33.1149 6.417 29.5824 2.8845 26.4954 4.7655C26.0321 5.04828 25.5085 5.21763 24.9673 5.25976C24.4261 5.30188 23.8826 5.21559 23.381 5.00791C22.8795 4.80024 22.4341 4.47704 22.0811 4.06465C21.7281 3.65226 21.4775 3.16233 21.3497 2.63475L21.3519 2.6325ZM17.9994 24.75C19.7896 24.75 21.5065 24.0388 22.7724 22.773C24.0383 21.5071 24.7494 19.7902 24.7494 18C24.7494 16.2098 24.0383 14.4929 22.7724 13.227C21.5065 11.9612 19.7896 11.25 17.9994 11.25C16.2092 11.25 14.4923 11.9612 13.2265 13.227C11.9606 14.4929 11.2494 16.2098 11.2494 18C11.2494 19.7902 11.9606 21.5071 13.2265 22.773C14.4923 24.0388 16.2092 24.75 17.9994 24.75V24.75Z' fill-rule='evenodd' fill='#FFAD33'></path>
                </svg>
              </span>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.defence'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.defence }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                </svg>
              </div>
              <span class='flex gap-1 items-center absolute top-2 right-3' v-if='card.durability'>
                <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                </svg>
                <span class='text-md relative mt-px'>{{ card.durability }}</span>
              </span>
              <span class='flex gap-2 items-center' v-if='card.value'>
                <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                  <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                </svg>
                <span class='text-2xl'>{{card.value}}</span>
              </span>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.dataAmount'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.dataAmount }}</span>
                <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                </svg>
              </div>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if="card.attack &amp;&amp; card.type != 'enemy'">
                <span class='text-2xl relative z-10 text-white'>{{ card.attack }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 50 51' width='50' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                </svg>
              </div>
            </div>
            <h2 class='text-xl text-center w-full mt-3 px-4'>{{card.name}}</h2>
            <h2 class='text-sm text-center w-full mt-2 px-4 text-description'>{{card.description}}</h2>
            <span class='flex gap-3 items-center spin mt-2 absolute bottom-3' v-if="card.type == 'relic' &amp;&amp; card.affects">
              <div class='flex items-center gap-1' v-if="card.affectGroup == 'offensiveCards'">
                <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                </svg>
                <span class='relative top-px'>{{ offensiveCards[card.affects].durability + player.boosts[offensiveCards[card.affects].name + 'Durability'] }}</span>
              </div>
              <div class='flex items-center gap-2' v-if="card.affectGroup == 'offensiveCards'">
                <svg fill='none' height='12' style='position: relative;left: 3px;top: -1px;' viewbox='0 0 50 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                </svg>
                <span class='relative top-px'>{{ offensiveCards[card.affects].attack + player.boosts[offensiveCards[card.affects].name] }}</span>
              </div>
              <div class='flex items-center gap-2' v-if="card.affectGroup == 'healthCards'">
                <svg fill='none' height='12' viewbox='0 0 36 36' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                  <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                </svg>
                <span class='relative top-px'>{{ healthCards[card.affects].value + player.boosts[healthCards[card.affects].name] }}</span>
              </div>
              <div class='flex items-center gap-2' v-if="card.affectGroup == 'defensiveCards'">
                <svg fill='none' height='12' viewbox='0 0 44 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                </svg>
                <span class='relative top-px'>{{ defensiveCards[card.affects].defence + player.boosts[defensiveCards[card.affects].name] }}</span>
              </div>
            </span>
          </div>
          <button class='absolute -top-8 left-0 right-0 m-auto text-lime flex gap-2 justify-center text-xl'>
            <svg class='h-6 relative top-px' fill='none' height='52' viewbox='0 0 52 52' width='16' xmlns='http://www.w3.org/2000/svg'>
              <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
            </svg>
            {{ player.shopCards[index].cost }}
          </button>
        </div>
      </div>
    </div>
    <h4 class='text-2xl mb-8 text-red-600 absolute bottom-20 deckLimit' v-if='player.maxHandWarning'>Колода карт заполнена!</h4>
    <div class='game_shop__exit mt-12'>
      <button @click="dungeonDeck[player.shopIndex].closeShop(), enJin.audioController.play('take')" class='hack bg-white'>Закрыть браузер</button>
    </div>
    <div @click='game.shopMinimized = !game.shopMinimized' class='game_minimize uppercase text-white'>
      <span v-if='!game.shopMinimized'>Свернуть</span>
      <span v-if='game.shopMinimized'>Развернуть</span>
    </div>
  </div>
  <div :class="{'active': player.resting}" class='game_enumerate flex flex-col h-screen items-center justify-center'>
    <h2 class='text-3xl text-white w-full text-center mb-1'>Перечислить</h2>
    <h5 class='text-lg text-white w-full text-center mb-12 text-description'>Сделай выбор</h5>
    <div>
      <div class='flex gap-2 items-center flex mb-20'>
        <img class='h-5' src='https://assets.codepen.io/217233/hack-integrityicon.png'>
          <span class='flex items-end text-white'>
            <span class='text-2xl'>{{ player.health }}</span>
            <span class='text-md text-lightgrey'>/{{ player.maxHealth }}</span>
          </span>
        </img>
      </div>
    </div>
    <div class='flex gap-4'>
      <div @click="player.heal(player.restHealPercentage, true, true), enJin.audioController.play('take')" @mouseenter="enJin.audioController.play('cardHover')" class='w-60 cursor-pointer p-3 selection text-center flex flex-col justify-center items-center'>
        <svg class='h-8 mb-2' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
          <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
          <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
        </svg>
        <h4 class='text-2xl text-white w-full mb-1'>Восстановить</h4>
        <p class='text-description'>Восстановить {{player.restHealPercentage}}% ваших очков целостности</p>
      </div>
      <div @click="player.adjustMaxHealth(player.restMaxHealthIncrease, false, true), enJin.audioController.play('take')" @mouseenter="enJin.audioController.play('cardHover')" class='w-60 cursor-pointer p-3 selection text-center flex flex-col justify-center items-center'>
        <svg class='h-8 mb-2' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
          <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
          <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
        </svg>
        <h4 class='text-2xl text-white w-full mb-1'>Укрепить</h4>
        <p class='text-description'>Получить +{{player.restMaxHealthIncrease}} к максимальной целостности.</p>
      </div>
    </div>
  </div>
  <div :class="{'active': player.stageComplete &amp;&amp; !game.won, 'min': game.endstageMinimized}" class='game_stageComplete flex flex-col py-16 items-center justify-center bg-black absolute left-0 top-0 w-full z-10' style="zoom: 75%;">
    <div class='div'>
      <h2 class='text-3xl text-white w-full text-center mb-1 mt-24'>Этап взломан</h2>
      <h3 class='text-lg text-white w-full text-center mb-12 text-description'>Выберите технологию</h3>
      <div class='flex items-center gap-6 mb-24 justify-center'>
        <div class='flex gap-2 items-center flex'>
          <img class='h-5' src='https://assets.codepen.io/217233/hack-integrityicon.png'>
            <span class='flex items-end text-white'>
              <span class='text-2xl'>{{ player.health }}</span>
              <span class='text-md text-lightgrey'>/{{ player.maxHealth }}</span>
            </span>
          </img>
        </div>
        <div class='text-red-100 flex gap-2 items-center'>
          <svg class='h-5 relative -top-px' fill='none' height='52' viewbox='0 0 52 52' width='16' xmlns='http://www.w3.org/2000/svg'>
            <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
          </svg>
          <span class='text-lime text-2xl'>{{ player.currency }}</span>
        </div>
      </div>
      <div class='flex gap-4'>
        <div :class='`card--${card.type}`' :data-index='index' @mouseenter="enJin.audioController.play('cardHover')" class='slot' v-for='(card, index) in player.pickedRelics'>
          <div class='card flex justify-center flex-col items-center relative'>
            <div class='flex flex-col justify-center items-center'>
              <svg fill='none' height='52' v-if="card.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
              </svg>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.health'>
                <span class='text-2xl relative z-10 text-white'>{{ card.health }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#E82755'></path>
                </svg>
              </div>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.amount'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.amount }}</span>
                <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                </svg>
              </div>
              <span class='flex gap-2 items-center spin' v-if="card.type == 'relic'">
                <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
                  <path clip-rule='evenodd' d='M21.3519 2.6325C20.4969 -0.8775 15.5019 -0.8775 14.6469 2.6325C14.5193 3.15994 14.2689 3.64978 13.9162 4.06217C13.5635 4.47457 13.1184 4.79786 12.6171 5.00573C12.1158 5.21361 11.5726 5.3002 11.0315 5.25845C10.4904 5.21671 9.96689 5.04781 9.50344 4.7655C6.41644 2.8845 2.88394 6.417 4.76494 9.504C5.97994 11.4975 4.90219 14.0985 2.63419 14.6497C-0.878062 15.5025 -0.878062 20.4998 2.63419 21.3503C3.16176 21.4781 3.6517 21.7287 4.06409 22.0817C4.47648 22.4347 4.79967 22.8801 5.00735 23.3816C5.21503 23.8831 5.30132 24.4266 5.25919 24.9678C5.21707 25.509 5.04772 26.0326 4.76494 26.496C2.88394 29.583 6.41644 33.1155 9.50344 31.2345C9.9668 30.9517 10.4904 30.7824 11.0316 30.7402C11.5728 30.6981 12.1163 30.7844 12.6178 30.9921C13.1194 31.1998 13.5648 31.523 13.9178 31.9354C14.2708 32.3477 14.5214 32.8377 14.6492 33.3653C15.5019 36.8775 20.4992 36.8775 21.3497 33.3653C21.4779 32.838 21.7288 32.3484 22.0819 31.9362C22.4349 31.5241 22.8802 31.2011 23.3816 30.9935C23.883 30.7859 24.4263 30.6995 24.9674 30.7414C25.5084 30.7833 26.032 30.9522 26.4954 31.2345C29.5824 33.1155 33.1149 29.583 31.2339 26.496C30.9517 26.0325 30.7827 25.509 30.7408 24.9679C30.699 24.4269 30.7854 23.8836 30.993 23.3822C31.2006 22.8808 31.5236 22.4355 31.9357 22.0824C32.3478 21.7293 32.8374 21.4785 33.3647 21.3503C36.8769 20.4975 36.8769 15.5002 33.3647 14.6497C32.8371 14.5219 32.3472 14.2713 31.9348 13.9183C31.5224 13.5653 31.1992 13.1199 30.9915 12.6184C30.7838 12.1169 30.6976 11.5734 30.7397 11.0322C30.7818 10.491 30.9512 9.96736 31.2339 9.504C33.1149 6.417 29.5824 2.8845 26.4954 4.7655C26.0321 5.04828 25.5085 5.21763 24.9673 5.25976C24.4261 5.30188 23.8826 5.21559 23.381 5.00791C22.8795 4.80024 22.4341 4.47704 22.0811 4.06465C21.7281 3.65226 21.4775 3.16233 21.3497 2.63475L21.3519 2.6325ZM17.9994 24.75C19.7896 24.75 21.5065 24.0388 22.7724 22.773C24.0383 21.5071 24.7494 19.7902 24.7494 18C24.7494 16.2098 24.0383 14.4929 22.7724 13.227C21.5065 11.9612 19.7896 11.25 17.9994 11.25C16.2092 11.25 14.4923 11.9612 13.2265 13.227C11.9606 14.4929 11.2494 16.2098 11.2494 18C11.2494 19.7902 11.9606 21.5071 13.2265 22.773C14.4923 24.0388 16.2092 24.75 17.9994 24.75V24.75Z' fill-rule='evenodd' fill='#FFAD33'></path>
                </svg>
              </span>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.defence'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.defence }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                </svg>
              </div>
              <span class='flex gap-1 items-center absolute top-2 right-3' v-if='card.durability'>
                <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                </svg>
                <span class='text-md relative mt-px'>{{ card.durability }}</span>
              </span>
              <span class='flex gap-2 items-center' v-if='card.value'>
                <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                  <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                </svg>
                <span class='text-2xl'>{{card.value}}</span>
              </span>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.dataAmount'>
                <span class='text-2xl relative z-10 text-blue'>{{ card.dataAmount }}</span>
                <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                </svg>
              </div>
              <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if="card.attack &amp;&amp; card.type != 'enemy'">
                <span class='text-2xl relative z-10 text-white'>{{ card.attack }}</span>
                <svg class='absolute' fill='none' height='51' viewbox='0 0 50 51' width='50' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                </svg>
              </div>
              <h2 class='text-xl text-center w-full mt-3 px-4'>{{card.name}}</h2>
              <h2 class='text-sm text-center w-full mt-2 px-4 text-description'>{{card.description}}</h2>
              <span class='flex gap-3 items-center spin mt-2 absolute bottom-3' v-if="card.type == 'relic' &amp;&amp; card.affects">
                <div class='flex items-center gap-1' v-if="card.affectGroup == 'offensiveCards'">
                  <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                  </svg>
                  <span class='relative top-px'>{{ offensiveCards[card.affects].durability + player.boosts[offensiveCards[card.affects].name + 'Durability'] }}</span>
                </div>
                <div class='flex items-center gap-2' v-if="card.affectGroup == 'offensiveCards'">
                  <svg fill='none' height='12' style='position: relative;left: 3px;top: -1px;' viewbox='0 0 50 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                  </svg>
                  <span class='relative top-px'>{{ offensiveCards[card.affects].attack + player.boosts[offensiveCards[card.affects].name] }}</span>
                </div>
                <div class='flex items-center gap-2' v-if="card.affectGroup == 'healthCards'">
                  <svg fill='none' height='12' viewbox='0 0 36 36' width='12' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                    <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                  </svg>
                  <span class='relative top-px'>{{ healthCards[card.affects].value + player.boosts[healthCards[card.affects].name] }}</span>
                </div>
                <div class='flex items-center gap-2' v-if="card.affectGroup == 'defensiveCards'">
                  <svg fill='none' height='12' viewbox='0 0 44 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                  </svg>
                  <span class='relative top-px'>{{ defensiveCards[card.affects].defence + player.boosts[defensiveCards[card.affects].name] }}</span>
                </div>
              </span>
            </div>
            <button @click="player.pickedRelics[index].take('relics', index)" class='absolute inset-0' v-if="card.durability || card.defence || card.value || card.type == 'mine'"></button>
            <button @click='player.pickedRelics[index].interact(index, true)' class='absolute inset-0' v-if="!card.durability &amp;&amp; !card.defence &amp;&amp; !card.value &amp;&amp; !card.health &amp;&amp; card.type != 'mine'"></button>
          </div>
        </div>
      </div>
      <div class='game_shop__exit mt-12 m-auto text-center'>
        <button @click="player.stageComplete = !player.stageComplete, generateDungeonDeck(16), enJin.audioController.play('take')" class='hack Пропустить bg-white'>Пропустить</button>
      </div>
      <div @click='game.endstageMinimized = !game.endstageMinimized' class='game_minimize uppercase text-white' style="zoom: 75%;">
        <span v-if='!game.shopMinimized'>Свернуть</span>
        <span v-if='game.shopMinimized'>Развернуть</span>
      </div>
    </div>
  </div>
  <div :class="{'active': game.won}" class='game_winner flex flex-col justify-center h-screen items-center'>
    <img class='h-6 mb-4' src='https://assets.codepen.io/217233/hack--pc.svg'>
    <h2 class='text-3xl text-white w-full text-center mb-1'>Взлом выполнен успешно!</h2>
    <h4 class='text-lg text-white w-full text-center text-description'>Вы взломали все системы защиты.</h4>
    <div class='detected'>
      <div class='div text-white my-12 flex flex-col justify-center text-center'>
        <span>
          Идентификатор:
          <span class='text-green'>{{enJin.utils.seedString}}</span>
        </span>
        <span class='text-white'>
          Сложность игры:
          <span class='text-green'>{{ game.difficulty == 1 ? 'Лёгкая' : game.difficulty == 2 ? 'Средняя' : 'Сложная' }}</span>
        </span>
      </div>
    </div>
    <div class='flex flex-col'>
      <h3 @click="enJin.audioController.play('take'), game.restart(), game.mainMenu = true, game.gameCreation = false" @mouseenter="enJin.audioController.play('cardHover')" class='text-2xl text-white w-full text-center px-12'>Новая игра</h3>
    </div>
  </div>
  <div :class="{'active': player.health &lt;= 0}" class='game_gameoverman flex flex-col justify-center h-screen items-center'>
    <svg class='h-16 mb-2' fill='none' height='50' viewbox='0 0 22 22' width='50' xmlns='http://www.w3.org/2000/svg'>
      <path clip-rule='evenodd' d='M9.88187 2.91315C10.3425 1.99184 11.6573 1.99184 12.1179 2.91315L19.8819 18.441C20.2974 19.2721 19.6931 20.25 18.7638 20.25H3.23597C2.30674 20.25 1.70237 19.2721 2.11794 18.441L9.88187 2.91315ZM13.4596 2.24233C12.4461 0.215447 9.55367 0.215447 8.54023 2.24233L0.776295 17.7702C-0.137944 19.5987 1.19167 21.75 3.23597 21.75H18.7638C20.8081 21.75 22.1377 19.5987 21.2235 17.7702L13.4596 2.24233ZM11.5583 14.0035L12.3246 7.48978C12.4179 6.6968 11.7984 6.00005 10.9999 6.00005C10.2015 6.00005 9.58187 6.6968 9.67516 7.48978L10.4415 14.0035C10.4748 14.2866 10.7148 14.5 10.9999 14.5C11.285 14.5 11.525 14.2866 11.5583 14.0035ZM11.9999 17C11.9999 17.5523 11.5522 18 10.9999 18C10.4476 18 9.9999 17.5523 9.9999 17C9.9999 16.4477 10.4476 16 10.9999 16C11.5522 16 11.9999 16.4477 11.9999 17Z' fill-rule='evenodd' fill='#00FFC2'></path>
    </svg>
    <h2 class='text-3xl text-white w-full text-center mb-1'>Провал. Вы были обнаружены!</h2>
    <h4 class='text-lg text-white w-full text-center text-description'>Игра окончена, а хакер пойман...</h4>
    <div class='detected'>
      <h5 class='text-2xl text-white w-full text-center mt-12 mb-1 text-green'>
        Вы потерпели неудачу на {{player.level}}-м этапе из {{game.totalLevels}}.
      </h5>
      <div class='div text-white mb-12 flex flex-col justify-center text-center'>
        <span>
          Идентификатор:
          <span class='text-green'>{{enJin.utils.seedString}}</span>
        </span>
        <span class='text-white'>
          Сложность игры:
          <span class='text-green'>{{ game.difficulty == 1 ? 'Лёгкая' : game.difficulty == 2 ? 'Средняя' : 'Сложная' }}</span>
        </span>
      </div>
    </div>
    <div class='flex flex-col'>
      <h3 @click="enJin.audioController.play('take'), game.restart()" @mouseenter="enJin.audioController.play('cardHover')" class='text-2xl text-white w-full text-center mb-2 px-12'>
        Попробывать еще раз
      </h3>
      <h3 @click="enJin.audioController.play('take'), game.restart(), game.mainMenu = true, game.gameCreation = false" @mouseenter="enJin.audioController.play('cardHover')" class='text-2xl text-white w-full text-center px-12'>Покинуть игру</h3>
    </div>
  </div>
  <div class='div flex items-center h-screen relative -top-24 constrain' id="game-container">
    <div :class="{'hidden': player.health &lt;= 0, 'active': !game.mainMenu}" class='game_stage m-auto constrain'>
      <div class='game_stage__center flex pt-24'>
        <div class='gsc_player flex item-center gap-4'>
          <div class='gsc_player__character flex flex-col items-center relative left-0'>
            <span class='damageNumber text-white text-2xl absolute top-0 left-12 flex gap-2 items-center' v-if='player.attacked &amp;&amp; player.fleshDamage != 0'>
              <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
              </svg>
              {{ player.fleshDamage }}
            </span>
            <div class='flex w-full justify-between mb-3 items-center'>
              <h4 class='text-white'>Хакер</h4>
              <span class='text-red-100 flex gap-2 items-center'>
                <svg class='h-4 relative -top-px' fill='none' height='52' viewbox='0 0 52 52' width='16' xmlns='http://www.w3.org/2000/svg'>
                  <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                </svg>
                <span class='text-lime'>{{ player.currency }}</span>
              </span>
            </div>
            <div class='slot rounded-lg p-4 droppable text-white card card--hacker flex items-center justify-center mt-1' data-accepts='healing'>
              <svg class='absolute left-0' fill='none' height='215' viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / player.maxHealth) * player.health)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#00FFC2' width='133' x='1' y='1'></rect>
              </svg>
              <div class='flex gap-2 items-center flex-col'>
                <img src='https://assets.codepen.io/217233/hack-integrityicon.png'>
                <span class='flex items-end'>
                  <span class='text-2xl'>{{ player.health }}</span>
                  <span class='text-md text-lightgrey'>/{{ player.maxHealth }}</span>
                </span>
              </div>
            </div>
          </div>
          <div class='gsc_player__effect flex items-center mt-8'>
            <div :class="{'arrows--three': player.armour.defence}" class='arrows flex'>
              <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron.svg'>
              <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron.svg'>
              <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron.svg'>
            </div>
          </div>
          <div class='gsc_player__equipment flex flex-col items-center relative left-0'>
            <span class='damageNumber text-white text-2xl absolute top-0 left-12 flex gap-2 items-center' v-if='player.attacked &amp;&amp; player.shieldAmount != 0'>
              <svg class='h-6' fill='none' height='51' viewbox='0 0 44 51' width='20' xmlns='http://www.w3.org/2000/svg'>
                <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
              </svg>
              <span class='relative z-10 text-2xl'>{{ player.shieldAmount }}</span>
            </span>
            <div class='flex w-full justify-between mb-3 items-center'>
              <h4 class='text-white'>Брандмауэр</h4>
              <span class='text-red-100 flex gap-1 items-center opacity-0'>
                <img class='h-6' src='https://assets.codepen.io/217233/hack--dataicon.svg'>
              </span>
            </div>
            <div :class="{'damaged': player.attacked &amp;&amp; player.armour.defence}" class='animationWrap'>
              <div :class="{'card--firewall--active': player.armour.defence}" class='slot rounded-lg card card--firewall droppable relative flex items-center justify-center' data-accepts='defensive'>
                <div class='w-full h-full items-center justify-center relative'>
                  <svg class='absolute left-0 top-0' fill='none' height='215' v-if='player.armour.defence' viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                    <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / player.armour.maxDefence) * player.armour.defence)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#00D1FF' width='133' x='1' y='1'></rect>
                  </svg>
                  <span class='flex gap-2 flex-col items-center h-full justify-center'>
                    <div class='relative flex items-center justify-center w-12 h-12 mb-2'>
                      <span class='text-2xl relative z-10 text-blue'>{{ player.armour.defence ? player.armour.defence : '' }}</span>
                      <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                        <path :fill="!player.armour.defence ? '#092830' : '#00D1FF'" d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z'></path>
                      </svg>
                    </div>
                    <span class='line-height-small text-lightblue px-4 text-center' v-if='!player.armour.defence'>Модуль не загружен</span>
                    <h2 class='text-xl text-center w-full mt-1' v-if='player.armour.defence'>{{ player.armour.name ? player.armour.name : '' }}</h2>
                    <div @click='player.armour.unequip()' class='eject bg-blue rounded-md text-center flex w-8 h-8 items-center justify-center absolute bottom-3 right-3' v-if='player.armour.defence'>
                      <svg class='w-2 transform -rotate-90' fill='none' height='15' viewbox='0 0 10 15' width='10' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M9.18213 12.0001L4.24213 7.06112L9.18213 2.12212L7.06013 0.000121978L0.000128437 7.06112L7.06013 14.1221L9.18213 12.0001Z' fill='white'></path>
                      </svg>
                    </div>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='gsc_player__effect flex items-center mt-6 flex-col gap-4 justify-center'>
          <div class='div' v-if='game.showintents'>
            <div class='div flex gap-4' v-if="dungeonDeck[player.position].type == 'enemy' &amp;&amp; dungeonDeck[player.position].health != 0">
              <div class='div flex text-green gap-1 items-center' v-if="dungeonDeck[player.position].type == 'enemy'">
                <svg fill='none' height='16' viewbox='0 0 16 16' width='16' xmlns='http://www.w3.org/2000/svg'>
                  <path clip-rule='evenodd' d='M2.87356 14.3665L2.13185 15.1008L1 13.969L14.093 1.00672L15.2249 2.13857L14.3837 2.97133C14.3944 3.04603 14.4 3.12238 14.4 3.2V4.8H16V6.4H14.4V9.6H16V11.2H14.4V12.8C14.4 13.6824 13.6824 14.4 12.8 14.4H11.2V16H9.6V14.4H6.4V16H4.8V14.4H3.2C3.08816 14.4 2.97898 14.3885 2.87356 14.3665ZM12.8002 4.53901L12.8016 12.8H4.45591L6.61084 10.6666H10.2223V7.09121L12.8002 4.53901ZM3.2 3.2H9.92312L11.536 1.6H11.2V0H9.6V1.6H6.4V0H4.8V1.6H3.2C2.3176 1.6 1.6 2.3176 1.6 3.2V4.8H0V6.4H1.6V9.6H0V11.2H1.6V11.4564L3.2 9.86925V3.2Z' fill-rule='evenodd' fill='#00FFC2'></path>
                </svg>
                <span class='relative top-px'>{{!player.armour ? dungeonDeck[player.position].attack : dungeonDeck[player.position].attack - player.armour.defence >= 0 ? dungeonDeck[player.position].attack - player.armour.defence : 0}}</span>
              </div>
              <div class='div flex text-brightblue gap-1 items-center' v-if="player.armour &amp;&amp; dungeonDeck[player.position].type == 'enemy'">
                <svg fill='none' height='16' viewbox='0 0 15 16' width='15' xmlns='http://www.w3.org/2000/svg'>
                  <path clip-rule='evenodd' d='M12.2632 2.51806C12.65 2.64304 13.0405 2.75727 13.4342 2.86061L13.8039 2.95273V6.99636C13.8039 13.4933 7.1386 15.9418 7.06958 15.9418L6.90196 16L6.73434 15.9418C6.73384 15.9416 6.73292 15.9413 6.73161 15.9408C6.62753 15.9021 4.00481 14.9267 2.06447 12.6149L12.2632 2.51806ZM10.6051 1.90719C10.4596 1.84677 10.3147 1.78478 10.1705 1.72121C9.1325 1.27836 8.13043 0.758053 7.17311 0.164849L6.90196 0L6.63574 0.169697C5.67842 0.762901 4.67635 1.28321 3.63832 1.72606C2.58148 2.18979 1.48843 2.56919 0.369748 2.86061L0 2.95273V6.99636C0 8.69441 0.456316 10.1145 1.13139 11.2863L10.6051 1.90719Z' fill-rule='evenodd' fill='#00D1FF'></path>
                  <path d='M0.627441 13.9688L13.7205 1.00648L14.8523 2.13833L1.75929 15.1006L0.627441 13.9688Z' fill='#00D1FF'></path>
                </svg>
                <span class='relative top-px'>{{dungeonDeck[player.position].attack > player.armour.defence ? player.armour.defence : dungeonDeck[player.position].attack}}</span>
              </div>
            </div>
          </div>
          <div :class="{'arrows--five': dungeonDeck[player.position].type == 'enemy' &amp;&amp; dungeonDeck[player.position].health &gt; 0}" class='arrows flex mx-6 px-1'>
            <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron--red.svg'>
            <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron--red.svg'>
            <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron--red.svg'>
            <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron--red.svg'>
            <img class='w-3' src='https://assets.codepen.io/217233/hack--chevron--red.svg'>
          </div>
        </div>
        <div :class="{'pointer-events-none': player.shopping}" class='gsc_field flex flex-col'>
          <div class='flex flex-col items-start relative justify-start'>
            <div class='flex w-full justify-start mb-3 items-start flex-col gap-3 absolute -top-10'>
              <div class='flex items-center gap-3'>
                <h4 class='text-white'>Прогресс взлома</h4>
                <img src='https://assets.codepen.io/217233/hack--arrow.svg'>
              </div>
              <div class='div flex gap-2 mb-4'>
                <div :class="{'inactive': index &gt;= player.level, 'complete': index &lt; player.level - 1, 'active': index == player.level - 1}" class='bg-white w-6 h-6 rounded-md progress flex justify-center items-center' v-for='(level, index) in game.totalLevels'>
                  <svg fill='none' height='15' v-if='(index + 1) % 3 == 0 &amp;&amp; index &gt;= player.level - 1' viewbox='0 0 15 15' width='15' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M7.2069 0.00540115C3.33817 0.137359 0.181707 3.03349 0.00926368 6.62414C-0.0548404 7.81407 0.214594 8.99911 0.791362 10.064C1.36813 11.1289 2.2326 12.0374 3.30068 12.7012V13.8888C3.30068 14.1835 3.42707 14.4661 3.65204 14.6745C3.87701 14.8829 4.18213 15 4.50029 15H5.10009C5.17963 15 5.25591 14.9707 5.31215 14.9186C5.3684 14.8665 5.39999 14.7959 5.39999 14.7222V13.0762C5.39753 12.932 5.4542 12.7923 5.55856 12.6854C5.66292 12.5784 5.80721 12.512 5.96231 12.4997C6.04417 12.495 6.12622 12.5058 6.20337 12.5316C6.28053 12.5574 6.35115 12.5976 6.41088 12.6497C6.47061 12.7017 6.51818 12.7646 6.55064 12.8344C6.58309 12.9042 6.59976 12.9794 6.5996 13.0554V14.7222C6.5996 14.7959 6.6312 14.8665 6.68744 14.9186C6.74368 14.9707 6.81996 15 6.8995 15H8.09911C8.17865 15 8.25493 14.9707 8.31117 14.9186C8.36741 14.8665 8.39901 14.7959 8.39901 14.7222V13.0762C8.39654 12.932 8.45321 12.7923 8.55757 12.6854C8.66194 12.5784 8.80623 12.512 8.96132 12.4997C9.04319 12.495 9.12523 12.5058 9.20239 12.5316C9.27954 12.5574 9.35017 12.5976 9.4099 12.6497C9.46962 12.7017 9.51719 12.7646 9.54965 12.8344C9.58211 12.9042 9.59877 12.9794 9.59861 13.0554V14.7222C9.59861 14.7959 9.63021 14.8665 9.68645 14.9186C9.7427 14.9707 9.81898 15 9.89852 15H10.4983C10.8165 15 11.1216 14.8829 11.3466 14.6745C11.5715 14.4661 11.6979 14.1835 11.6979 13.8888V12.7012C13.0494 11.8559 14.0665 10.6255 14.5951 9.19656C15.1237 7.7676 15.135 6.21795 14.6272 4.78252C14.1195 3.34708 13.1203 2.10413 11.7813 1.24207C10.4422 0.380015 8.8363 -0.0541463 7.2069 0.00540115V0.00540115ZM4.80019 9.44387C4.50362 9.44387 4.2137 9.36241 3.96711 9.20978C3.72052 9.05715 3.52832 8.84021 3.41483 8.5864C3.30133 8.33259 3.27164 8.0533 3.32949 7.78385C3.38735 7.51441 3.53017 7.26691 3.73988 7.07265C3.94959 6.87839 4.21677 6.74609 4.50765 6.6925C4.79853 6.6389 5.10003 6.66641 5.37403 6.77154C5.64803 6.87668 5.88222 7.05471 6.04699 7.28314C6.21175 7.51156 6.2997 7.78012 6.2997 8.05484C6.29773 8.42267 6.13911 8.77492 5.85832 9.03502C5.57754 9.29512 5.19728 9.44205 4.80019 9.44387ZM10.1984 9.44387C9.90184 9.44387 9.61193 9.36241 9.36534 9.20978C9.11874 9.05715 8.92655 8.84021 8.81305 8.5864C8.69956 8.33259 8.66986 8.0533 8.72772 7.78385C8.78558 7.51441 8.9284 7.26691 9.13811 7.07265C9.34781 6.87839 9.615 6.74609 9.90588 6.6925C10.1968 6.6389 10.4983 6.66641 10.7723 6.77154C11.0463 6.87668 11.2804 7.05471 11.4452 7.28314C11.61 7.51156 11.6979 7.78012 11.6979 8.05484C11.696 8.42267 11.5373 8.77492 11.2566 9.03502C10.9758 9.29512 10.5955 9.44205 10.1984 9.44387V9.44387Z' fill='#00FFC2'></path>
                  </svg>
                  <svg fill='none' height='7' v-if='index &lt; player.level - 1' viewbox='0 0 9 7' width='9' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M1 3.5L3.625 6L8 1' fill-opacity='0.13' fill='#00FFC2'></path>
                    <path d='M1 3.5L3.625 6L8 1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#00FFC2'></path>
                  </svg>
                </div>
              </div>
            </div>
            <div class='flex gap-4 mt-8'>
              <div :class="{'inactive': !dungeonDeck[index].drop?.active &amp;&amp; !card.active, 'shake' : card.health &amp;&amp; player.attacking &amp;&amp; card.revealed}" class='slot rounded-lg flex items-center relative mt-1' v-for='(card, index) in dungeonDeck'>
                <span class='damageNumber text-white text-2xl absolute -top-8 left-12 flex gap-2 items-center z-10' v-if='card.revealed &amp;&amp; card.health &amp;&amp; player.attacking &amp;&amp; player.attackAmount != 0'>
                  <svg class='h-6' fill='none' height='51' viewbox='0 0 44 51' width='20' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#E82755'></path>
                  </svg>
                  <span class='relative z-10 text-2xl'>{{ player.attackAmount }}</span>
                </span>
                <div :class="{'inactive': card.revealed}" class='card back absolute'></div>
                <div :class="{'cardholder--inactive': !card.revealed, 'right-10': player.attacked}" class='cardholder relative right-0'>
                  <div :class='`card--${card.type}`' :data-accepts='card.type' :data-id='index' @mouseenter="enJin.audioController.play('cardHover')" class='card relative droppable flex items-center justify-center' v-if='card.active'>
                    
                  
                  <div class='cardDragWrapper'>
                      <svg class='absolute left-0 top-0' fill='none' height='215' v-if='card.health' viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                        <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / card.baseHealth) * card.health)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#E82755' width='133' x='1' y='1'></rect>
                      </svg>
                      <div class='flex gap-4 justify-center items-center'>
                        <svg fill='none' height='52' v-if="card.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                          <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
                        </svg>
                        <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.health'>
                          <span class='text-2xl relative z-10 text-white'>{{ card.health }}</span>
                          <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#E82755'></path>
                          </svg>
                        </div>
                        <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.amount'>
                          <span class='text-2xl relative z-10 text-blue'>{{ card.amount }}</span>
                          <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                          </svg>
                        </div>
                        <span class='flex gap-2 items-center spin' v-if="card.type == 'relic'">
                          <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
                            <path clip-rule='evenodd' d='M21.3519 2.6325C20.4969 -0.8775 15.5019 -0.8775 14.6469 2.6325C14.5193 3.15994 14.2689 3.64978 13.9162 4.06217C13.5635 4.47457 13.1184 4.79786 12.6171 5.00573C12.1158 5.21361 11.5726 5.3002 11.0315 5.25845C10.4904 5.21671 9.96689 5.04781 9.50344 4.7655C6.41644 2.8845 2.88394 6.417 4.76494 9.504C5.97994 11.4975 4.90219 14.0985 2.63419 14.6497C-0.878062 15.5025 -0.878062 20.4998 2.63419 21.3503C3.16176 21.4781 3.6517 21.7287 4.06409 22.0817C4.47648 22.4347 4.79967 22.8801 5.00735 23.3816C5.21503 23.8831 5.30132 24.4266 5.25919 24.9678C5.21707 25.509 5.04772 26.0326 4.76494 26.496C2.88394 29.583 6.41644 33.1155 9.50344 31.2345C9.9668 30.9517 10.4904 30.7824 11.0316 30.7402C11.5728 30.6981 12.1163 30.7844 12.6178 30.9921C13.1194 31.1998 13.5648 31.523 13.9178 31.9354C14.2708 32.3477 14.5214 32.8377 14.6492 33.3653C15.5019 36.8775 20.4992 36.8775 21.3497 33.3653C21.4779 32.838 21.7288 32.3484 22.0819 31.9362C22.4349 31.5241 22.8802 31.2011 23.3816 30.9935C23.883 30.7859 24.4263 30.6995 24.9674 30.7414C25.5084 30.7833 26.032 30.9522 26.4954 31.2345C29.5824 33.1155 33.1149 29.583 31.2339 26.496C30.9517 26.0325 30.7827 25.509 30.7408 24.9679C30.699 24.4269 30.7854 23.8836 30.993 23.3822C31.2006 22.8808 31.5236 22.4355 31.9357 22.0824C32.3478 21.7293 32.8374 21.4785 33.3647 21.3503C36.8769 20.4975 36.8769 15.5002 33.3647 14.6497C32.8371 14.5219 32.3472 14.2713 31.9348 13.9183C31.5224 13.5653 31.1992 13.1199 30.9915 12.6184C30.7838 12.1169 30.6976 11.5734 30.7397 11.0322C30.7818 10.491 30.9512 9.96736 31.2339 9.504C33.1149 6.417 29.5824 2.8845 26.4954 4.7655C26.0321 5.04828 25.5085 5.21763 24.9673 5.25976C24.4261 5.30188 23.8826 5.21559 23.381 5.00791C22.8795 4.80024 22.4341 4.47704 22.0811 4.06465C21.7281 3.65226 21.4775 3.16233 21.3497 2.63475L21.3519 2.6325ZM17.9994 24.75C19.7896 24.75 21.5065 24.0388 22.7724 22.773C24.0383 21.5071 24.7494 19.7902 24.7494 18C24.7494 16.2098 24.0383 14.4929 22.7724 13.227C21.5065 11.9612 19.7896 11.25 17.9994 11.25C16.2092 11.25 14.4923 11.9612 13.2265 13.227C11.9606 14.4929 11.2494 16.2098 11.2494 18C11.2494 19.7902 11.9606 21.5071 13.2265 22.773C14.4923 24.0388 16.2092 24.75 17.9994 24.75V24.75Z' fill-rule='evenodd' fill='#FFAD33'></path>
                          </svg>
                        </span>
                        <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.defence'>
                          <span class='text-2xl relative z-10 text-blue'>{{ card.defence }}</span>
                          <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                          </svg>
                        </div>
                        <span class='flex gap-1 items-center absolute top-2 right-3' v-if='card.durability'>
                          <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                          </svg>
                          <span class='text-md relative mt-px'>{{ card.durability }}</span>
                        </span>
                        <span class='flex gap-2 items-center' v-if='card.value'>
                          <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                            <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                          </svg>
                          <span class='text-2xl'>{{card.value}}</span>
                        </span>
                        <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.dataAmount'>
                          <span class='text-2xl relative z-10 text-blue'>{{ card.dataAmount }}</span>
                          <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                          </svg>
                        </div>
                        <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if="card.attack &amp;&amp; card.type != 'enemy'">
                          <span class='text-2xl relative z-10 text-white'>{{ card.attack }}</span>
                          <svg class='absolute' fill='none' height='51' viewbox='0 0 50 51' width='50' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                          </svg>
                        </div>
                      </div>
                      <h2 class='text-xl text-center w-full mt-3 px-4'>{{card.name}}</h2>
                      <h2 class='text-sm text-center w-full mt-2 px-4 text-description'>{{card.description}}</h2>
                      <span class='flex gap-3 items-center spin mt-2 absolute bottom-3 w-fit' style='left: 18px;' v-if="card.type == 'relic' &amp;&amp; card.affects">
                        <div class='flex items-center gap-1' v-if="card.affectGroup == 'offensiveCards'">
                          <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                          </svg>
                          <span class='relative top-px'>{{ offensiveCards[card.affects].durability + player.boosts[offensiveCards[card.affects].name + 'Durability'] }}</span>
                        </div>
                        <div class='flex items-center gap-2' v-if="card.affectGroup == 'offensiveCards'">
                          <svg fill='none' height='12' style='position: relative;left: 3px;top: -1px;' viewbox='0 0 50 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                          </svg>
                          <span class='relative top-px'>{{ offensiveCards[card.affects].attack + player.boosts[offensiveCards[card.affects].name] }}</span>
                        </div>
                        <div class='flex items-center gap-2' v-if="card.affectGroup == 'healthCards'">
                          <svg fill='none' height='12' viewbox='0 0 36 36' width='12' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                            <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                          </svg>
                          <span class='relative top-px'>{{ healthCards[card.affects].value + player.boosts[healthCards[card.affects].name] }}</span>
                        </div>
                        <div class='flex items-center gap-2' v-if="card.affectGroup == 'defensiveCards'">
                          <svg fill='none' height='12' viewbox='0 0 44 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                          </svg>
                          <span class='relative top-px'>{{ defensiveCards[card.affects].defence + player.boosts[defensiveCards[card.affects].name] }}</span>
                        </div>
                      </span>
                      <button @click="dungeonDeck[index].take('field', index)" class='absolute inset-0' v-if="card.durability || card.defence || card.value || card.type == 'mine'"></button>
                      <button @click='dungeonDeck[index].interact(player.hand[0].attack)' class='absolute inset-0' v-if="card.type == 'enemy'"></button>
                      <div @click="dungeonDeck[index].leave('field', index)" class='eject bg-blue rounded-md text-center flex w-8 h-8 items-center justify-center absolute bottom-3 right-3' v-if="card.durability || card.defence || card.value || card.type == 'relic' || card.type == 'mine'">
                        <svg fill='none' height='9' viewbox='0 0 9 9' width='9' xmlns='http://www.w3.org/2000/svg'>
                          <path clip-rule='evenodd' d='M3.11401 4.38879L0 1.35236L1.3866 0L4.5 3.03687L7.6134 0L9 1.35236L5.88599 4.38879L6 4.5L5.88599 4.61121L9 7.64764L7.6134 9L4.5 5.96313L1.3866 9L0 7.64764L3.11401 4.61121L3 4.5L3.11401 4.38879Z' fill-rule='evenodd' fill='white'></path>
                        </svg>
                      </div>
                      <button @click='dungeonDeck[index].interact(index)' class='absolute inset-0' v-if="!card.durability &amp;&amp; !card.defence &amp;&amp; !card.value &amp;&amp; !card.health &amp;&amp; card.type != 'mine'"></button>
                    </div>
                  
                  </div>


                  <div :class='`card--${card.drop.type}`' :data-accepts='card.type' :data-index='index' @mouseenter="enJin.audioController.play('cardHover')" class='card relative droppable flex flex-col items-center justify-center' v-if='dungeonDeck[index].drop?.active &amp;&amp; !card.active'>
                    <div class='flex gap-4 justify-center items-center'>
                      <svg fill='none' height='52' v-if="card.drop.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                        <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
                      </svg>
                      <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.drop.amount'>
                        <span class='text-2xl relative z-10 text-blue'>{{ card.drop.amount }}</span>
                        <svg class='absolute' fill='none' height='52' viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                        </svg>
                      </div>
                      <svg fill='none' height='52' v-if="card.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                        <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
                      </svg>
                      <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.drop.defence'>
                        <span class='text-2xl relative z-10 text-blue'>{{ card.drop.defence }}</span>
                        <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                        </svg>
                      </div>
                      <span class='flex gap-2 items-center spin' v-if="card.drop.type == 'relic'">
                        <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
                          <path clip-rule='evenodd' d='M21.3519 2.6325C20.4969 -0.8775 15.5019 -0.8775 14.6469 2.6325C14.5193 3.15994 14.2689 3.64978 13.9162 4.06217C13.5635 4.47457 13.1184 4.79786 12.6171 5.00573C12.1158 5.21361 11.5726 5.3002 11.0315 5.25845C10.4904 5.21671 9.96689 5.04781 9.50344 4.7655C6.41644 2.8845 2.88394 6.417 4.76494 9.504C5.97994 11.4975 4.90219 14.0985 2.63419 14.6497C-0.878062 15.5025 -0.878062 20.4998 2.63419 21.3503C3.16176 21.4781 3.6517 21.7287 4.06409 22.0817C4.47648 22.4347 4.79967 22.8801 5.00735 23.3816C5.21503 23.8831 5.30132 24.4266 5.25919 24.9678C5.21707 25.509 5.04772 26.0326 4.76494 26.496C2.88394 29.583 6.41644 33.1155 9.50344 31.2345C9.9668 30.9517 10.4904 30.7824 11.0316 30.7402C11.5728 30.6981 12.1163 30.7844 12.6178 30.9921C13.1194 31.1998 13.5648 31.523 13.9178 31.9354C14.2708 32.3477 14.5214 32.8377 14.6492 33.3653C15.5019 36.8775 20.4992 36.8775 21.3497 33.3653C21.4779 32.838 21.7288 32.3484 22.0819 31.9362C22.4349 31.5241 22.8802 31.2011 23.3816 30.9935C23.883 30.7859 24.4263 30.6995 24.9674 30.7414C25.5084 30.7833 26.032 30.9522 26.4954 31.2345C29.5824 33.1155 33.1149 29.583 31.2339 26.496C30.9517 26.0325 30.7827 25.509 30.7408 24.9679C30.699 24.4269 30.7854 23.8836 30.993 23.3822C31.2006 22.8808 31.5236 22.4355 31.9357 22.0824C32.3478 21.7293 32.8374 21.4785 33.3647 21.3503C36.8769 20.4975 36.8769 15.5002 33.3647 14.6497C32.8371 14.5219 32.3472 14.2713 31.9348 13.9183C31.5224 13.5653 31.1992 13.1199 30.9915 12.6184C30.7838 12.1169 30.6976 11.5734 30.7397 11.0322C30.7818 10.491 30.9512 9.96736 31.2339 9.504C33.1149 6.417 29.5824 2.8845 26.4954 4.7655C26.0321 5.04828 25.5085 5.21763 24.9673 5.25976C24.4261 5.30188 23.8826 5.21559 23.381 5.00791C22.8795 4.80024 22.4341 4.47704 22.0811 4.06465C21.7281 3.65226 21.4775 3.16233 21.3497 2.63475L21.3519 2.6325ZM17.9994 24.75C19.7896 24.75 21.5065 24.0388 22.7724 22.773C24.0383 21.5071 24.7494 19.7902 24.7494 18C24.7494 16.2098 24.0383 14.4929 22.7724 13.227C21.5065 11.9612 19.7896 11.25 17.9994 11.25C16.2092 11.25 14.4923 11.9612 13.2265 13.227C11.9606 14.4929 11.2494 16.2098 11.2494 18C11.2494 19.7902 11.9606 21.5071 13.2265 22.773C14.4923 24.0388 16.2092 24.75 17.9994 24.75V24.75Z' fill-rule='evenodd' fill='#FFAD33'></path>
                        </svg>
                      </span>
                      <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.drop.attack'>
                        <span class='text-2xl relative z-10 text-white'>{{ card.drop.attack }}</span>
                        <svg class='absolute' fill='none' height='51' viewbox='0 0 50 51' width='50' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                        </svg>
                      </div>
                      <span class='flex gap-1 items-center absolute top-2 right-3' v-if='card.drop.durability'>
                        <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                        </svg>
                        <span class='text-md relative mt-px'>{{ card.drop.durability }}</span>
                      </span>
                      <span class='flex gap-2 items-center' v-if='card.drop.value'>
                        <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                          <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                        </svg>
                        <span class='text-2xl'>{{card.drop.value}}</span>
                      </span>
                    </div>
                    <h2 class='text-xl text-center w-full mt-3 px-4'>{{card.drop.name}}</h2>
                    <h2 class='text-sm text-center w-full mt-2 px-4 text-description'>{{card.drop.description}}</h2>
                    <span class='flex gap-3 items-center spin mt-2 absolute bottom-3 w-fit' style='left: 18px;' v-if="card.drop.type == 'relic' &amp;&amp; card.drop.affects">
                      <div class='flex items-center gap-1' v-if="card.drop.affectGroup == 'offensiveCards'">
                        <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                        </svg>
                        <span class='relative top-px'>{{ offensiveCards[card.drop.affects].durability + player.boosts[offensiveCards[card.drop.affects].name + 'Durability'] }}</span>
                      </div>
                      <div class='flex items-center gap-2' v-if="card.drop.affectGroup == 'offensiveCards'">
                        <svg fill='none' height='12' style='position: relative;left: 3px;top: -1px;' viewbox='0 0 50 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                        </svg>
                        <span class='relative top-px'>{{ offensiveCards[card.drop.affects].attack + player.boosts[offensiveCards[card.drop.affects].name] }}</span>
                      </div>
                      <div class='flex items-center gap-2' v-if="card.drop.affectGroup == 'healthCards'">
                        <svg fill='none' height='12' viewbox='0 0 36 36' width='12' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                          <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                        </svg>
                        <span class='relative top-px'>{{ healthCards[card.drop.affects].value + player.boosts[healthCards[card.drop.affects].name] }}</span>
                      </div>
                      <div class='flex items-center gap-2' v-if="card.drop.affectGroup == 'defensiveCards'">
                        <svg fill='none' height='12' viewbox='0 0 44 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                          <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                        </svg>
                        <span class='relative top-px'>{{ defensiveCards[card.drop.affects].defence + player.boosts[defensiveCards[card.drop.affects].name] }}</span>
                      </div>
                    </span>
                    <button @click='dungeonDeck[index].drop.interact(index)' class='absolute inset-0' v-if="card.drop.amount || card.drop.type == 'relic' || card.drop.type == 'mine'"></button>
                    <button @click="dungeonDeck[index].drop.take('drop', index)" class='absolute inset-0' v-if="card.drop.type == 'offensive' || card.drop.type == 'defensive' || card.drop.type == 'mine' || card.drop.type == 'healing'"></button>
                    <button @click="dungeonDeck[index].drop.leave('drop', index)" class='eject bg-blue rounded-md text-center flex w-8 h-8 items-center justify-center absolute bottom-3 right-3' v-if="card.drop.type == 'mine' || card.drop.type == 'relic' || card.drop.type == 'offensive' || card.drop.type == 'defensive' || card.drop.type == 'healing'">
                      <svg fill='none' height='9' viewbox='0 0 9 9' width='9' xmlns='http://www.w3.org/2000/svg'>
                        <path clip-rule='evenodd' d='M3.11401 4.38879L0 1.35236L1.3866 0L4.5 3.03687L7.6134 0L9 1.35236L5.88599 4.38879L6 4.5L5.88599 4.61121L9 7.64764L7.6134 9L4.5 5.96313L1.3866 9L0 7.64764L3.11401 4.61121L3 4.5L3.11401 4.38879Z' fill-rule='evenodd' fill='white'></path>
                      </svg>
                    </button>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class='game_stage__bottom pt-24 relative'>
        <h4 class='text-2xl mb-8 text-red-600 absolute top-12 deckLimit' v-if='player.maxHandWarning'>Колода переполнена!</h4>
        <div class='flex justify-between w-full gap-8'>
          <div class='w-full'>
            <div class='gsc_hand flex flex-col'>
              <div class='flex items-center gap-3 mb-6'>
                <h4 class='text-md text-white' style="width: 11rem;">
                  Техническая колода
                </h4>
                <div class='h-px w-full bg-grey'></div>
                <div class='text-white flex w-12 items-end justify-end'>
                  <span class='text-2xl'>{{ player.hand.length }}</span>
                  <span class='text-lightgrey text-md'>/{{ player.maxInventory }}</span>
                </div>
              </div>
              <div class='flex gap-4'>
                <div :class='`card--${card.type}`' :data-index='index' @mouseenter="enJin.audioController.play('cardHover')" class='card draggable flex items-center flex-col justify-center' v-for='(card, index) in player.hand'>
                  <div class='trimWrap'>
                    <svg class='absolute left-0 top-0' fill='none' height='215' v-if="card.type == 'mine'" viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                      <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / 1) * 1)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#E5FF44' width='133' x='1' y='1'></rect>
                    </svg>
                    <svg class='absolute left-0 top-0' fill='none' height='215' v-if='card.defence' viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                      <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / card.maxDefence) * card.defence)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#00D1FF' width='133' x='1' y='1'></rect>
                    </svg>
                    <svg class='absolute left-0 top-0' fill='none' height='215' v-if='card.attack' viewbox='0 0 135 215' width='135' xmlns='http://www.w3.org/2000/svg'>
                      <rect :stroke-dasharray='673' :stroke-dashoffset='673 - ((673 / card.maxDurability) * card.durability)' class='transition-all duration-300' height='213' rx='11' stroke-linecap='round' stroke-width='2' stroke='#8256FF' width='133' x='1' y='1'></rect>
                    </svg>
                  </div>
                  <div class='flex gap-4 justify-center items-center'>
                    <svg fill='none' height='52' v-if="card.type == 'mine'" viewbox='0 0 52 52' width='52' xmlns='http://www.w3.org/2000/svg'>
                      <path d='M22.2416 1.48711C23.194 0.534917 24.4857 0 25.8324 0C27.1792 0 28.4709 0.534917 29.4233 1.48711L50.1778 22.2416C51.13 23.194 51.6649 24.4857 51.6649 25.8324C51.6649 27.1792 51.13 28.4709 50.1778 29.4233L29.4233 50.1778C28.4709 51.13 27.1792 51.6649 25.8324 51.6649C24.4857 51.6649 23.194 51.13 22.2416 50.1778L1.48711 29.4233C0.534917 28.4709 0 27.1792 0 25.8324C0 24.4857 0.534917 23.194 1.48711 22.2416L22.2416 1.48711V1.48711Z' fill='#E5FF44'></path>
                      <path d='M25.9998 34.6666V17.3333M18.4165 27.0833L25.9998 34.6666L33.5832 27.0833' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' stroke='#061B20'></path>
                    </svg>
                    <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.defence'>
                      <span class='text-2xl relative z-10 text-blue'>{{ card.defence }}</span>
                      <svg class='absolute' fill='none' height='51' viewbox='0 0 44 51' width='44' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                      </svg>
                    </div>
                    <div class='relative flex items-center justify-center w-12 h-12 mb-2' v-if='card.attack'>
                      <span class='text-2xl relative z-10 text-white'>{{ card.attack }}</span>
                      <svg class='absolute' fill='none' height='51' viewbox='0 0 50 51' width='50' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                      </svg>
                    </div>
                    <span class='flex gap-1 items-center absolute top-2 right-3' v-if='card.durability'>
                      <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                      </svg>
                      <span class='text-md relative mt-px'>{{ card.durability < 500 ? card.durability : '∞'}}</span>
                    </span>
                    <span class='flex gap-2 items-center' v-if='card.value'>
                      <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='20' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                        <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                      </svg>
                      <span class='text-2xl'>{{card.value}}</span>
                    </span>
                  </div>
                  <h2 class='text-xl text-center w-full mt-3 px-4'>{{card.name}}</h2>
                  <h2 class='text-sm text-center w-full mt-2 px-4 text-description'>{{card.description}}</h2>
                  <span class='flex gap-3 items-center spin mt-2 absolute bottom-3' v-if="card.type == 'relic' &amp;&amp; card.affects">
                    <div class='flex items-center gap-1' v-if="card.affectGroup == 'offensiveCards'">
                      <svg fill='none' height='12' viewbox='0 0 12 12' width='12' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M11.9839 1.25836C11.9835 1.20862 11.9697 1.15992 11.9439 1.11758C11.9181 1.07523 11.8813 1.04087 11.8375 1.01823C11.7937 0.995596 11.7446 0.985556 11.6955 0.989209C11.6465 0.992861 11.5994 1.01007 11.5593 1.03895L10.5048 1.80358L10.4218 1.86386C9.28549 0.717269 7.72591 0 5.9976 0C3.64093 0 1.58407 1.31936 0.508449 3.26539L0.512707 3.26772C0.465073 3.37092 0.457375 3.48841 0.49113 3.59706C0.524885 3.70571 0.597646 3.79764 0.695082 3.85474L2.13847 4.69741C2.18985 4.72746 2.24659 4.74698 2.30544 4.75484C2.36429 4.7627 2.42409 4.75875 2.48143 4.74322C2.53876 4.72769 2.59251 4.70088 2.6396 4.66433C2.68669 4.62778 2.72619 4.58221 2.75584 4.53021C2.75691 4.52823 2.75744 4.52608 2.7585 4.52411C3.39557 3.37518 4.61028 2.59602 6.0031 2.59602C6.86867 2.59602 7.66222 2.90029 8.29414 3.40335L8.11656 3.53235L7.06134 4.29698C7.02148 4.32609 6.99031 4.36573 6.97123 4.41156C6.95216 4.45739 6.94591 4.50764 6.95318 4.55682C6.96046 4.606 6.98096 4.65221 7.01246 4.69039C7.04396 4.72857 7.08523 4.75725 7.13177 4.7733L11.6462 6.32858C11.6866 6.34239 11.7296 6.34627 11.7717 6.3399C11.8139 6.33353 11.8539 6.3171 11.8884 6.29196C11.923 6.26683 11.9512 6.23371 11.9706 6.19537C11.99 6.15703 12.0001 6.11456 12 6.07149L11.9839 1.25836V1.25836ZM11.3053 8.14544L11.3049 8.14526L9.86153 7.30258C9.81015 7.27253 9.75341 7.25302 9.69456 7.24516C9.63571 7.2373 9.57591 7.24125 9.51857 7.25678C9.46123 7.27231 9.40749 7.29912 9.3604 7.33567C9.31331 7.37222 9.27381 7.41779 9.24416 7.46979C9.24309 7.47177 9.24256 7.47392 9.2415 7.47589C8.60443 8.62482 7.38972 9.40398 5.99689 9.40398C5.13133 9.40398 4.33778 9.09971 3.70586 8.59665L3.88344 8.46765L4.93866 7.70302C4.97852 7.67391 5.00969 7.63427 5.02877 7.58844C5.04784 7.54261 5.05409 7.49236 5.04682 7.44318C5.03954 7.394 5.01904 7.3478 4.98754 7.30961C4.95604 7.27143 4.91477 7.24275 4.86823 7.2267L0.35375 5.67142C0.313408 5.65761 0.270392 5.65373 0.22827 5.6601C0.186149 5.66647 0.146136 5.6829 0.111551 5.70804C0.0769659 5.73317 0.0488054 5.76629 0.0294054 5.80463C0.0100054 5.84297 -7.49101e-05 5.88544 4.19108e-07 5.92851L0.0163217 10.7416C0.0166362 10.7914 0.0304509 10.8401 0.0562594 10.8824C0.0820678 10.9248 0.118879 10.9591 0.162677 10.9818C0.206476 11.0044 0.25558 11.0144 0.304635 11.0108C0.353689 11.0071 0.400809 10.9899 0.440857 10.9611L1.49537 10.1964L1.57839 10.1361C2.71468 11.2827 4.27427 12 6.00257 12C8.35925 12 10.4161 10.6806 11.4917 8.73461L11.4873 8.73246C11.535 8.62931 11.5427 8.51184 11.509 8.4032C11.4753 8.29456 11.4026 8.2026 11.3053 8.14544V8.14544Z' fill='#8256FF'></path>
                      </svg>
                      <span class='relative top-px'>{{ offensiveCards[card.affects].durability + player.boosts[offensiveCards[card.affects].name + 'Durability'] }}</span>
                    </div>
                    <div class='flex items-center gap-2' v-if="card.affectGroup == 'offensiveCards'">
                      <svg fill='none' height='12' style='position: relative;left: 3px;top: -1px;' viewbox='0 0 50 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M25 -1.09278e-06L2.77826e-06 23.7109L9 23.7109L9 51L41 51L41 23.7109L50 23.7109L25 -1.09278e-06Z' fill='#8256FF'></path>
                      </svg>
                      <span class='relative top-px'>{{ offensiveCards[card.affects].attack + player.boosts[offensiveCards[card.affects].name] }}</span>
                    </div>
                    <div class='flex items-center gap-2' v-if="card.affectGroup == 'healthCards'">
                      <svg fill='none' height='12' viewbox='0 0 36 36' width='12' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M13 12H23V24H13V12Z' fill='#00FFC2'></path>
                        <path d='M32.4 7.2C32.4 5.2146 30.7854 3.6 28.8 3.6H25.2V0H21.6V3.6H14.4V0H10.8V3.6H7.2C5.2146 3.6 3.6 5.2146 3.6 7.2V10.8H0V14.4H3.6V21.6H0V25.2H3.6V28.8C3.6 30.7854 5.2146 32.4 7.2 32.4H10.8V36H14.4V32.4H21.6V36H25.2V32.4H28.8C30.7854 32.4 32.4 30.7854 32.4 28.8V25.2H36V21.6H32.4V14.4H36V10.8H32.4V7.2ZM7.2 28.8V7.2H28.8L28.8036 28.8H7.2Z' fill='#00FFC2'></path>
                      </svg>
                      <span class='relative top-px'>{{ healthCards[card.affects].value + player.boosts[healthCards[card.affects].name] }}</span>
                    </div>
                    <div class='flex items-center gap-2' v-if="card.affectGroup == 'defensiveCards'">
                      <svg fill='none' height='12' viewbox='0 0 44 51' width='12' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M42.8214 9.11818C39.2605 8.18351 35.7817 6.969 32.4186 5.48636C29.1098 4.07477 25.9157 2.41629 22.8643 0.525455L22 0L21.1514 0.540909C18.1 2.43175 14.9059 4.09022 11.5971 5.50182C8.22846 6.97996 4.74437 8.18931 1.17857 9.11818L0 9.41182V22.3009C0 42.9945 21.2614 50.7373 21.4657 50.8145L22 51L22.5343 50.8145C22.7543 50.8145 44 43.01 44 22.3009V9.41182L42.8214 9.11818Z' fill='#00D1FF'></path>
                      </svg>
                      <span class='relative top-px'>{{ defensiveCards[card.affects].defence + player.boosts[defensiveCards[card.affects].name] }}</span>
                    </div>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class='gsc_trash'>
            <h4 class='text-md mb-8 text-white mt-2'>Форматирование</h4>
            <div class='card card--format slot droppable' data-accepts='any'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div :class="{'min': !game.upgradesMinimized, 'active': !game.mainMenu}" class='game_stage__relics text-center'>
    <div @click='game.upgradesMinimized = !game.upgradesMinimized' class='relics_minimize uppercase text-white' style="zoom: 80%;">
      <span style="font-size: small;">Улучшения</span>
      <span class='relicCount'>{{ player.collectedRelics.length }}</span>
    </div>
    <h4 class='text-2xl mb-8 text-white' style="zoom: 80%;">
      Ваши собранные улучшения
    </h4>
    <h3 class='text-white text-md' v-if='player.listedRelics.length == 0'>Собранных улучшений пока нет.</h3>
    <div class='gap-8 grid grid-cols-8' style="zoom: 65%;">
      <div :data-index='index' class='relic flex gap-2 items-start' v-for='(card, index) in player.listedRelics'>
        <svg class='h-6' fill='none' height='36' viewbox='0 0 36 36' width='36' xmlns='http://www.w3.org/2000/svg'>
          <path clip-rule='evenodd' d='M21.3519 2.6325C20.4969 -0.8775 15.5019 -0.8775 14.6469 2.6325C14.5193 3.15994 14.2689 3.64978 13.9162 4.06217C13.5635 4.47457 13.1184 4.79786 12.6171 5.00573C12.1158 5.21361 11.5726 5.3002 11.0315 5.25845C10.4904 5.21671 9.96689 5.04781 9.50344 4.7655C6.41644 2.8845 2.88394 6.417 4.76494 9.504C5.97994 11.4975 4.90219 14.0985 2.63419 14.6497C-0.878062 15.5025 -0.878062 20.4998 2.63419 21.3503C3.16176 21.4781 3.6517 21.7287 4.06409 22.0817C4.47648 22.4347 4.79967 22.8801 5.00735 23.3816C5.21503 23.8831 5.30132 24.4266 5.25919 24.9678C5.21707 25.509 5.04772 26.0326 4.76494 26.496C2.88394 29.583 6.41644 33.1155 9.50344 31.2345C9.9668 30.9517 10.4904 30.7824 11.0316 30.7402C11.5728 30.6981 12.1163 30.7844 12.6178 30.9921C13.1194 31.1998 13.5648 31.523 13.9178 31.9354C14.2708 32.3477 14.5214 32.8377 14.6492 33.3653C15.5019 36.8775 20.4992 36.8775 21.3497 33.3653C21.4779 32.838 21.7288 32.3484 22.0819 31.9362C22.4349 31.5241 22.8802 31.2011 23.3816 30.9935C23.883 30.7859 24.4263 30.6995 24.9674 30.7414C25.5084 30.7833 26.032 30.9522 26.4954 31.2345C29.5824 33.1155 33.1149 29.583 31.2339 26.496C30.9517 26.0325 30.7827 25.509 30.7408 24.9679C30.699 24.4269 30.7854 23.8836 30.993 23.3822C31.2006 22.8808 31.5236 22.4355 31.9357 22.0824C32.3478 21.7293 32.8374 21.4785 33.3647 21.3503C36.8769 20.4975 36.8769 15.5002 33.3647 14.6497C32.8371 14.5219 32.3472 14.2713 31.9348 13.9183C31.5224 13.5653 31.1992 13.1199 30.9915 12.6184C30.7838 12.1169 30.6976 11.5734 30.7397 11.0322C30.7818 10.491 30.9512 9.96736 31.2339 9.504C33.1149 6.417 29.5824 2.8845 26.4954 4.7655C26.0321 5.04828 25.5085 5.21763 24.9673 5.25976C24.4261 5.30188 23.8826 5.21559 23.381 5.00791C22.8795 4.80024 22.4341 4.47704 22.0811 4.06465C21.7281 3.65226 21.4775 3.16233 21.3497 2.63475L21.3519 2.6325ZM17.9994 24.75C19.7896 24.75 21.5065 24.0388 22.7724 22.773C24.0383 21.5071 24.7494 19.7902 24.7494 18C24.7494 16.2098 24.0383 14.4929 22.7724 13.227C21.5065 11.9612 19.7896 11.25 17.9994 11.25C16.2092 11.25 14.4923 11.9612 13.2265 13.227C11.9606 14.4929 11.2494 16.2098 11.2494 18C11.2494 19.7902 11.9606 21.5071 13.2265 22.773C14.4923 24.0388 16.2092 24.75 17.9994 24.75V24.75Z' fill-rule='evenodd' fill='#FFAD33'></path>
        </svg>
        <div class='text-left relative'>
          <h2 class='text-white text-lg mb-1'>{{ card.name }}</h2>
          <h2 class='text-description'>{{ card.description }}</h2>
          <span class='count' v-if='card.count &gt; 1'>x{{card.count}}</span>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
<script src='https://codepen.io/jcoulterdesign/pen/rNWRyqz/e54f657bdb261a60a06bdf7c59e08eca.js'></script>
<script src='https://codepen.io/jcoulterdesign/pen/eYBXvPR/be0cddc1cbd7659676aed48b97afd57d.js'></script>
<script src='https://codepen.io/jcoulterdesign/pen/LYbaWJr/70920fa4550ed45e7c1ff28b643b6969.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/seedrandom/3.0.5/seedrandom.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/utils/Draggable.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.1/TweenMax.min.js'></script>
<script src='items.js'></script><script src="./script.js"></script>
<script>
    const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;

    if (windowWidth < 1300 || windowHeight < 700) {
        const scaleFactor = Math.min(windowWidth / 1300, windowHeight / 700) - 0.05;
        const gameContainer = document.getElementById('game-container');
        gameContainer.style = "-webkit-transform-origin-x: left;";
        gameContainer.style.transform = `scale(${scaleFactor})`;
    }
  </script>
</body>
</html>
