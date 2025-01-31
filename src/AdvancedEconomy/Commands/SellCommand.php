<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SellCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("sell", "Sell an item or block.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }

        $item = $sender->getInventory()->getItemInHand();
        $itemName = $item->getName();

        $prices = [
            "diamond" => 50,
            "iron_ingot" => 10,
            "gold_ingot" => 15
        ];

        $price = $prices[strtolower($itemName)] ?? 0;

        if ($price === 0) {
            $sender->sendMessage(TextFormat::RED . "This item cannot be sold.");
            return false;
        }

        $this->plugin->getEconomyManager()->addBalance($sender->getName(), $price);
        $sender->getInventory()->removeItem($item);
        $sender->sendMessage(TextFormat::GREEN . "You sold " . TextFormat::AQUA . $itemName . TextFormat::GREEN . " for " . TextFormat::YELLOW . "$price AC");

        return true;
    }
}
