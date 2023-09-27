// Initialise EnJin
const enJin = new EnJin();

// Audio and game data here https://codepen.io/jcoulterdesign/pen/zYRVpdw/4285e883d66c684da9d3bf3ed140cef7

// Add enJin modules
enJin.add('audio');
enJin.add('utilities');

var params = window
    .location
    .search
    .replace('?','')
    .split('&')
    .reduce(
        function(p,e){
            var a = e.split('=');
            p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
            return p;
        },
        {}
    );

// Set a default game seed
enJin.utils.setSeed(params['group_id']);

// Load the audio array into the audio controller module
enJin.audioController.load(_masterAudio);

document.addEventListener("click", function() {
    // Any processed audio needs to be initialised on user interaction
    enJin.audioController.postProcess('bgmusic');
    enJin.audioController.playPostProcessed('bgmusic')
    enJin.audioController.setFilterType('lowpass');
});

// --------------------------------------------------------------------------------
// Base player class
// --------------------------------------------------------------------------------

class Player {
    constructor(health, currency, hand) {
        this.maxHealth = health; // Max health player can have
        this.health = this.maxHealth; // Current player health init at max health (can change this depending on difficulty)
        this.currency = currency; // The players starting currency, used to purchase new cards
        this.hand = hand; // Initial players hand
        this.maxInventory = 6; // Maximum cards a player can hold at anyone time (initially)
        this.shopCardTotal = 5;
        this.shopDiscount = 0;
        this.collectedRelics = [];
        this.listedRelics = [];
        this.pickedRelics = []
        this.boosts = {
            'Brute force' : 0,
            'Data' : 0,
            'StageHeal' : 0
        };

        offensiveCards.forEach(function(c) {
            this.boosts[c.name] = 0;
            this.boosts[c.name + 'Durability'] = 0;
        }.bind(this))

        defensiveCards.forEach(function(c) {
            this.boosts[c.name] = 0;
        }.bind(this))

        healthCards.forEach(function(c) {
            this.boosts[c.name] = 0;
        }.bind(this))

        this.armour = ''; // The players defensive item
        this.position = 0; // Current position within the current level
        this.level = 1; // Starting level of the player
        this.stageComplete = false;

        // Rest stuff
        this.restHealPercentage = 25; // How much percentage you heal when you rest
        this.restMaxHealthIncrease = 5; // How much your max health increases when you choose not to rest

        // Other stuff
        this.relicsAtEndOfStage = 3; // How many random relics do we pick after ending a stage

        // Flags
        this.alive = true;
        this.attacking = false;
        this.attacked = false;
        this.shopping = false;
        this.maxHandWarning = false;
        this.resting = false;
        this.shopRelicFlag = false;
    }

    // Move function. 
    // Compliments each stage cards 'deactivate' function by increasing the position count, revealing the next card and checking if the stage has ended
    move() {
        game.showintents = true;
        this.position++; // Увеличиваем известную позицию игрока
    
        // Проверяем, существует ли следующая карта в объекте колоды подземелья
        if (!dungeonDeck[this.position]) {
            // Если больше нет карт в этом этапе...
            this.level++; // Увеличиваем текущий уровень
            this.position = 0; // Сбрасываем позицию обратно в начало
            pickRelics(this.relicsAtEndOfStage); // Выбираем 3 случайных релика
    
            // Устанавливаем этап как завершенный
            player.stageComplete = !player.stageComplete;
            enJin.audioController.play('stageComplete');
    
            player.heal(player.boosts['StageHeal']);
    
            game.completeAchievement('Это UNIX-система!');
    
            if (player.collectedRelics.length == 0) {
                game.completeAchievement('Какие улучшения?');
            }
    
            if (player.health == 1) {
                game.completeAchievement('С краю зубами');
            }
    
            if (player.health == player.maxHealth) {
                game.completeAchievement('Цифровой босс');
            }
    
            if (player.level == game.totalLevels + 1) {
                // Победитель, победитель
    
                game.won = true;
                enJin.audioController.play('intro');
    
                if (game.difficulty == 1) {
                    game.completeAchievement("Мы внутри");
                }
    
                if (game.difficulty == 2) {
                    game.completeAchievement('Я неуязвим');
                }
    
                if (game.difficulty == 3) {
                    game.completeAchievement('Здесь нет ложки');
    
                    if (enjin.utils.seedString == "SKYNET") {
                        game.completeAchievement('Предотвращено Судный день');
                    }
    
                    if (enjin.utils.seedString == "NASA") {
                        game.completeAchievement('МакКиннон будет гордиться');
                    }
    
                    if (enjin.utils.seedString == "TREADSTONE") {
                        game.completeAchievement('Рожденный для этого');
                    }
    
                    if (enjin.utils.seedString == "HAL9000") {
                        game.completeAchievement("Прошу прощения, Дейв");
                    }
                }
            }
        } else {
            // Иначе, покажем следующую карту
            dungeonDeck[this.position].revealed = true;
        }
    }
    

    // Utility function to heal player. Allows you to specify the amount as a percentage so long as percentage param = true. Rest parameter means the heal is at a rest site
    heal(amount, percentage = false, rest = false) {
        game.completeAchievement('Top up');
        enJin.audioController.play('heal'); // Play heal audio
        this.health += !percentage ? amount : Math.ceil((this.maxHealth / 100) * amount); // Add value to health
        this.health = this.health > this.maxHealth ? this.maxHealth : this.health; // Clamp health

        if(rest) { // If at a rest site.
            game.finishResting();
        }
    }

