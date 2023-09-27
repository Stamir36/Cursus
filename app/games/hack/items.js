// Offensive items set
// An object containing all of our offensive equippable cards for our various function to pull from
// Master audio array.
const _masterAudio = [
    {
      'name': 'bgmusic',
      'source': 'https://assets.codepen.io/217233/hackbgsoundtrack.mp3',
      'stack': 1 },
    {
      'name': 'heal',
      'source': 'https://assets.codepen.io/217233/hackHealFX.wav' },
    {
      'name': 'invalid',
      'source': 'https://assets.codepen.io/217233/hackErrorFX.wav',
      'stack': 4 },
    {
      'name': 'stageComplete',
      'source': 'https://assets.codepen.io/217233/hackStageCompleteFX.mp3' },
    {
      'name': 'cardHover',
      'source': 'https://assets.codepen.io/217233/hackCardHoverFX.wav',
      'stack': 5 },
    {
      'name': 'enemyKilled',
      'source': 'https://assets.codepen.io/217233/hackEnemyDeadFX.wav' },
    {
      'name': 'defensiveEquipped',
      'source': 'https://assets.codepen.io/217233/hackDefensiveEquipped.mp3' },
    {
      'name': 'enemyHit',
      'source': 'https://assets.codepen.io/217233/hackEnemyHitFX.mp3',
      'stack': 4 },
    {
      'name': 'node',
      'source': 'https://assets.codepen.io/217233/hackNodeFX.wav',
      'stack': 2 },
    {
      'name': 'data',
      'source': 'https://assets.codepen.io/217233/hackDataFX.mp3',
      'stack': 3 },
    {
      'name': 'buy',
      'source': 'https://assets.codepen.io/217233/hackBuyFX.mp3',
      'stack': 2 },
    {
      'name': 'openShop',
      'source': 'https://assets.codepen.io/217233/hackOpenShopFX.mp3' },
    {
      'name': 'take',
      'source': 'https://assets.codepen.io/217233/hackTakeFX.mp3',
      'stack': 6 },
    {
      'name': 'trash',
      'source': 'https://assets.codepen.io/217233/hackTrashFX.mp3',
      'stack': 2 },
    {
      'name': 'enemyAttackFlesh',
      'source': 'https://assets.codepen.io/217233/hackEnemyAttackFX.mp3',
      'stack': 3 },
    {
      'name': 'enemyAttackShield',
      'source': 'https://assets.codepen.io/217233/hackEnemyAttackShieldFX_1.wav',
      'stack': 3 },
    {
      'name': 'achievement',
      'source': 'https://assets.codepen.io/217233/hack--achievementsfx.mp3' },
    {
      'name': 'mine',
      'source': 'https://assets.codepen.io/217233/hack--dataminingsfx.wav',
      'stack': 2 },
    {
      'name': 'intro',
      'source': 'https://assets.codepen.io/217233/hack--intro.mp3' },
    {
      'name': 'takerelic',
      'source': 'https://assets.codepen.io/217233/hack--takerelicsfx.wav' }];
    
