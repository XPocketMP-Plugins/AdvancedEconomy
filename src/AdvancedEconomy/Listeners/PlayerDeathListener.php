<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use AdvancedEconomy\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\utils\TextFormat;

class PlayerDeathListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();
        $economy = $this->plugin->getEconomyManager();

        $currentBalance = $economy->getBalance($player->getName());
        $loss = $currentBalance * 0.05; // 5% loss

        if ($loss > 0) {
            $economy->takeBalance($player->getName(), $loss);
            $player->sendMessage(TextFormat::RED . "You lost " . TextFormat::YELLOW . "$loss AC" . TextFormat::RED . " due to death!");
        }
    }
}