    // Utility function to adjust a players max health. Allows you to specify the amount as a percentage so long as percentage param = true. Rest parameter means the heal is at a rest site
    adjustMaxHealth(amount, percentage = false, rest = false) {
        enJin.audioController.play('heal'); // Play heal audio
        this.maxHealth += !percentage ? amount : Math.ceil((this.maxHealth / 100) * amount); // Add value to health
        this.health = this.health > this.maxHealth ? this.maxHealth : this.health; // Clamp health to max

        if(this.maxHealth >= 40) {
            game.completeAchievement('Абсолютный блок');
        }

        if(this.maxHealth >= 70) {
            game.completeAchievement('Форт Кнокс');
        }

        if(this.maxHealth <= 5) {
            game.completeAchievement('Кому нужно здоровье');
        }

        if(rest) { // If at a rest site.
            game.finishResting();
        }
    }
}

// --------------------------------------------------------------------------------
// Game class
// Contains all functions and methods related to the game
// --------------------------------------------------------------------------------

class Game {
    constructor() {
        this.lowerFrequency = 300; // Low pass frequency when in store etc
        this.defaultFrequency = 15000; // Default low pass frequency
        this.mainMenu = true;
        this.gameCreation = false;
        this.gameAchievements = false;
        this.totalLevels = 9;
        this.muted = false;
        this.init = false;
        this.shopMinimized = false;
        this.endstageMinimized = false;
        this.completedAchievementCount = 0;
        this.showintents = true;
        this.upgradesMinimized = true;
        this.difficulty = 1;
        this.won = false;
        this.tutorialProgress = 0;
        this.tutorial = true;

        if(!localStorage.achievements) {
            this.setAchievements()
        }

        if(localStorage.tutorial) {
            this.tutorial = false;
        }
    }

    tutorialDone() {
        localStorage.setItem('tutorial', false);
    }

    setAchievements() {
        let achievementsArray = [];

        achievements.forEach(function(a) {
            let ac = {
                'name' : a.name,
                'description' : a.description,
                'complete' : false
            } 
            achievementsArray.push(ac);
        })

        localStorage.setItem('achievements', JSON.stringify(achievementsArray));
    }

    updateAchievements() {
        localStorage.setItem('achievements', JSON.stringify(vm.achievements));
    }

    completeAchievement(name) {
        var targetAchievement = '';

        vm.achievements.forEach(function(a) {
            if(a.name == name) {
                if(a.complete != true) {
                    a.complete = true;

                    achievements.forEach(function(a) {
                        if(a.name == name) {
                            targetAchievement = a
                        }
                    })

                    this.updateAchievements();
                    vm.completedAchievement = targetAchievement;

                    vm.achievementEarned = true;

                    enJin.audioController.play('achievement');

                    setTimeout(function() {
                        vm.achievementEarned = false;
                    }, 3500)
                }

            }
        }.bind(this))
    }

    // Restart the game. Recreates a player, resets the vue instance and seed randoms
    restart(newgame) {
        game.mainMenu = false;
        game.won = false;
        player = new Player(20, 0, '');
        player.hand = [new EquipableCard(startingCards[0]), new HealthCard(healthCards[0]), new MineCard(), new EquipableCard(defensiveCards[1]), new EquipableCard(offensiveCards[0])];
        player.health = player.maxHealth
        player.currency = 0;
        player.progress = 0;
        player.position = 0;
        player.level = 1;
        player.alive = true;
        enJin.utils.resetSeed()
        generateDungeonDeck(16); // Generate first stage deck
        enJin.audioController.setFrequency(this.defaultFrequency); // Set music back to normal frequency
        vm.reset(); // Reset the vue instance

        // I really don't know why we need to do this...but we do
        setTimeout(function() {
            if(enJin.utils.seedString == 'CIA' || enJin.utils.seedString == 'cia') {
                game.completeAchievement('Большая шишка');
            }
        },10)

        createDraggables();
    }

    finishResting() {
        enJin.audioController.play('heal');
        enJin.audioController.setFrequency(this.defaultFrequency); // Set music back to normal frequency
        player.resting = !player.resting;
        dungeonDeck[player.position].deactivate();
        player.move();
    }
}

const game = new Game();

// ----------------------------------------
// Cards
// ----------------------------------------

// Base card class. All cards have some functions in common so all card types extend this class
class Card {
    constructor() {
        this.revealed = false;
        this.active = true;
    }

    // Deactivate the card
    deactivate() {
        this.active = false;
    }

    // Take card function. All card, with the exception of 'currencies' should be 'takeable'.
    // This means they are removed from the stage deck and placed into the players deck.
    take(from, index) {
        if(player.hand.length < player.maxInventory) { // First make sure the player has enough room in hand
            let cardContext = from == 'field' ? dungeonDeck[index] : from == 'relics' ? player.pickedRelics[index] : dungeonDeck[index].drop; // We get the card in context
            enJin.audioController.play('take');

            player.hand.push(cardContext); // Push this card to our hand
            cardContext.deactivate(); // Deactivate the current card
            createDraggables(); // Re-initialise draggable elements

            if(from == 'relics') {
                player.stageComplete = !player.stageComplete;
                generateDungeonDeck(16);
            } else {
                player.move(); // Move the player on
            }
        } else {
            showMaxHand(); // Show the max hand warning
        }
    }

