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

namespace economy\command;

use pocketmine\command\{
    Command,
    CommandSender,
    PluginIdentifiableCommand
};
use pocketmine\{
    Player,
    Server
};
use economy\EconomyMain;

use function str_replace;

class MyMoneyCommand extends Command implements PluginIdentifiableCommand {

    public function __construct(EconomyMain $main) {
        $this->main = $main;
        $this->setDescription("Your money");
        $this->setPermission("economy.command.mymoney");
        $this->setUsage("Usage: /mymoney");
        $this->aliases = ["money", "balance"];
        parent::__construct("mymoney", $this->description, $this->usageMessage, $this->aliases);
    }

    public function execute(CommandSender $sender, $alias, array $args) {
        if(!($sender instanceof Player)) {
            return $sender->sendMessage("Only in-game!");
        }
        if(!($this->testPermission($sender))) {
            return false;
        }
        $name = $sender->getName();
        $money = $this->main->getMoney($name);
        $sender->sendMessage(str_replace("{MONEY}", $money, $this->main->getConfig()->getNested("messages.mymoney-success")));
        return true;
    }

    public function getPlugin() {
        return $this->main;
    }
}