const offensiveCards = [
    {
      name: 'DDoS',
      baseAttack: 3,
      attack: 3,
      durability: 2,
      cost: 12,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' },
    
    
    {
      name: 'Червь',
      baseAttack: 4,
      attack: 4,
      durability: 2,
      cost: 18,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' },
    
    {
      name: 'Rootkit',
      baseAttack: 5,
      attack: 5,
      durability: 1,
      cost: 12,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' },
    
    {
      name: 'RAT',
      baseAttack: 6,
      attack: 6,
      durability: 1,
      cost: 15,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' },
    
    {
      name: 'Вирус',
      baseAttack: 5,
      attack: 5,
      durability: 2,
      cost: 23,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' }];
    
    // Defensive items set
    // An object containing all of our defensive equippable cards for our various function to pull from
    
const defensiveCards = [
    {
      name: 'Shell',
      defence: 2,
      cost: 8,
      type: 'defensive',
      description: 'Блокирование входящих атак' },
    
    {
      name: 'Прокси',
      defence: 4,
      cost: 12,
      type: 'defensive',
      description: 'Блокирование входящих атак' },
    
    {
      name: 'Spoofer',
      defence: 6,
      cost: 18,
      type: 'defensive',
      description: 'Блокирование входящих атак' },
    
    {
      name: 'Cloak',
      defence: 8,
      cost: 25,
      type: 'defensive',
      description: 'Блокирование входящих атак' }];
 
    // Defensive items set
    // An object containing all of our defensive equippable cards for our various function to pull from
    
const healthCards = [
    {
      name: 'Defrag',
      value: 3,
      baseValue: 3,
      cost: 4,
      type: 'healing',
      description: 'Пополнение очков целостности' },
    
    {
      name: 'Recompile',
      value: 6,
      baseValue: 6,
      cost: 8,
      type: 'healing',
      description: 'Пополнение очков целостности' },
    
    {
      name: 'Debug',
      value: 8,
      baseValue: 8,
      cost: 10,
      type: 'healing',
      description: 'Пополнение очков целостности' }];

    
    // Locations set
    // An object containing all of our non interactive locations or 'nodes'
    
    const nodeCards = [
        {
          name: 'Почтовый аккаунт',
          type: 'node'
        },
        {
          name: 'Сетевой коммутатор',
          type: 'node'
        },
        {
          name: 'FTP-сервер',
          type: 'node'
        },
        {
          name: 'Веб-сервер',
          type: 'node'
        },
        {
          name: 'Сеть хранения',
          type: 'node'
        },
        {
          name: 'Кэш',
          type: 'node'
        },
        {
          name: 'Банковский аккаунт',
          type: 'node'
        },
        {
          name: 'Файловая система',
          type: 'node'
        },
        {
          name: 'Точка доступа',
          type: 'node'
        },
        {
          name: 'Почтовый сервер',
          type: 'node'
        },
        {
          name: 'Терминал',
          type: 'node'
        },
        {
          name: 'Криптокошелек',
          type: 'node'
        }
    ];
    
    // Enemies set
    // An object containing all of our games enemies and their base stats
    
    const enemies = [
        {
          name: 'Шлюз',
          health: 2,
          baseHealth: 2,
          attack: 1,
          type: 'enemy',
          description: 'Взломайте этот узел, для продолжения'
        },
        {
          name: 'Маршрутизатор',
          health: 4,
          baseHealth: 4,
          attack: 2,
          type: 'enemy',
          description: 'Взломайте этот узел, для продолжения'
        },
        {
          name: 'База данных',
          health: 5,
          baseHealth: 5,
          attack: 1,
          type: 'enemy',
          description: 'Взломайте этот узел, для продолжения'
        },
        {
          name: 'Виртуальная машина',
          health: 2,
          baseHealth: 2,
          attack: 6,
          type: 'enemy',
          description: 'Взломайте этот узел, для продолжения'
        },
        {
          name: 'SDL',
          health: 4,
          baseHealth: 4,
          attack: 3,
          type: 'enemy',
          description: 'Взломайте этот узел, для продолжения'
        }
    ];    
    
    // Boss set
    // An object containing all of our games bosses
    
    const bosses = [
    {
      name: 'Центр данных',
      health: 14,
      attack: 3,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Security beacon',
      health: 12,
      attack: 5,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Mainframe',
      health: 10,
      attack: 6,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Антивирус',
      health: 8,
      attack: 8,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Брандмауэр',
      health: 4,
      attack: 15,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Сервер',
      health: 20,
      attack: 2,
      type: 'enemy',
      description: 'Взломайте, для завершения' },
    
    {
      name: 'Подсеть',
      health: 9,
      attack: 4,
      type: 'enemy',
      description: 'Взломайте, для завершения' }
    ];
    
    // Relic set
    // An object containing all of our games relics and their effects
    
    const relicCards = [
        {
          name: 'Модуль ОЗУ',
          type: 'relic',
          description: 'Увеличивает вместимость технологической колоды на 1',
          targets: ['player.maxInventory'],
          operator: ['+='],
          change: [1],
          cost: 12
        },
        {
          name: 'Задержка соединения',
          type: 'relic',
          description: 'Увеличивает максимальное здоровье на 5',
          targets: ['player.maxHealth'],
          operator: ['+='],
          change: [5],
          cost: 15
        },
        {
          name: 'Премиум прокси',
          type: 'relic',
          description: 'Увеличивает максимальное здоровье на 10',
          targets: ['player.maxHealth'],
          operator: ['+='],
          change: [10],
          cost: 25
        },
        {
          name: 'Утечка данных',
          type: 'relic',
          description: '1 дополнительный выбор в магазинах',
          targets: ['player.shopCardTotal'],
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Репутация хакера',
          type: 'relic',
          description: 'Скидка в магазинах 10%',
          targets: ['player.shopDiscount'],
          operator: ['+='],
          change: [10],
          cost: 25
        },
        {
          name: 'Жесткий сброс',
          type: 'relic',
          description: 'Полное восстановление вашего здоровья',
          targets: ['player.health'],
          operator: ['+='],
          change: [1000],
          cost: 12
        },
        {
          name: 'Фильтр-кофе',
          type: 'relic',
          description: 'Увеличивает скорость восстановления здоровья на 5%',
          targets: ['player.restHealPercentage'],
          operator: ['+='],
          change: [5],
          cost: 12
        },
        {
          name: 'Доп. процессор',
          type: 'relic',
          description: 'Получите дополнительно 2 максимальных очка здоровья при укреплении',
          targets: ['player.restMaxHealthIncrease'],
          operator: ['+='],
          change: [2],
          cost: 10
        },
        {
          name: 'Сниффер пакетов',
          type: 'relic',
          description: 'Потеряйте 10 единиц здоровья, получите 20 единиц данных',
          targets: ['player.health', 'player.currency'],
          operator: ['-=', '+='],
          change: [10, 20],
          cost: 5
        },
        {
          name: 'NMAP',
          type: 'relic',
          description: 'Потеряйте 5 максимальных единиц здоровья, получите 15 единиц данных',
          targets: ['player.maxHealth', 'player.currency'],
          operator: ['-=', '+='],
          change: [5, 15],
          cost: 5
        },
        {
          name: 'Квантовый процессор',
          type: 'relic',
          description: 'Потеряйте 15 единиц максимального здоровья, увеличьте урон от грубой силы на 1',
          targets: ['player.boosts["Грубая сила"]', 'player.maxHealth'],
          operator: ['+=', '-='],
          change: [1, 15],
          cost: 25
        },
        {
          name: 'Ещё серверы!',
          type: 'relic',
          description: 'DDoS имеет +1 защиту',
          targets: ['player.boosts["DDoS"]'],
          affects: 0,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Червь AI',
          type: 'relic',
          description: 'Черви дают +1 защиту',
          targets: ['player.boosts["Червь"]'],
          affects: 1,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Новые rootkit-ы',
          type: 'relic',
          description: 'Rootkit-ы дают +1 защиту',
          targets: ['player.boosts["Rootkit"]'],
          operator: ['+='],
          affectGroup: "offensiveCards",
          affects: 2,
          change: [1],
          cost: 15
        },
        {
          name: 'Удаленное обходное устройство',
          type: 'relic',
          description: 'RAT имеет +1 защиту',
          targets: ['player.boosts["RAT"]'],
          affects: 3,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Авто скрытие',
          type: 'relic',
          description: 'Вирусы дают +1 защиту',
          targets: ['player.boosts["Вирус"]'],
          affects: 4,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Атаки YO-YO',
          type: 'relic',
          description: 'DDoS имеет +1 использование',
          targets: ['player.boosts["Прочность DDoS"]'],
          affects: 0,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Продвинутая репликация',
          type: 'relic',
          description: 'Черви дают +1 использование',
          targets: ['player.boosts["Прочность Червя"]'],
          affects: 1,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Rootkit+1',
          type: 'relic',
          description: 'Rootkit-ы дают +1 использование',
          targets: ['player.boosts["Прочность Rootkit"]'],
          affects: 2,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Возможности антидетекции',
          type: 'relic',
          description: 'RAT имеет +1 использование',
          targets: ['player.boosts["Прочность RAT"]'],
          affects: 3,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Глубокая вставка',
          type: 'relic',
          description: 'Вирусы дают +1 использование',
          targets: ['player.boosts["Прочность Вируса"]'],
          affects: 4,
          affectGroup: "offensiveCards",
          operator: ['+='],
          change: [1],
          cost: 15
        },
        {
          name: 'Удаленный терминал',
          type: 'relic',
          description: 'Оболочки имеют +2 защиту',
          targets: ['player.boosts["Оболочка"]'],
          operator: ['+='],
          affects: 0,
          affectGroup: "defensiveCards",
          change: [2],
          cost: 15
        },
        {
          name: 'Авто вращение',
          type: 'relic',
          description: 'Прокси имеют +2 защиту',
          targets: ['player.boosts["Прокси"]'],
          affects: 1,
          affectGroup: "defensiveCards",
          operator: ['+='],
          change: [2],
          cost: 15
        },
        {
          name: 'Загрузка аппаратных средств',
          type: 'relic',
          description: 'Спуферы имеют +2 защиту',
          targets: ['player.boosts["Спуфер"]'],
          operator: ['+='],
          affects: 2,
          affectGroup: "defensiveCards",
          change: [2],
          cost: 15
        },
        {
          name: 'Маскировка',
          type: 'relic',
          description: 'Маски имеют +2 защиту',
          targets: ['player.boosts["Маска"]'],
          operator: ['+='],
          affects: 3,
          affectGroup: "defensiveCards",
          change: [2],
          cost: 15
        },
        {
          name: 'NVMes',
          type: 'relic',
          description: 'Дефрагментация восстанавливает +2 больше целостности',
          targets: ['player.boosts["Дефрагментация"]'],
          affects: 0,
          affectGroup: "healthCards",
          operator: ['+='],
          change: [2],
          cost: 15
        },
        {
          name: 'Distcc',
          type: 'relic',
          description: 'Перекомпиляция восстанавливает +2 больше целостности',
          targets: ['player.boosts["Перекомпиляция"]'],
          affects: 1,
          affectGroup: "healthCards",
          operator: ['+='],
          change: [2],
          cost: 15
        },
        {
          name: 'Продвинутые среды разработки',
          type: 'relic',
          description: 'Отладка восстанавливает +2 больше целостности',
          targets: ['player.boosts["Отладка"]'],
          affects: 2,
          affectGroup: "healthCards",
          operator: ['+='],
          change: [2],
          cost: 15
        },
        {
          name: 'Выборочные цели',
          type: 'relic',
          description: 'Узлы содержат на 10% больше данных',
          targets: ['player.boosts["Данные"]'],
          operator: ['+='],
          change: [10],
          cost: 15
        },
        {
          name: 'Регенерация',
          type: 'relic',
          description: 'В конце каждого этапа восстанавливайте 2 целостности',
          targets: ['player.boosts["Лечение этапа"]'],
          operator: ['+='],
          change: [2],
          cost: 15
        }
    ];    
    
    const startingCards = [
    {
      name: 'Грубая сила',
      attack: 1,
      baseAttack: 1,
      durability: 999999,
      cost: 0,
      type: 'offensive',
      description: 'Снижение устойчивости шлюза' }
    ];
    
    const achievements = [
        {
          name: 'Максимальное проникновение',
          description: 'Достигните уровня проникновения 9 или более у любой программы'
        },
        {
          name: 'Большая шишка',
          description: 'Попытка взлома ЦРУ'
        },
        {
          name: 'Скрипт-кидди',
          description: 'Соберите 5 улучшений за одну игру'
        },
        {
          name: 'Красная шапка',
          description: 'Соберите 10 улучшений за одну игру'
        },
        {
          name: 'Черная шапка',
          description: 'Соберите 15 улучшений за одну игру'
        },
        {
          name: 'Элитный хакер',
          description: 'Соберите 20 улучшений за одну игру'
        },
        {
          name: 'Непроницаемый',
          description: 'Достигните уровня сопротивления 12 или более у любого модуля брандмауэра'
        },
        {
          name: 'Гигабайт',
          description: 'Соберите 30 или более данных'
        },
        {
          name: 'Терабайт',
          description: 'Соберите 100 или более данных'
        },
        {
          name: 'Петабайт',
          description: 'Соберите 150 или более данных'
        },
        {
          name: 'Мое, все мое',
          description: 'Добыть сетевой узел'
        },
        {
          name: 'Один ниже',
          description: 'Завершить узел'
        },
        {
          name: 'Top up',
          description: 'Исцелите себя'
        },
        {
          name: 'n00b',
          description: 'Быть обнаруженным'
        },
        {
          name: 'Это UNIX-система!',
          description: 'Завершить уровень'
        },
        {
          name: 'Какие улучшения?',
          description: 'Завершить уровень без улучшений'
        },
        {
          name: 'Джекпот',
          description: 'Добыть узел, стоимость которого составляет 14 или более данных'
        },
        {
          name: 'Укомплектованный',
          description: 'Иметь максимальную вместимость технологической колоды 8 или более'
        },
        {
          name: 'Сброс данных',
          description: 'Взломать Центр обработки данных'
        },
        {
          name: 'Не так безопасно',
          description: 'Взломать Безопасный маяк'
        },
        {
          name: 'Мой кунг-фу сильнее',
          description: 'Взломать Основной фрейм'
        },
        {
          name: 'Антивирус побежден',
          description: 'Взломать Антивирус'
        },
        {
          name: 'Сквозь огонь и пламя',
          description: 'Взломать Брандмауэр'
        },
        {
          name: 'Вы обслужены',
          description: 'Взломать Сервер'
        },
        {
          name: 'Пустяки',
          description: 'Взломать Подсеть'
        },
        {
          name: 'Мы внутри',
          description: 'Успешно взломать цель с низким уровнем сложности'
        },
        {
          name: 'Я неуязвим',
          description: 'Успешно взломать цель с средним уровнем сложности'
        },
        {
          name: 'Здесь нет ложки',
          description: 'Успешно взломать цель с высоким уровнем сложности'
        },
        {
          name: 'Я знаю Кунг-фу',
          description: 'Загрузить что-то из "Dark Web"'
        },
        {
          name: 'Словарная атака',
          description: 'Увеличьте своё проникновение с помощью грубой силы'
        },
        {
          name: 'Абсолютный блок',
          description: 'Иметь максимальное здоровье 40 или более'
        },
        {
          name: 'Форт Нокс',
          description: 'Иметь максимальное здоровье 70 или более'
        },
        {
          name: 'Они следят за тобой',
          description: 'Получите более 10 урона за один удар'
        },
        {
          name: 'По краю',
          description: 'Завершите уровень с 1 оставшимся единицей целостности'
        },
        {
          name: 'Цифровой босс',
          description: 'Завершите уровень с полной целостностью'
        },
        {
          name: 'Кому нужно здоровье',
          description: 'Уменьшите максимальную целостность до 5 или менее'
        },
        {
          name: 'МакКиннон будет гордиться',
          description: 'Успешно взломать NASA на сложном уровне'
        },
        {
          name: 'Рожденный для этого',
          description: 'Успешно взломать TREADSTONE на сложном уровне'
        },
        {
          name: 'Предотвратили Судный день',
          description: 'Успешно взломать SKYNET на сложном уровне'
        },
        {
          name: 'Прошу прощения, Дейв',
          description: 'Успешно взломать HAL9000 на сложном уровне'
        }
    ];
    