    // Leave card function. All cards with the exception of 'currencies' should be 'leavable'. In other words
    // deactivate the card and do not add it to hand
    leave(from, index) {
        enJin.audioController.play('trash');
        let cardContext = from == 'field' ? dungeonDeck[index] : dungeonDeck[index].drop; // We get the card in context
        cardContext.deactivate(); // Deactivate the current card
        player.move(); // Move the player on
    }

    // Trash a card from the players hand
    trash(index) {
        enJin.audioController.play('trash');
        player.hand.splice(index, 1);
    }

    // Buy a card from the shop
    buy(index) {
        if((player.currency - this.cost) >= 0) {
            if(this.type == 'relic') {
                enJin.audioController.play('buy');
                this.deactivate(); // Deactivate this card
                player.currency -= this.cost; // Deduct the cost of this card from the players currency
                this.interact();
                game.completeAchievement('Я знаю Кунг-фу');

                this.bought = true;
            } else {
                if(player.hand.length < player.maxInventory) {
                    enJin.audioController.play('buy');
                    player.hand.push(this); // Add the card to the players hand
                    player.currency -= this.cost; // Deduct the cost of this card from the players currency
                    this.deactivate(); // Deactivate this card
                    createDraggables(); // Re-initialise draggable elements
                    game.completeAchievement('Я знаю Кунг-фу');
                    this.bought = true;
                } else {
                    enJin.audioController.play('invalid');

                    if(player.hand.length >= player.maxInventory) {
                        showMaxHand();
                    }
                }
            }
        } else {
            enJin.audioController.play('invalid');
        }
    }

    reset(index) {
        if(this.attack && this.type != 'enemy') {
            this.attack = this.baseAttack + player.boosts[this.name];

            if(this.attack >= 9) {
                game.completeAchievement('Максимальное проникновение');
            }
        }

        if(this.value && this.type != 'enemy') {
            this.value = this.baseValue + player.boosts[this.name];
        }

        if(this.defence && this.type != 'enemy') {
            let used = this.maxDefence - this.defence;
            this.defence = this.baseDefence + player.boosts[this.name] - used
            this.maxDefence = this.baseDefence + player.boosts[this.name]

            if(this.defence >= 12) {
                game.completeAchievement('Непроницаемый');
            }
        }

        if(this.durability && this.type != 'enemy') {
            let used = this.maxDurability - this.durability;
            this.durability = this.baseDurability + player.boosts[this.name + 'Durability'] - used
            this.maxDurability = this.baseDurability + player.boosts[this.name + 'Durability']
        }
    }
}

// Type classes
class EquipableCard extends Card {
    constructor(...stats) {
        super(); // Inherit methods from parent card class
        for (let [key, value] of Object.entries(stats[0])) { // Map all stats
            this[key] = value;
        }

        if(this.attack && player.boosts[this.name] != undefined) {
            this.baseAttack = this.attack;
            this.attack += player.boosts[this.name];
        }

        if(this.defence && player.boosts[this.name] != undefined) {
            this.baseDefence = this.defence;
            this.maxDefence = this.baseDefence + player.boosts[this.name];
            this.defence += player.boosts[this.name];
        }

        if(this.durability && player.boosts[this.name] != undefined) {
            this.baseDurability = this.durability;
            this.maxDurability = this.baseDurability + player.boosts[this.name + 'Durability'];
            this.durability += player.boosts[this.name + 'Durability'];
        }
    }

    equip(index) {
        let targetCard = this.type == "offensive" ? player.weapon : player.armour; // Get card type

        // If there is already a card equipped, unequip that one first
        if(targetCard) {
            targetCard.unequip(true);
        }

        player.armour = player.hand[index];
        enJin.audioController.play('defensiveEquipped');
        player.hand.splice(index, 1);
    }

    unequip(overwrite) {
        // Only unequip if there is enough space in the hand
        let overflow = overwrite ? 1 : 0;

        if(player.hand.length + 1 <= player.maxInventory + overflow) {
            let targetCard = this.type == "offensive" ? player.weapon : player.armour;

            // Update the player offensive or defensive items depending on what that selected
            player.armour = ''; // Unset

            // Push this card back into the players deck
            player.hand.push(targetCard);
            createDraggables(); // Re-initialise draggable elements
        } else {
            showMaxHand();
        }
    }

    // The generic interact action for this card (what happens when its clicked when its part of the stage deck)
    interact(index) {
        player.hand.push(dungeonDeck[index]);
    }
}

// Health cards. These cards replenish hit point to the player
class HealthCard extends Card {
    constructor(...stats) {
        super(); // Inherit methods from parent card class
        for (let [key, value] of Object.entries(stats[0])) { // Map all stats
            this[key] = value;
        }

        this.value += player.boosts[this.name];
    }

    use(index) {
        player.heal(this.value);
        player.hand.splice(index, 1);
    }
}

// Currency card. Can be exchanged for other things. In this case, data -> cards
class CurrencyCard extends Card {
    constructor(amount) {
        super(); // Inherit methods from parent card class
        this.name = 'Данные'; // The name of our currency. Globally set
        this.amount = amount; // Currency amount
        this.description = 'Нажмите, чтобы собрать. Потратьте их в Dark Web'
    }

