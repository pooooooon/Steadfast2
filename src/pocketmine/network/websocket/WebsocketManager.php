<?php


namespace pocketmine\network\websocket;


// Could have a possibility for multiple websockets, this will take care of the ticks and what not..


class WebsocketManager
{

	protected $wsThread;
	protected $websockets = [];



	public function __construct(WebsocketThread $wsThread){
		$this->wsThread = $wsThread;
	}

	public function tickProcessor() {
		while (!$this->wsThread->isShutdown()) {
			$start = microtime(true);
			$this->tick();
			$time = microtime(true) - $start;
			if ($time < 0.075) {
				@time_sleep_until(microtime(true) + 0.075 - $time);
			}
		}
		foreach ($this->websockets as $ws) {
			$ws->close();
		}
		$this->websockets = [];
	}

	private function tick() {
		foreach ($this->websockets as $ws){
			var_dump("inTick Test");
			//TODO: get new messages from thread...
		}
	}



	public function registerSocket(Websocket $ws){
		$key = $ws->getAddress().":".$ws->getPort();
		if(!key_exists($key, $this->websockets)){
			$this->websockets[$key] = $ws;
		}
	}

	public function removeSocket(Websocket $ws){
		$key = $ws->getAddress().":".$ws->getPort();
		unset($key);
	}
	public function closeAll(){
		foreach ($this->websockets as $ws){
			$ws->close();
		}
	}


}