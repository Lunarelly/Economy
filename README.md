# Economy

## Description
### Cool and easy to use economy plugin
- API: 2.0.0
- Plugin version: 1.0.0
- Default money value on first join: 1000 (can be changed in config.yml)

## Commands & settings
- Plugin can be set up in config.yml
- Commands: /addmoney, /mymoney, /paymoney, /reducemoney, /seemoney, /setmoney

## API
- Example (you can find all api functions in EconomyMain.php)
```php
# $player has Player instance
$economy = Server::getInstance()->getPluginManager()->getPlugin("Economy");

# This function will add 1000 coins to player
$economy->addMoney($player->getName(), 1000);

# This function will reduce 1000 coins from player
$economy->reduceMoney($player->getName(), 1000);

# This function will set player's balance to 1000
$economy->setMoney($player->getName(), 1000);

# This function will return player's balance
$economy->getMoney($player->getName()); # 1000
```

## Contacts
- Author: Lunarelly
- Discord: Lunarelly#6954
- Telegram: https://t.me/lunarellyy
- VK: https://vk.com/lunarelly
