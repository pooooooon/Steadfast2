<?php

namespace pocketmine\network\protocol\v310;

use pocketmine\utils\Binary;
use pocketmine\network\protocol\Info310;
use pocketmine\network\protocol\types\ScorePacketEntry;
use pocketmine\network\protocol\PEPacket;

class SetScorePacket extends PEPacket {

	const NETWORK_ID = Info310::SET_SCORE_PACKET;
	const PACKET_NAME = "SET_SCORE_PACKET";
	const TYPE_CHANGE = 0;
	const TYPE_REMOVE = 1;

	public $entries = [];
	public $type;

	public function encode($playerProtocol){
		$this->reset($playerProtocol);
		$this->putByte($this->type);
		$this->putSignedVarInt(count($this->entries));
		foreach($this->entries as $entry){
			$this->putVarInt($entry->scoreboardId);
			$this->putString($entry->objectiveName);
			$this->putLInt($entry->score);
			if($this->type !== self::TYPE_REMOVE){
				$this->putByte($entry->type);
				switch($entry->type){
					case ScorePacketEntry::TYPE_PLAYER:
					case ScorePacketEntry::TYPE_ENTITY:
						$this->putEntityUniqueId($entry->entityUniqueId);
						break;
					case ScorePacketEntry::TYPE_FAKE_PLAYER:
						$this->putString($entry->customName);
						break;
					default:
						throw new \InvalidArgumentException("Unknown entry type $entry->type");
				}
			}
		}
	}

	public function decode($playerProtocol){
		$this->type = $this->getByte();
		for($i = 0, $i2 = $this->getSignedVarInt(); $i < $i2; ++$i){
			$entry = new ScorePacketEntry();
			$entry->scoreboardId = $this->getVarInt();
			$entry->objectiveName = $this->getString();
			$entry->score = $this->getLInt();
			if($this->type !== self::TYPE_REMOVE){
				$entry->type = $this->getByte();
				switch($entry->type){
					case ScorePacketEntry::TYPE_PLAYER:
					case ScorePacketEntry::TYPE_ENTITY:
						$entry->entityUniqueId = $this->getEntityUniqueId();
						break;
					case ScorePacketEntry::TYPE_FAKE_PLAYER:
						$entry->customName = $this->getString();
						break;
					default:
						throw new \UnexpectedValueException("Unknown entry type $entry->type");
				}
			}
			$this->entries[] = $entry;
		}
	}

}
