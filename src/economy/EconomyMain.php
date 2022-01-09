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

namespace economy;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\permission\Permission;
use pocketmine\{
    Player,
    Server
};
use economy\{
    command\AddMoneyCommand,
    command\EconomyCommand,
    command\MyMoneyCommand,
    command\PayMoneyCommand,
    command\ReduceMoneyCommand,
    command\SeeMoneyCommand,
    command\SetMoneyCommand,
    event\DefaultMoneyListener
};

use function strtolower;

final class EconomyMain extends PluginBase {

    private function registerCommands() {
        Server::getInstance()->getCommandMap()->registerAll("Economy", array(
            new AddMoneyCommand($this),
            new EconomyCommand($this),
            new MyMoneyCommand($this),
            new PayMoneyCommand($this),
            new ReduceMoneyCommand($this),
            new SeeMoneyCommand($this),
            new SetMoneyCommand($this)
        ));
    }

    private function registerPermissions() {
        $permissions = array(
            new Permission("economy.command.addmoney", "Permission for addmoney command", Permission::DEFAULT_OP),
            new Permission("economy.command.default", "Permission for economy command", Permission::DEFAULT_TRUE),
            new Permission("economy.command.mymoney", "Permission for mymoney command", Permission::DEFAULT_TRUE),
            new Permission("economy.command.paymoney", "Permission for paymoney command", Permission::DEFAULT_TRUE),
            new Permission("economy.command.reducemoney", "Permission for reducemoney command", Permission::DEFAULT_OP),
            new Permission("economy.command.seemoney", "Permission for seemoney command", Permission::DEFAULT_OP),
            new Permission("economy.command.setmoney", "Permission for setmoney command", Permission::DEFAULT_OP)
        );
        foreach($permissions as $permission) {
            Server::getInstance()->getPluginManager()->addPermission($permission);
        }
    }

    private function registerListeners() {
        Server::getInstance()->getPluginManager()->registerEvents(new DefaultMoneyListener($this), $this);
    }

    public function onEnable() {
        $this->registerCommands();
        $this->registerPermissions();
        $this->registerListeners();
        $this->saveDefaultConfig();
        if(!(is_dir($this->getDataFolder() . "data"))) {
            @mkdir($this->getDataFolder() . "data");
        }
        $this->moneyConfig = new Config($this->getDataFolder() . "data/money.json", Config::JSON);
    }

    private function getMoneyConfig() {
        return $this->moneyConfig;
    }
    
    private function saveEconomyData() {
        $moneyConfig = $this->getMoneyConfig();
        $moneyConfig->save();
    }

    public function isNewPlayer(string $name) {
        $config = $this->getMoneyConfig();
        $name = strtolower($name);
        if(!($config->exists($name))) {
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    public function getMoney(string $name) {
        $config = $this->getMoneyConfig();
        $name = strtolower($name);
        if(!($config->exists($name))) {
            $money = 0;
        } else {
            $money = $config->get($name);
        }
        return $money;
    }

    public function addMoney(string $name, int $value) {
        $config = $this->getMoneyConfig();
        $name = strtolower($name);
        $money = $this->getMoney($name) + $value;
        $config->set($name, $money);
        $config->save();
    }
    
    public function reduceMoney(string $name, int $value) {
        $config = $this->getMoneyConfig();
        $name = strtolower($name);
        $money = $this->getMoney($name) - $value;
        $config->set($name, $money);
        $config->save();
    }

    public function setMoney(string $name, int $value) {
        $config = $this->getMoneyConfig();
        $name = strtolower($name);
        $money = $value;
        $config->set($name, $money);
        $config->save();
    }

    public function onDisable() {
        $this->saveEconomyData();
        $this->getLogger()->info("Saving economy data...");
    }
}