    // Generic card interaction when in stage deck
    interact() {
        enJin.audioController.play('data');
        this.deactivate(); // Deactivate the card
        player.currency += this.amount; // Increase the players currency by amount
        player.move(); // Move the player

        if(player.currency >= 30) {
            game.completeAchievement('Гигабайт');
        }

        if(player.currency >= 100) {
            game.completeAchievement('Терабайт');
        }

        if(player.currency >= 250) {
            game.completeAchievement('Петабайт');
        }
    }
}

// Node cards. These are empty cards that serve no real purpose but pad out the stage deck
class NodeCard extends Card {
    constructor(name) {
        super(); // Inherit methods from parent card class
        this.name = name; // Location name
        this.dataAmount = enJin.utils.seedRandomBetween(6, 12);
        this.dataAmount = Math.ceil((this.dataAmount / 100) * player.boosts['Data']) + this.dataAmount;
        this.type = 'node';
        this.description = 'Используйте для этого майнер данных, чтобы извлечь данные';
    }

    interact() {
        enJin.audioController.play('node');
        this.deactivate(); // Deactivate this card
        player.move(); // Move the player
    }
}

// Node cards. These are empty cards that serve no real purpose but pad out the stage deck
class MineCard extends Card {
    constructor(name) {
        super(); // Inherit methods from parent card class
        this.name = 'Майнер данных'; // Location name
        this.type = 'mine';
        this.cost = 10;
        this.description = 'Используйте на узле, чтобы извлечь данные';
    }

    interact() {
        enJin.audioController.play('node');
        this.deactivate(); // Deactivate this card
        player.move(); // Move the player
    }

    mine(node) {
        let value = dungeonDeck[node].dataAmount;
        game.completeAchievement('Мое, все мое');
        dungeonDeck[node].interact();

        enJin.audioController.play('mine');

        player.currency += value; // Increase the players currency by amount

        if(value >= 14) {
            game.completeAchievement('Джекпот');
        }

        if(player.currency >= 30) {
            game.completeAchievement('Гигабайт');
        }

        if(player.currency >= 100) {
            game.completeAchievement('Терабайт');
        }

        if(player.currency >= 250) {
            game.completeAchievement('Петабайт');
        }
    }
}

// Relic cards.
class RelicCard extends Card {
    constructor(...stats) {
        super(); // Inherit methods from parent card class
        for (let [key, value] of Object.entries(stats[0])) { // Map all stats
            this[key] = value;
        }
    }

    // Whenever a relic is clicked on
    interact(index, end) {


        this.deactivate(); // Deactivate this card


        enJin.audioController.play('takerelic');

        // Trigger the relics effects
        this.targets.forEach(function(t, index) {
            eval(t + this.operator[index] + this.change[index]);
        }.bind(this))

        player.health = player.health > player.maxHealth ? player.maxHealth : player.health; // Clamp health

        player.collectedRelics.push(this); // Add to relic collection

        let alreadyGot = false;

        if(player.listedRelics.length == 0) {
            this.count = 1;
            player.listedRelics.push(this)
        } else {
            player.listedRelics.forEach(function (t) {
                if(this.name == t.name) {
                    alreadyGot = true
                    t.count++
                }
            }.bind(this))

            if(alreadyGot) {
                alreadyGot = false;
            } else {
                this.count = 1;
                player.listedRelics.push(this); // Add to relic collection
            }
        }

        if(this.name == "Квантовый процессор") {
            game.completeAchievement('Словарная атака');
        }

        player.hand.forEach(function(t) {
            t.reset()
        })

        if(player.shopCards) {
            player.shopCards.forEach(function(t) {
                t.reset()
            })
        }

        dungeonDeck.forEach(function(t) {
            t.reset()

            if(t.drop) {
                t.drop.reset();
            }
        })

        if(end) { 
            player.stageComplete = !player.stageComplete;
            generateDungeonDeck(16);
        } else {
            if(!player.shopping) {
                player.move(); // Move the player
            }
        }

        if(player.collectedRelics.length >= 5) {
            game.completeAchievement('Скрипт-кидди')
        }

        if(player.collectedRelics.length >= 10) {
            game.completeAchievement('Красная шапка')
        }

        if(player.collectedRelics.length >= 15) {
            game.completeAchievement('Черная шапка')
        }

        if(player.collectedRelics.length >= 20) {
            game.completeAchievement('Элитный хакер')
        }

        if(player.maxInventory >= 8) {
            game.completeAchievement('Укомплектованный')
        }
    }
}

// Shop card. Opens up the shop interface
class ShopCard extends Card {
    constructor() {
        super();
        this.name = 'Браузер Tor';
        this.description = 'Загрузка нового ПО';
    }

    openShop(index) {
        player.shopRelicFlag = false;
        enJin.audioController.setFrequency(game.lowerFrequency);
        enJin.audioController.play('openShop');
        player.shopping = !player.shopping;
        player.activeShop = index;
        pickShopCards(player.shopCardTotal);
    }

    closeShop() {
        enJin.audioController.setFrequency(game.defaultFrequency);
        player.shopping = !player.shopping;
        this.deactivate();
        player.move();
    }

    interact(index) {
        player.shopIndex = index;
        this.openShop(index);
    }
}

