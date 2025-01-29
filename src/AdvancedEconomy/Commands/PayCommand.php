<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PayCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("pay", "Send Aether Coins to another player.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }

        if (count($args) < 2) {
            $sender->sendMessage(TextFormat::RED . "Usage: /pay <player> <amount>");
            return false;
        }

        $target = $this->plugin->getServer()->getPlayerByPrefix($args[0]);
        if ($target === null || !$target->isOnline()) {
            $sender->sendMessage(TextFormat::RED . "Player not found.");
            return false;
        }

        $amount = (float) $args[1];
        if ($amount <= 0) {
            $sender->sendMessage(TextFormat::RED . "Amount must be greater than zero.");
            return false;
        }

        if (!$this->plugin->getEconomyManager()->hasEnough($sender->getName(), $amount)) {
            $sender->sendMessage(TextFormat::RED . "You do not have enough Aether Coins.");
            return false;
        }

        $tax = $amount * 0.02;
        $finalAmount = $amount - $tax;

        $this->plugin->getEconomyManager()->takeBalance($sender->getName(), $amount);
        $this->plugin->getEconomyManager()->addBalance($target->getName(), $finalAmount);

        $sender->sendMessage(TextFormat::GREEN . "You sent " . TextFormat::YELLOW . "$finalAmount AC" . TextFormat::GREEN . " to " . TextFormat::AQUA . $target->getName());
        $target->sendMessage(TextFormat::AQUA . $sender->getName() . TextFormat::GREEN . " sent you " . TextFormat::YELLOW . "$finalAmount AC");

        return true;
    }
}
