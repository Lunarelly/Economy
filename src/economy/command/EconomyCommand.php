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
use economy\EconomyMain;

use function in_array;

class EconomyCommand extends Command implements PluginIdentifiableCommand {

    public function __construct(EconomyMain $main) {
        $this->main = $main;
        $this->setDescription("Main economy command");
        $this->setPermission("economy.command.default");
        $this->setUsage("Usage: /economy <help|info>");
        $this->aliases = ["eco"];
        parent::__construct("economy", $this->description, $this->usageMessage, $this->aliases);
    }

    public function execute(CommandSender $sender, $alias, array $args) {
        if(!($this->testPermission($sender))) {
            return false;
        }
        $subcommands = ["help", "info"];
        if(empty($args) or !(in_array($args[0], $subcommands))) {
            return $sender->sendMessage($this->usageMessage);
        }
        if($args[0] == "help") {
            return $sender->sendMessage("Economy commands: /addmoney, /mymoney, /paymoney, /reducemoney, /seemoney, /setmoney");
        }
        if($args[0] == "info") {
            $description = $this->main->getDescription();
            $name = $description->getName();
            $version = $description->getVersion();
            return $sender->sendMessage("This server is running " . $name . " v" . $version . "\nAuthor: Lunarelly\nGitHub: https://github.com/Lunarelly");
        }
        return true;
    }

    public function getPlugin() {
        return $this->main;
    }
}