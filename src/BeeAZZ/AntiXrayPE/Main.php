<?php

declare(strict_types=1);

namespace BeeAZZ\AntiXrayPE;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\block\CoalOre;
use pocketmine\block\RedstoneOre;
use pocketmine\block\DiamondOre;
use pocketmine\block\LapisOre;
use pocketmine\block\EmeraldOre;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\block\BlockLegacyIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;


class Main extends PluginBase implements Listener {

	protected $anti = [];

	protected const VERSION = 1;

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
		$this->cfg = $this->cfg;
		if ($this->cfg->get("version") !== self::VERSION or !$this->cfg->exists("version")) {
			$this->getLogger()->notice("§c§lPlease Use config.yml Latest");
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}
	}

	public function onJoin(PlayerJoinEvent $event) {
		$name = $event->getPlayer()->getName();
		$this->anti[$name] = false;
	}

	public function onQuit(PlayerQuitEvent $event) {
		unset($this->anti[$event->getPlayer()->getName()]);
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
		switch ($cmd->getName()) {
			case "antixray":
				if (!$sender instanceof Player) {
					$sender->sendMessage("Please Use Command In Game");
					return true;
				}
				if ($sender->hasPermission("antixraype.check")) {
					if ($this->anti[$sender->getName()]) {
						$this->anti[$sender->getName()] = false;
						$sender->sendMessage($this->cfg->get("off"));
					} else {
						$this->anti[$sender->getName()] = true;
						$sender->sendMessage($this->cfg->get("on"));
					}
					break;
				}
				return true;
		}
		return true;
	}

	public function onBreak(BlockBreakEvent $event) {
		$block = $event->getBlock();
		$player = $event->getPlayer();
		if ($this->cfg->get("Coal")) {
			if ($block instanceof CoalOre) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Redstone")) {
			if ($block instanceof RedstoneOre) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Diamond")) {
			if ($block instanceof DiamondOre) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Lapis")) {
			if ($block instanceof LapisOre) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Iron")) {
			if ($block->getId() == BlockLegacyIds::IRON_ORE) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Gold")) {
			if ($block->getId() == BlockLegacyIds::GOLD_ORE) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
		if ($this->cfg->get("Emerald")) {
			if ($block instanceof EmeraldOre) {
				foreach ($this->getServer()->getOnlinePlayers() as $staff) {
					if ($staff->hasPermission("antixraype.check")) {
						if ($this->anti[$staff->getName()]) {
							$staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c" . $player->getName() . " §abreak §c" . $event->getBlock());
						}
					}
				}
			}
		}
	}
}
