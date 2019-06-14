<?php


namespace pocketmine\network\websocket;


abstract class Websocket {

	/** @var $wsManager WebsocketManager */
	protected $wsManager;
	protected $wsAddress;
	protected $wsPort;


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

	public function getAddress(){
		return $this->wsAddress;
	}

	public function getPort(){
		return $this->wsPort;
	}

	public function close(){

	}

}