// Shop card. Opens up the shop interface
class RestCard extends Card {
    constructor() {
        super();
        this.name = 'Перечисление';
        this.description = 'Повышение целостности';
    }

    openRest() {
        enJin.audioController.setFrequency(game.lowerFrequency);
        enJin.audioController.play('openShop');
        player.resting = !player.resting;
    }

    interact() {
        this.openRest();
    }
}

// Enemy card
class EnemyCard extends Card {
    constructor(...stats) {
        super(); // Inherit methods from parent card class
        for (let [key, value] of Object.entries(stats[0])) { // Map all stats
            this[key] = value;
        }

        this.health = this.health + Math.floor((player.level - 1) / 2);
        this.attack = this.attack + Math.floor((player.level - 1) / 2);
        this.baseHealth = this.baseHealth + Math.floor((player.level - 1) / 2);
        this.generateDrop(); // Generate this enemies drop
    }

    // General interaction (in the stage deck)
    interact(damage) {
        damage = damage ? damage : 1; // Caluculate damage total
        player.attacking = true; // Set attacking flag
        player.attackAmount = damage;

        setTimeout(function() {
            player.attacking = false;
        }, 250)

        enJin.audioController.play('enemyHit');

        // Take damage. Check if the hit would destory the target
        if(this.health - damage > 0) {
            this.health -= damage; // Deal damage
            let _this = this; // Save context

            setTimeout(function() {
                _this.attackPlayer(_this.attack); // Fire the attack function for the enemy
            }, 250)
        } else {
            // If the target is destroyed
            game.showintents = false;
            this.deactivate(); // Deactivate this enemy
            enJin.audioController.play('enemyKilled');
            game.completeAchievement('Один меньше');

            if (this.name == "Центр данных") {
                game.completeAchievement('Сброс данных');
            }

            if (this.name == "Security beacon") {
                game.completeAchievement('Не так безопасно');
            }

            if (this.name == "Mainframe") {
                game.completeAchievement('Моё кунг-фу сильнее');
            }

            if (this.name == "Антивирус") {
                game.completeAchievement('Антивирус побежден');
            }

            if (this.name == "Брандмауэр") {
                game.completeAchievement('Сквозь огонь и пламя');
            }

            if (this.name == "Сервер") {
                game.completeAchievement('Вам подали');
            }

            if(!this.drop) { // If this enemy does not have a drop, move to next card
                player.move();
            }
        }
    }

    // Attack function
    attackPlayer(attack) {
        // Check if player has armour
        player.attacked = true; // Set attacking flag

        setTimeout(function() {
            player.attacked = false;
        }, 250)

        if(player.armour) {
            player.fleshDamage = 0;
            player.armour.defence -= attack; // Remove durability from the defensive item

            if(player.armour.defence <= 0) { // If this attack would destroy the defensive item...
                player.health -= Math.abs(player.armour.defence); // ... calculate the overflow and deduct it from the players health
                player.fleshDamage = Math.abs(player.armour.defence);
                player.armour = ''; // Remove the players defensive item
                player.shieldAmount = attack;
                enJin.audioController.play('enemyAttackShield'); // Need a broken shield sound
            } else {
                enJin.audioController.play('enemyAttackShield');
                player.shieldAmount = attack;
            }
        } else {
            enJin.audioController.play('enemyAttackFlesh');
            player.health -= attack; // No defensive item, take from health
            player.shieldAmount = 0;
            player.fleshDamage = attack;

            if(player.fleshDamage >= 10) {
                game.completeAchievement('Они следят за тобой');
            }
        }

        // Death check
        if(player.health <= 0) {
            game.completeAchievement('n00b');
            enJin.audioController.setFrequency(game.lowerFrequency);
            player.alive = false; // Set the player alive flag
        }
    }

    // Generate drops. All drop are defined using the seed and thus are predetermined when the instance of the card is created
    generateDrop() {
        let roll = enJin.utils.seedRandomBetween(1, 100); // Roll a seeded random number between 1 and 100
        dropRatios.forEach(function(ratio) {
            if(roll > ratio.lowerRange && roll < ratio.upperRange) {
                let type = ratio.name;

                this.drop = getCardByType(type);
            }
        }.bind(this))
    }
}

function getCardByType(type, cardPool) {
    let card;

    if(type == "offensive") { card = new EquipableCard(enJin.utils.seedRandomInArray(offensiveCards));}
    if(type == "defensive") { card = new EquipableCard(enJin.utils.seedRandomInArray(defensiveCards));}
    if(type == "enemy") { card = new EnemyCard(enJin.utils.seedRandomInArray(enemies));}
    if(type == "healing") { card = new HealthCard(enJin.utils.seedRandomInArray(healthCards));}
    if(type == "currency") { card = new CurrencyCard(enJin.utils.seedRandomBetween(1, 5));}
    if(type == "relic") { card = new RelicCard(enJin.utils.seedRandomInArray(relicCards));}
    if(type == "mine") { card = new MineCard(); }
    if(type == "node") { card = new NodeCard(enJin.utils.seedRandomInArray(nodeCards).name); }
    if(type == "mine") { card = new MineCard();}

    if(!type) {
        if(cardPool == "shop") { card = new ShopCard();} 
        else if(cardPool == "mine") { card = new MineCard();} 
        else if(cardPool == "rest") { card = new RestCard();} 
        else { card = new CurrencyCard(enJin.utils.seedRandomBetween(1, 5));}
    }

    return card;
}

