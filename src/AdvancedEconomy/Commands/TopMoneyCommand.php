<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class TopMoneyCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("moneytop", "View the richest players.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        $topPlayers = $this->plugin->getEconomyManager()->getTopPlayers();

        $sender->sendMessage(TextFormat::GOLD . "=== Top Richest Players ===");
        $rank = 1;
        foreach ($topPlayers as $player => $balance) {
            $sender->sendMessage(TextFormat::YELLOW . "#$rank " . TextFormat::AQUA . $player . TextFormat::WHITE . " - " . TextFormat::GREEN . "$balance AC");
            $rank++;
        }
        return true;
    }
}
