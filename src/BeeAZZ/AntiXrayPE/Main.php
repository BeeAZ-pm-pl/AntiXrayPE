<?php

declare(strict_types=1);

namespace BeeAZZ\AntiXrayPE;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\block\VanillaBlocks;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class Main extends PluginBase implements Listener {

	protected Config $cfg;

	private array $anti = [];

	private const VERSION = 1;

	private function checkVersion(): void {
		if ($this->cfg->get("version", false) !== self::VERSION) {
			$this->getLogger()->notice(TextFormat::RED . "Please use the latest configuration!");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
	}

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->cfg = $this->getConfig();
		$this->checkVersion();
	}

	public function onJoin(PlayerJoinEvent $event) {
		$name = $event->getPlayer()->getName();
		$this->anti[$name] = false;
	}

	public function onQuit(PlayerQuitEvent $event) {
		unset($this->anti[$event->getPlayer()->getName()]);
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
		if ($cmd->getName() === "antixray") {
			if (!($sender instanceof Player)) {
				$sender->sendMessage(TextFormat::RED . "You can't use this command in the terminal");
				return true;
			}
			if ($this->anti[$sender->getName()]) {
				$this->anti[$sender->getName()] = false;
				$sender->sendMessage(TextFormat::colorize($this->cfg->get("offMsg")));
			} else {
				$this->anti[$sender->getName()] = true;
				$sender->sendMessage(TextFormat::colorize($this->cfg->get("onMsg")));
			}
			return true;
		}
		return false;
	}

	private function onWarning($staff, $player, $event): void {
		foreach ($this->getServer()->getOnlinePlayers() as $staff) {
			if ($staff->hasPermission("antixraype.check")) {
				if ($this->anti[$staff->getName()]) {
					$staff->sendMessage(TextFormat::colorize(str_replace(
						["{prefix}", "{name}", "{block}"],
						[$this->cfg->get("prefix"), $player->getName(), $event->getBlock()],
						$this->cfg->get("warningMsg")
					)));
				}
			}
		}
	}

	public function onBreak(BlockBreakEvent $event) {
		$block = $event->getBlock();
		$player = $event->getPlayer();
		if ($this->cfg->get("CoalOre")) {
			if ($block->isSameType(VanillaBlocks::COAL_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("RedstoneOre")) {
			if ($block->isSameType(VanillaBlocks::REDSTONE_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("DiamondOre")) {
			if ($block->isSameType(VanillaBlocks::DIAMOND_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("LapisLazuliOre")) {
			if ($block->isSameType(VanillaBlocks::LAPIS_LAZULI_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("IronOre")) {
			if ($block->isSameType(VanillaBlocks::IRON_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("GoldOre")) {
			if ($block->isSameType(VanillaBlocks::GOLD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		} elseif ($this->cfg->get("EmeraldOre")) {
			if ($block->isSameType(VanillaBlocks::EMERALD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
	}
}