// Create the player
var player = new Player(20, 0, '');

// Create a starting hand
const startingDeck = [new EquipableCard(startingCards[0]), new HealthCard(healthCards[0]), new MineCard(), new EquipableCard(defensiveCards[1]), new EquipableCard(offensiveCards[0])];

player.hand = startingDeck;

function showMaxHand() {
    enJin.audioController.play('invalid');
    player.maxHandWarning = true;

    setTimeout(function() {
        player.maxHandWarning = false;
    }, 2000)
}

// ----------------------------------------
// Ratio tables
// ----------------------------------------

// Function to generate ratio ranges for a ratio table and push to an array.
// All of our drops, stages and shop cards are seeded random, but we want some to be more common than other. By creating a ratio table
// we can roll a random number and check which range it falls in. The wider the range, the more likely it will be 'chosen'

function generateRatios(ratioTable, target) {
    let runningTotal = 0;

    ratioTable.forEach(function(e) {
        let ratioBand = {
            name: Object.keys(e)[0], // Ratio band name
            lowerRange: runningTotal, // Lower range
            upperRange: runningTotal + Object.values(e)[0] // Upper range
        }

        runningTotal = runningTotal + Object.values(e)[0] + 1; // Update running total
        target.push(ratioBand); // Push band to target
    })
}

// Ratio tables
var dropTable;

if(game.difficulty == 1) {
    dropTable = [{ offensive: 10 }, { defensive: 10 }, { healing: 12 }, { currency: 24 }, { relic: 8 }, {mine: 15}]; // Drop ratios for enemies
}

if(game.difficulty == 2) {
    dropTable = [{ offensive: 8 }, { defensive: 8 }, { healing: 10 }, { currency: 20 }, { relic: 5 }, {mine: 11}]; // Drop ratios for enemies
}

if(game.difficulty == 3) {
    dropTable = [{ offensive: 6 }, { defensive: 6 }, { healing: 8 }, { currency: 15 }, { relic: 3 }, {mine: 7}]; // Drop ratios for enemies
}

let dropRatios = [];
generateRatios(dropTable, dropRatios); // Generate ratio bands

const shopTable = [{ offensive: 10 }, { defensive: 10 }, { healing: 15 }, { relic: 65 }]; // Shop pick table. Should alway be 100 total otherwise some will be blank
let shopRatios = [];
generateRatios(shopTable, shopRatios); // Generate ratio bands

function pickRelics(amount) {
    player.pickedRelics = [];

    for(i = 0; i < amount; i++) {
        let roll = enJin.utils.seedRandomBetween(1, 100); // Select seeded random number between 1 and 100
        // Now check which ratio band our random number is in
        shopRatios.forEach(function(ratio) {
            if(roll >= ratio.lowerRange && roll <= ratio.upperRange) {
                let type = ratio.name;
                let card = getCardByType(type);

                card.cost = Math.ceil(card.cost - ((card.cost / 100) * player.shopDiscount));
                // Add this card to the shops array
                player.pickedRelics.push(card);
            }
        }.bind(this))
    }
}

// ----------------------------------------
// Shop card selection
// ----------------------------------------

// function to select the desired amount of cards and put them into the shop interface. Uses the shop ratios
function pickShopCards(amount) {

    // First clear the shop cards array
    player.shopCards = [];

    // Now loop through the desired amount
    for(i = 0; i < amount; i++) {
        let roll = enJin.utils.seedRandomBetween(1, 100); // Select seeded random number between 1 and 100
        // Now check which ratio band our random number is in
        shopRatios.forEach(function(ratio) {
            if(roll >= ratio.lowerRange && roll <= ratio.upperRange) {
                let type = ratio.name;
                let card = getCardByType(type);

                card.cost = Math.ceil(card.cost - ((card.cost / 100) * player.shopDiscount));
                // Add this card to the shops array
                player.shopCards.push(card);
            }
        }.bind(this))
    }
}

// ----------------------------------------
// Stage deck generation
// ----------------------------------------

// Generate dungeon deck
let dungeonDeck = []; // Create a blank array for the deck

// Deck generation requires a little more flexibility than complete randomness like the enemy drops.
// for our deck creation we specify a minimum and maximum of a card type (this can be a percentage or an int), then when all cards are added, we top up with
// node cards and add in a boss if needed

function selectCards(min, max, cardPool) {
    // First select a random amount of the card from this card pool
    let roll = enJin.utils.seedRandomBetween(min, max); // Random roll

    // Now select that many cards
    for(i = 0; i < roll; i++) {
        // Select a random card type from the enemies pool
        let type = cardPool[0].type;
        let selectedCard;

        selectedCard = getCardByType(type, cardPool);

        // Add the card to the dungeon deck
        dungeonDeck.push(selectedCard);
    }
}

