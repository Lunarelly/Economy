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
use pocketmine\Server;
use economy\EconomyMain;

use function str_replace;

class SetMoneyCommand extends Command implements PluginIdentifiableCommand {

    public function __construct(EconomyMain $main) {
        $this->main = $main;
        $this->setDescription("Set player's money");
        $this->setPermission("economy.command.setmoney");
        $this->setUsage("Usage: /setmoney <player> <money>");
        $this->aliases = ["setbalance"];
        parent::__construct("setmoney", $this->description, $this->usageMessage, $this->aliases);
    }

    public function execute(CommandSender $sender, $alias, array $args) {
        if(!($this->testPermission($sender))) {
            return false;
        }
        if(empty($args) or !(isset($args[0])) or !(isset($args[1])) or !(is_numeric($args[1]))) {
            return $sender->sendMessage($this->usageMessage);
        }
        $player = Server::getInstance()->getPlayer($args[0]);
        $value = $args[1];
        if($value <= 0) {
            return $sender->sendMessage($this->main->getConfig()->getNested("messages.incorrect-value"));
        }
        if(!($player == null)) {
            $name = $player->getName();
            $this->main->setMoney($name, $value);
            $sender->sendMessage(str_replace(["{MONEY}", "{PLAYER}"], [$value, $name], $this->main->getConfig()->getNested("messages.setmoney-success")));
            $player->sendMessage(str_replace(["{MONEY}", "{SENDER}"], [$value, $sender->getName()], $this->main->getConfig()->getNested("messages.setmoney-player")));
        } else {
            $name = $args[0];
            $this->main->setMoney($name, $value);
            $sender->sendMessage(str_replace(["{MONEY}", "{PLAYER}"], [$value, $name], $this->main->getConfig()->getNested("messages.setmoney-success")));
        }
        return true;
    }

    public function getPlugin() {
        return $this->main;
    }
}