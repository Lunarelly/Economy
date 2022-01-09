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

class SeeMoneyCommand extends Command implements PluginIdentifiableCommand {

    public function __construct(EconomyMain $main) {
        $this->main = $main;
        $this->setDescription("See player's money");
        $this->setPermission("economy.command.seemoney");
        $this->setUsage("Usage: /seemoney <player>");
        $this->aliases = ["checkmoney"];
        parent::__construct("seemoney", $this->description, $this->usageMessage, $this->aliases);
    }

    public function execute(CommandSender $sender, $alias, array $args) {
        if(!($this->testPermission($sender))) {
            return false;
        }
        if(empty($args)) {
            return $sender->sendMessage($this->usageMessage);
        }
        $player = Server::getInstance()->getPlayer($args[0]);
        if(!($player == null)) {
            $name = $player->getName();
            $money = $this->main->getMoney($name);
            $sender->sendMessage(str_replace(["{MONEY}", "{PLAYER}"], [$money, $name], $this->main->getConfig()->getNested("messages.seemoney-success")));
        } else {
            $name = $args[0];
            $money = $this->main->getMoney($name);
            $sender->sendMessage(str_replace(["{MONEY}", "{PLAYER}"], [$money, $name], $this->main->getConfig()->getNested("messages.seemoney-success")));
        }
        return true;
    }

    public function getPlugin() {
        return $this->main;
    }
}