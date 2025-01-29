<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class TakeMoneyCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("takemoney", "Remove Aether Coins from a player's balance.", "/takemoney <player> <amount>");
        $this->setPermission("advancedeconomy.admin");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender->hasPermission("advancedeconomy.admin")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage(TextFormat::RED . "Usage: /takemoney <player> <amount>");
            return false;
        }

        $playerName = $args[0];
        $amount = (float) $args[1];

        if ($amount <= 0) {
            $sender->sendMessage(TextFormat::RED . "Amount must be greater than zero.");
            return false;
        }

        $this->plugin->getEconomyManager()->takeBalance($playerName, $amount);
        $sender->sendMessage(TextFormat::GREEN . "Removed " . TextFormat::YELLOW . "$amount AC" . TextFormat::GREEN . " from " . TextFormat::AQUA . "$playerName");

        return true;
    }
}
