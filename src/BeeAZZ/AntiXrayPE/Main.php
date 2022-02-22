<?php

namespace BeeAZZ\AntiXrayPE;

use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\block\Block;

class Main extends PluginBase implements Listener{
  
  public function onEnable(): void{
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->saveDefaultConfig();
  }
  public function onBreak(BlockBreakEvent $event){
   $block = $event->getBlock()->getId();
   $player = $event->getPlayer();
  if($this->getConfig()->get("Coal") == true){
  if($block == 16){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
  }
}
}
  if($this->getConfig()->get("Ingot") == true){
  if($block == 15){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
  }
}
}
}
  if($this->getConfig()->get("Gold") == true){
  if($block == 14){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
  }
}
  if($this->getConfig()->get("Diamond") == true){
  if($block == 56){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("§e§l[AntiXrayPE] ➳ §aPlayer §c".$player->getName(). " §abreak §c".$event->getBlock());
     }
    }
  }
  }
  if($this->getConfig()->get("Lapis") == true){
  if($block == 21){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("[AntiXrayPE] ➳ Player ".$player->getName(). " break ".$event->getBlock());
     }
    }
  }
  }
  if($this->getConfig()->get("Emerald") == true){
  if($block == 129){
    foreach($this->getServer()->getOnlinePlayers() as $staff){
     if($staff->hasPermission("antixraype.check")){
      $staff->sendMessage("[AntiXrayPE] ➳ Player ".$player->getName(). " break ".$event->getBlock());
     }
    }
  }
  }
  }
}
