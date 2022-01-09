<?php

/*
 *  _							    _ _	   
 * | |   _   _ _ __   __ _ _ __ ___| | |_   _ 
 * | |  | | | | '_ \ / _` | '__/ _ \ | | | | |
 * | |__| |_| | | | | (_| | | |  __/ | | |_| |
 * |_____\__,_|_| |_|\__,_|_|  \___|_|_|\__, |
 *									    |___/ 
 * 
 * Author: Lunarelly
 * 
 * GitHub: https://github.com/Lunarelly
 * 
 * Telegram: https://t.me/lunarellyy
 * 
 */

namespace economy\event;

use pocketmine\event\{
    Listener,
    player\PlayerJoinEvent
};
use economy\EconomyMain;

class DefaultMoneyListener implements Listener {

    public function __construct(EconomyMain $main) {
        $this->main = $main;
    }

    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $name = $player->getName();
        if($this->main->isNewPlayer($name) == true) {
            $value = $this->main->getConfig()->getNested("default-money");
            $this->main->setMoney($name, $value);
        }
    }
}