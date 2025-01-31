<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use AdvancedEconomy\InflationManager;
use AdvancedEconomy\Main;

class InflationCommand extends Command {

    private InflationManager $inflation;
    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("inflation", "Check the inflation status", "/inflation", []);
        $this->inflation = $inflation;
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return;
        }

        $inflationRate = $this->inflation->getInflationRate();
        $sender->sendMessage(TextFormat::GREEN . "Current inflation rate: $inflationRate%");
    }
}
