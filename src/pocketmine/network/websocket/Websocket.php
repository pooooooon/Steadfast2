<?php


namespace pocketmine\network\websocket;


abstract class Websocket {

	/** @var $wsManager WebsocketManager */
	protected $wsManager;
	protected $wsAddress;
	protected $wsPort;
	protected $awaitingResponseQueue = [];
	protected $receivedMessageQueue = [];


	public function __construct($wsManager, $wsAddress, $wsPort){
		$this->wsManager = $wsManager;
		$this->wsAddress = $wsAddress;
		$this->wsPort = $wsPort;
	}

	public function initWebsocketExtension(){

	}

	protected function addWebsocket(){
		$this->wsManager->registerSocket($this);
	}
	protected function removeWebsocket(){
		$this->wsManager->removeSocket($this);
	}

	public function getMsgQueue(){

	}

	public function sendMsg($messageName, $messageJson, $needsResponse = false){


		if($needsResponse){
			//TODO: add message to $awaitingResponseQueue
		}

	}

	public function getAwaitingMessageQueue(){
		return $this->awaitingResponseQueue;
	}

	public function getAwaitingMessage($messageId){
		$msg = $this->awaitingResponseQueue[$messageId];
		$this->removeAwaitingMessage($messageId);
		return $msg;
	}
	public function removeAwaitingMessage($messageId){
		unset($messageId, $this->awaitingResponseQueue);
	}

	public function getReceivedMessageQueue(){
		return $this->receivedMessageQueue;
	}

	public function getReceivedMessage($messageId){
		$msg = $this->receivedMessageQueue[$messageId];
		$this->removeReceivedMessage($messageId);
		return $msg;
	}
	public function removeReceivedMessage($messageId){
		unset($messageId, $this->receivedMessageQueue);
	}

	public function getAddress(){
		return $this->wsAddress;
	}

	public function getPort(){
		return $this->wsPort;
	}

	public function close(){

	}

}