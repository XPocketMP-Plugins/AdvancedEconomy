<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use AdvancedEconomy\InflationManager;

class InflationCommand extends Command {

    private InflationManager $inflation;

    public function __construct(InflationManager $inflation) {
        parent::__construct("inflation", "Check the inflation status", "/inflation", []);
        $this->inflation = $inflation;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return;
        }

        $inflationRate = $this->inflation->getInflationRate();
        $sender->sendMessage(TextFormat::GREEN . "Current inflation rate: " . number_format($inflationRate, 2) . "%");
    }
}