function generateDungeonDeck(size) {
    dungeonDeck = []; // Clear the current deck

    selectCards(1, 1, offensiveCards); // Offensive
    selectCards(1, 1, defensiveCards); // Defensive
    selectCards(1, 2, 'shop'); // Shop

    if(game.difficulty == 1) {
        selectCards(0, 2, relicCards); // Shop
        selectCards(1, 1, 'rest'); // Shop
        selectCards(1, 3, 'currency'); // Data
        selectCards(2, 4, enemies); // Enemies
        selectCards(1, 2, 'mine'); // Shop
    }

    if(game.difficulty == 2) {
        selectCards(0, 1, relicCards); // Shop
        selectCards(1, 1, 'rest'); // Shop
        selectCards(1, 2, 'currency'); // Data
        selectCards(2, 5, enemies); // Enemies
        selectCards(0, 1, 'mine'); // Shop
    }

    if(game.difficulty == 3) {
        selectCards(0, 0, relicCards); // Shop
        selectCards(0, 1, 'rest'); // Shop
        selectCards(0, 2, 'currency'); // Data
        selectCards(3, 5, enemies); // Enemies
        selectCards(0, 1, 'mine'); // Shop
    }

    selectCards(size - dungeonDeck.length, size - dungeonDeck.length, nodeCards); // Locations

    // Shuffle the deck
    for(i = 0; i < 15; i++) {
        dungeonDeck = dungeonDeck.map(value => ({ value, sort: enJin.utils.seedRandomBetween(1000, 100000)})).sort((a, b) => a.sort - b.sort).map(({ value }) => value);
    }

    if(dungeonDeck[dungeonDeck.length - 1].name == 'Tor Browser') {
        dungeonDeck.splice(dungeonDeck.length - 1, 1)
        dungeonDeck.unshift(new ShopCard())
    }

    if(player.level == 1) {
        dungeonDeck.unshift(new EnemyCard(enemies[0]));
    }

    // Set first card to revealed
    dungeonDeck[0].revealed = true;

    if(player.level % 3 == 0) {
        // Select a random card type from the enemies pool
        let card = new EnemyCard(enJin.utils.seedRandomInArray(bosses));

        // Add the card to the dungeon deck
        dungeonDeck.push(card);
    }

    // Reset the vm instance
    if(player.level > 1) {
        vm.reset(); 
    }
}

// Generate the first stage deck
generateDungeonDeck(16);

// Vue instance
vm = new Vue({
    el: '.game',

    data() {
        return {
            player: player,
            playersTurn: true,
            dungeonDeck: dungeonDeck,
            game: game,
            seed: enJin.utils.seedString,
            achievements: JSON.parse(localStorage.getItem('achievements')),
            completedAchievement: '',
            achievementEarned: false,
        }
    },

    methods: {
        // Reset data object. Used when updating the seed to re-evaluate all random properties using seed
        reset() {
            Object.assign(this.$data, this.$options.data.call(this));
        },
        updateDungeonDeck(newDeck) {
            this.dungeonDeck = newDeck;
          },
        getAchievementCount() {
            let completed = 0;
            this.achievements.forEach(function(a) {
                if(a.complete) {
                    completed++;
                }
            })

            return completed;
        }
    }
});

var droppables = document.getElementsByClassName('droppable');
var overlapThreshold = '10%';

function onDrop(dragged, dropped) {
    let index = dragged.dataset.index;
    let cardType = player.hand[index].type;
    let accepts = dropped.dataset.accepts;


    if(cardType ==  accepts) {

        if(cardType == 'healing') {
            player.hand[index].use(index);
        }

        if(cardType == 'defensive') {
            player.hand[index].equip(index);
        }
    }

    if(cardType == 'offensive' && accepts == 'enemy' || cardType == 'offensive' && accepts == 'boss') {
        if(dungeonDeck[dropped?.dataset?.id].revealed) {
            if(!player.shopping) {
                let attack = player.hand[index].attack;
                let id = dropped.dataset.id;
                let playedCard = player.hand[index];
                dungeonDeck[id]?.interact(attack);
                playedCard.durability--;

                if(playedCard.durability <= 0) {
                    player.hand.splice(index, 1);
                } 
            }
        }
    }

    if(cardType == 'mine' && accepts == 'node') {
        if(dungeonDeck[dropped?.dataset?.id].revealed) {
            player.hand[index].mine(dropped.dataset.id);
            player.hand.splice(index, 1);
        }
    }

    if(accepts ==  'any') {
        if(player.hand[index].name != 'Brute force') {
            enJin.audioController.play('trash');
            player.hand.splice(index, 1);
        } else {
            enJin.audioController.play('invalid');
        }
    }
}

function createDraggables() {
    setTimeout(function() {
        Draggable.create(".draggable", {
            edgeResistance:0.80,
            bounds: ".game",
            onDragEnd: function(e) {
                var i = droppables.length;
                while (--i > -1) {
                    if (this.hitTest(droppables[i], overlapThreshold)) {
                        onDrop(this.target, droppables[i]);
                    } else {
                        TweenLite.to(this.target, 0.001, {
                            x: 0, y: 0
                        });
                    }
                }
            }
        });
    }, 240);
}

createDraggables();

// ----------------------------------------
// Online sync mode | Unesell Studio
// ----------------------------------------

// player & game sycn

// Преобразование game и player в JSON

var gameJSON, playerJSON, dungeonDeckJSON;

// Переменные для хранения предыдущих данных
let prevGameJSON = JSON.stringify(game);
let prevPlayerJSON = JSON.stringify(player);
let prevdungeonDeckJSON = JSON.stringify(dungeonDeck);

// Устанавливаем интервал для отправки данных на сервер каждые 100 миллисекунд
setInterval(updateDataServer, 100);

