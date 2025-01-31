<?php

declare(strict_types=1);

namespace AdvancedEconomy\Commands;

use AdvancedEconomy\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class SellAllCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("sellall", "Sell all sellable items in your inventory.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game.");
            return false;
        }

        $prices = [
            "diamond" => 50,
            "iron_ingot" => 10,
            "gold_ingot" => 15
        ];

        $totalEarned = 0;
        foreach ($sender->getInventory()->getContents() as $item) {
            $price = $prices[strtolower($item->getName())] ?? 0;
            if ($price > 0) {
                $totalEarned += $price;
                $sender->getInventory()->removeItem($item);
            }
        }

        if ($totalEarned > 0) {
            $this->plugin->getEconomyManager()->addBalance($sender->getName(), $totalEarned);
            $sender->sendMessage(TextFormat::GREEN . "You sold items for " . TextFormat::YELLOW . "$totalEarned AC");
        } else {
            $sender->sendMessage(TextFormat::RED . "No sellable items found.");
        }

        return true;
    }
}
