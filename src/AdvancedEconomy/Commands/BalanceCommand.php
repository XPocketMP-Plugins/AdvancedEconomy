<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class BalanceCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("balance", "Check your Aether Coin balance.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }

        $balance = $this->plugin->getEconomyManager()->getBalance($sender->getName());
        $sender->sendMessage(TextFormat::GREEN . "Your balance: " . TextFormat::YELLOW . "$balance AC");
        return true;
    }
}
