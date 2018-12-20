<?php
ini_set("allow_url_fopen", 1);

class LettingWeb {

	private $base    = 'https://www.lettingweb.com/digitalapi/';
	private $search  = '';
	private $detail  = '';
	private $delta   = 9;
	private $debug   = false;
	public  $results = Array();

	public function __construct ($agentId = 1111, $debug = false) {
		$this->agentId = $agentId;
		$this->debug   = $debug;
		$this->search  = $this->base . 'jsonsearch?apikey='  . $this->agentId;
		$this->detail  = $this->base . 'jsonlisting?apikey=' . $this->agentId;
	}

	public function getAllSummary () {
		
		$start = 0;
		$total = 99999999;

		# no method to fetch all, have to :
		# 	make a request
		# 	get the total figure
		# 	repeat request with a 'showing' offset which increments
		while ($start < $total) {

			#wget "https://www.lettingweb.com/digitalapi/jsonsearch?apikey=1261&showing=108"  -O 108.json
			$url     = $this->search.'&showing='.$start;
			if ($this->debug) echo "Fetching from offset [$start] : [$url]\n";
			$json    = file_get_contents($url);
			$obj     = json_decode($json);
			$total   = $obj->Found;

			foreach ($obj->Results as $k => $o) {
				$this->results[$o->ListingId] = $o;
			}
			$start  += $this->delta;
		}

	}

	public function getPropertyDetail ($propRef) {
		$url     = $this->detail.'&listingid='.$propRef;
                if ($this->debug) echo "Fetching detail for [$propRef] : [$url]\n";
                $json    = file_get_contents($url);
                $obj     = json_decode($json);
		if ($this->debug) print_r($this->results[$propRef]);
		$this->results[$propRef]->Detail = $obj;
		if ($this->debug) print_r($this->results[$propRef]);
	}
}


?>

