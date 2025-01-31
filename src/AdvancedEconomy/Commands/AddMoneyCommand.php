<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class AddMoneyCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("addmoney", "Add Aether Coins to a player's balance.", "/addmoney <player> <amount>");
        $this->setPermission("advancedeconomy.admin");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender->hasPermission("advancedeconomy.admin")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage(TextFormat::RED . "Usage: /addmoney <player> <amount>");
            return false;
        }

        $playerName = $args[0];
        $amount = (float) $args[1];

        if ($amount <= 0) {
            $sender->sendMessage(TextFormat::RED . "Amount must be greater than zero.");
            return false;
        }

        $this->plugin->getEconomyManager()->addBalance($playerName, $amount);
        $sender->sendMessage(TextFormat::GREEN . "Added " . TextFormat::YELLOW . "$amount AC" . TextFormat::GREEN . " to " . TextFormat::AQUA . "$playerName");

        return true;
    }
}
