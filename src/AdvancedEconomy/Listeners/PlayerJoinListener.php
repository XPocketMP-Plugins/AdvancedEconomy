<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use AdvancedEconomy\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerJoinListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $economy = $this->plugin->getEconomyManager();

        if (!$economy->playerExists($player->getName())) {
            $economy->setBalance($player->getName(), 100); // Starting balance: 100 AC
        }
    }
}
