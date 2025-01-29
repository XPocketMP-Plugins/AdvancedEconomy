<?php

declare(strict_types=1);

namespace AdvancedEconomy\Listeners;

use AdvancedEconomy\Main;
use pocketmine\block\BlockTypeIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;

class BlockBreakListener implements Listener {

    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onBlockBreak(BlockBreakEvent $event): void {
        $player = $event->getPlayer();
        $economy = $this->plugin->getEconomyManager();

        $rewards = [
            BlockTypeIds::DIAMOND_ORE => 5,
            BlockTypeIds::EMERALD_ORE => 5,
            BlockTypeIds::GOLD_ORE => 3,
            BlockTypeIds::IRON_ORE => 3,
            BlockTypeIds::COAL_ORE => 1
        ];

        $blockId = $event->getBlock()->getTypeId();
        $reward = $rewards[$blockId] ?? 0;

        if ($reward > 0) {
            $economy->addBalance($player->getName(), $reward);
            $player->sendMessage(TextFormat::GREEN . "You earned " . TextFormat::YELLOW . "$reward AC" . TextFormat::GREEN . " from mining!");
        }
    }
}
