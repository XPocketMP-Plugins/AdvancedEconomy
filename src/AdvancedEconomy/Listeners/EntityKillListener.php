<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use AdvancedEconomy\Main;
use pocketmine\entity\Entity;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class EntityKillListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onEntityKill(EntityDeathEvent $event): void {
        $entity = $event->getEntity();
        $damager = $entity->getLastDamageCause()?->getEntity();

        if ($damager instanceof Human) {
            $player = $damager;
            $economy = $this->plugin->getEconomyManager();

            $rewards = [
                "Zombie" => 2,
                "Skeleton" => 2,
                "Creeper" => 5,
                "EnderDragon" => 500
            ];

            $entityName = $entity->getName();
            $reward = $rewards[$entityName] ?? 0;

            if ($reward > 0) {
                $economy->addBalance($player->getName(), $reward);
                $player->sendMessage(TextFormat::GREEN . "You earned " . TextFormat::YELLOW . "$reward AC" . TextFormat::GREEN . " for killing a " . TextFormat::AQUA . $entityName);
            }
        }
    }
}
