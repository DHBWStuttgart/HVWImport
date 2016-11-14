<?php
namespace HVWData;

/**
 * Einfache Klasse um die Infrastrukturdetails des HVW abzubilden
 *
 * @author Friedemann Schwenkreis <friedemann.schwenkreis@dhbw-stuttgart.de>
 */
 class HVWInfrastructure {
	public static $Server = "http://www.handball4all.de/";
	public static $APIPath = "m/php/spo-proxy_ibm.php?";
	public static $Format = "format=json";
	public static $DataCommand = "&cmd=data";
	
	public static $Verbaende = [
			"DHB" => 0,			
			"HVW" => 3
	];
}

/**
 * Simple class to implement the Verband Data Object
 *
 * @author Friedemann Schwenkreis <friedemann.schwenkreis@dhbw-stuttgart.de>
 */
class HVWVerband {
	public $verbandsID;
	public $verbandsLabel;
	public $klassen;
	
	public static function loadFromJson ($jsonvar) {
		
		// print_r ($jsonvar[0]); echo "<br> <br>";
		
		$result = new HVWVerband();
		
		$result->verbandsID = $jsonvar[0]->lvIDPathStr;
		// print ($result->verbandsID); echo "<br>";
		$result->verbandsLabel = $jsonvar[0]->lvTypeLabelStr;
		// print ($result->verbandsLabel); echo "<br>";
		$ligenarray = $jsonvar[0]->dataList;
		// print_r ($result->ligenarray); echo "<br>--------<br>";
		
		foreach ($ligenarray AS $ligenjson) {
			$result->klassen[] = HVWKlasse::loadFromJson($ligenjson);
		}
		
		echo "-----------<br>Resultat: <br>";
		print_r ($result);
		echo "<br>-----------<br>";
		
		return $result;
	}
}

/**
 * Simple class to implement the Klassen Data Object
 *
 * @author Friedemann Schwenkreis <friedemann.schwenkreis@dhbw-stuttgart.de>
 */
class HVWKlasse {
	public $klassenID;
	public $klassenLabel;
	
	public static function loadFromJson($jsonvar) {
		//print_r($jsonvar); echo "<br>";
		
		$result = new HVWKlasse();
		
		$result->klassenID = $jsonvar->lvIDNext;
		//print ($result->klassenID); echo "<br>";
		$result->klassenLabel = $jsonvar->levelTypeLabel;
		//print ($result->klassenLabel); echo "<br>--------<br>";
		
		return $result;
	}
}
?>