# CloudCoinsAPI
This plugin uses MYSQL to store coins data for each individual player.

# PLEASE NOTE THAT THIS PLUGIN WILL NOT WORK WITHOUT A MYSWQL DATABASE

You can set the Host, Username and password in the cinfig file.

# API

This plugin can be accessed using an API:

# Get coins of player, return (int)
$this->getServer()->getPluginManager()->getPlugin("Coins")->getCoins($player);

# Set coins of player, (int)$count
$this->getServer()->getPluginManager()->getPlugin("Coins")->setCoins($player, $count);
