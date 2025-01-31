<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class SetMoneyCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("setmoney", "Set a player's Aether Coin balance.", "/setmoney <player> <amount>", ["setbal"]);
        $this->setPermission("advancedeconomy.admin");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender->hasPermission("advancedeconomy.admin")) {
            $sender->sendMessage(TextFormat::RED . "You do not have permission to use this command.");
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage(TextFormat::RED . "Usage: /setmoney <player> <amount>");
            return false;
        }

        $playerName = $args[0];
        $amount = (float) $args[1];

        if ($amount < 0) {
            $sender->sendMessage(TextFormat::RED . "Amount must be non-negative.");
            return false;
        }

        $this->plugin->getEconomyManager()->setBalance($playerName, $amount);
        $sender->sendMessage(TextFormat::GREEN . "Set " . TextFormat::AQUA . "$playerName" . TextFormat::GREEN . "'s balance to " . TextFormat::YELLOW . "$amount AC");

        return true;
    }
}