// Устанавливаем интервал для получения данных с сервера каждые 1000 миллисекунд
setInterval(getDataServer, 500);

function updateDataServer(){
    gameJSON = JSON.stringify(game);
    playerJSON = JSON.stringify(player);
    dungeonDeckJSON = JSON.stringify(dungeonDeck);

    // Проверяем, изменились ли данные
    if (gameJSON !== prevGameJSON || playerJSON !== prevPlayerJSON ) {
        fetch('online/save_game.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ room: params['group_id'], game: gameJSON, player: playerJSON, dungeonDeck: dungeonDeckJSON}),
        })
        .then(response => response.json())
        .then(data => {
            //console.log('Данные успешно сохранены на сервере.', data);
        })
        .catch(error => {
            console.error('Произошла ошибка при сохранении данных на сервере:', error);
        });

        // Обновляем предыдущие данные
        prevGameJSON = gameJSON;
        prevPlayerJSON = playerJSON;
        prevdungeonDeckJSON = dungeonDeckJSON;
    }
}

let prevServerGameJSON = null;
let prevServerPlayerJSON = null;
let prevServerDungeonDeckJSON = null;

// Функция для преобразования данных о картах из JSON в экземпляры классов
function mapCardDataToInstances(cardDataArray) {
    return cardDataArray.map(cardData => {
        var card;
        if (cardData.type) {
            const cardType = cardData.type || "currency";
            switch (cardType) {
                case "offensive":
                    card = new EquipableCard(cardData);
                    if ('attack' in cardData) { card.attack = cardData.attack; }
                    break;
                case "defensive":
                    card = new EquipableCard(cardData);
                    break;
                case "enemy":
                    card = new EnemyCard(cardData);
                    break;
                case "healing":
                    card = new HealthCard(cardData);
                    break;
                case "currency":
                    card = new CurrencyCard(cardData);
                    break;
                case "relic":
                    card = new RelicCard(cardData);
                    break;
                case "mine":
                    card = new MineCard(cardData);
                    break;
                case "node":
                    card = new NodeCard(cardData);
                    card.name = "Терминал";
                    break;
                default:
                    card = new EquipableCard(cardData);
            }
        } else {
            if (cardData.name === "Перечисление") {
                card = new RestCard(cardData);
            } else if (cardData.name === "Данные") {
                card = new CurrencyCard(cardData);
            } else if (cardData.name === "Браузер Tor") {
                card = new ShopCard(cardData);
            } else {
                card = new Card(cardData);
            }
        }

        // Присвоение значений если они есть в JSON
        if ('revealed' in cardData) {
            card.revealed = cardData.revealed;
        }
        if ('active' in cardData) {
            card.active = cardData.active;
        }
        if ('drop' in cardData) {
            card.drop = mapCardDataToInstances([cardData.drop])[0];
        }
        if (typeof cardData.amount === 'object' && 'amount' in cardData.amount && cardData.name == "Данные") {
            card.amount = Math.floor(Math.random() * (12 - 4 + 1)) + 4;
        } else {
            card.amount = cardData.amount;
        }

        return card;
    });
}


function getDataServer() {
    const group_id = params['group_id'];

    fetch(`online/get_game.php?group_id=${group_id}`)
        .then(response => response.json())
        .then(data => {
            if ('game' in data && 'player' in data) {
                const serverGameJSON = data.game;
                const serverPlayerJSON = data.player;
                const serverDungeonDeckJSON = data.dungeonDeck;

                // Проверяем, изменились ли данные на сервере
                if (serverGameJSON !== prevServerGameJSON || serverPlayerJSON !== prevServerPlayerJSON || serverDungeonDeckJSON !== prevServerDungeonDeckJSON) {
                    // Применяем полученные данные к объектам game и player только при изменениях
                    const gameData = JSON.parse(serverGameJSON);
                    const playerData = JSON.parse(serverPlayerJSON);
                    const dungeonDeckData = JSON.parse(serverDungeonDeckJSON);

                    playerData.hand = mapCardDataToInstances(playerData.hand);
                    if(playerData.armour) { playerData.armour = new EquipableCard(playerData.armour); }
                    if(playerData.shopCards){ playerData.shopCards = mapCardDataToInstances(playerData.shopCards); }
                    playerData.pickedRelics = mapCardDataToInstances(playerData.pickedRelics);
                    playerData.listedRelics = mapCardDataToInstances(playerData.listedRelics);
                    playerData.collectedRelics = mapCardDataToInstances(playerData.collectedRelics);
                    
                    // Применяем полученные данные к объектам game и player
                    Object.assign(game, gameData);
                    Object.assign(player, playerData);

                    dungeonDeck.length = 0; // Очищаем текущий массив
                    dungeonDeck.push(...mapCardDataToInstances(dungeonDeckData));

                    vm.updateDungeonDeck(dungeonDeck);

                    // Обновляем предыдущие данные с сервера
                    prevServerGameJSON = serverGameJSON;
                    prevServerPlayerJSON = serverPlayerJSON;
                    prevServerDungeonDeckJSON = serverDungeonDeckJSON;
                }
            } else {
                updateDataServer();
                //console.error('Данные отсутствуют или имеют неверный формат.');
            }
        })
        .catch(error => {
            console.error('Произошла ошибка при получении данных с сервера:', error);
        });
}

// Начальная инициализация функций
getDataServer();