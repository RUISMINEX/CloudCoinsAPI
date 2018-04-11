<?php

namespace CC;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\Server;




class main extends PluginBase{

public function onEnable()
{
    $this->getLogger()->info("CloudCoins enabled");
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    @mkdir($this->getDataFolder());
    //ocnfig module
    $this->saveDefaultConfig();
    $this->getResource("config.yml");
    //mysql connections
//getting host, usernme and password from mysql.yml

    $this->HOST = $this->getConfig()->get("hostip");
    $this->USER = $this->getConfig()->get("username");
    $this->PASS = $this->getConfig()->get("password");
    //database

    $this->TABLE = "Coins" . "(PLAYER VARCHAR(225), COINS INT(100) DEFAULT 0)";

    //connecting to database

    $mysqli = new \mysqli($this->HOST, $this->USER, $this->PASS);
    $this->getLogger->info("Connected to MYSQL.");
    // create database if it doesnt exist
    $this->getLogger->info("The database 'coins' was not found, creating one...");
    $mysqli->query("CREATE DATABASE IF NOT EXISTS " . "Coins");
    $this->getLogger->info("Databse created!");
    //  connecting to table of the database

    $mysqli = new \mysqli($this->HOST, $this->USER, $this->PASS, "Coins");
    // create table if doesnt exist
    $mysqli->query("CREATE TABLE IF NOT EXISTS " . $this->TABLE);
    $this->getLogger->info("Connected to MYSQL Database.");

    //setting coins of a player
}
    public
    function setCoins(Player $player, int $coins)
    {
        $mysqli = new \mysqli($this->HOST, $this->USER, $this->PASS, "Coins");
        $name = $player->getName();
        if ($mysqli->query("SELECT * FROM " . "Coins" . " WHERE PLAYER = '$name'")->num_rows > 0) {
            $mysqli->query("UPDATE " . "Coins" . " SET COINS = '$coins' WHERE PLAYER = '$name'");
        } else {
            $mysqli->query("INSERT INTO " . "Coins" . "(PLAYER, COINS) VALUES ('$name', '$coins')");
        }
        return true;

    }

    //exchange coins
    public
    function exchangeCoins(Player $player, int $coins)
    {
        $mysqli = new \mysqli($this->HOST, $this->USER, $this->PASS, "Coins");
        $name = $player->getName();
        if ($mysqli->query("SELECT * FROM " . "Coins" . " WHERE PLAYER = '$name'")->num_rows > 0) {
            $mysqli->query("UPDATE " . "Coins" . " SET COINS = '$coins' + COINS WHERE PLAYER = '$name'");
        } else {
            $this->setCoins($player, $coins);
        }
    }

    //getting coins
    public
    function getCoins(Player $player)
    {
        $mysqli = new \mysqli($this->HOST, $this->USER, $this->PASS, "Coins");
        $name = $player->getName();
        if ($mysqli->query("SELECT * FROM " . "Coins" . " WHERE PLAYER = '$name'")->num_rows > 0) {
            $info = mysqli_fetch_row($mysqli->query("SELECT * FROM " . "Coins" . " WHERE PLAYER = '$name'"));
            return $info[1];
        } else {
            return 0;
        }
    }

}
