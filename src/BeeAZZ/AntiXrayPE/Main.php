<?php

declare(strict_types=1);

namespace BeeAZZ\AntiXrayPE;

use pocketmine\utils\Config;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\block\VanillaBlocks;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

class Main extends PluginBase implements Listener {

	protected Config $cfg;

	protected $anti = [];

	protected const VERSION = 1;

	private function checkVersion(): void {
		if ($this->cfg->get("version") !== self::VERSION or !$this->cfg->exists("version")) {
			$this->getLogger()->notice("§c§lPlease Use config.yml Latest");
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
				$sender->sendMessage("§c§lYou can't use this command in the terminal");
				return true;
			}
			if ($this->anti[$sender->getName()]) {
				$this->anti[$sender->getName()] = false;
				$sender->sendMessage($this->cfg->get("off"));
			} else {
				$this->anti[$sender->getName()] = true;
				$sender->sendMessage($this->cfg->get("on"));
			}
			return true;
		}
		return false;
	}

	private function onWarning($staff, $player, $event): void {
		foreach ($this->getServer()->getOnlinePlayers() as $staff) {
			if ($staff->hasPermission("antixraype.check")) {
				if ($this->anti[$staff->getName()]) {
					$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
				}
			}
		}
	}

	public function onBreak(BlockBreakEvent $event) {
		$block = $event->getBlock();
		$player = $event->getPlayer();
		if ($this->cfg->get("Coal")) {
			if ($block->isSameType(VanillaBlocks::COAL_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Redstone")) {
			if ($block->isSameType(VanillaBlocks::REDSTONE_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Diamond")) {
			if ($block->isSameType(VanillaBlocks::DIAMOND_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Lapis")) {
			if ($block->isSameType(VanillaBlocks::LAPIS_LAZULI_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Iron")) {
			if ($block->isSameType(VanillaBlocks::IRON_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Gold")) {
			if ($block->isSameType(VanillaBlocks::GOLD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
		if ($this->cfg->get("Emerald")) {
			if ($block->isSameType(VanillaBlocks::EMERALD_ORE())) {
				$this->onWarning($player, $player, $event);
			}
		}
	}
}
