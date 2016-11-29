<?php
// PHP Script zum Abholen der Daten vom HVW-Server
// http://www.handball4all.de/m/php/spo-proxy_ibm6.php?format=json&cmd=data&lvTypeNext=org&lvIDNext=3
// 
// print_r($_GET);
include ("./Packages/httpful.phar");
include ("./HVWData.php");

 $server = \HVWData\HVWInfrastructure::$Server . \HVWDATA\HVWInfrastructure::$APIPath;
 $parameter = $_GET["parameter"];
 
 // echo "Server-URL: " . $server . "<br>";
 
 retrieve($server, $parameter);
 
 
 function retrieve ($server, $parameter) {
 	// Zusammenbauen der kompletten URL
 	
 	$fullUrl = $server . \HVWData\HVWInfrastructure::$Format . \HVWData\HVWInfrastructure::$DataCommand . $parameter;
 	// echo $fullUrl . "<br>";
 	
 	// Nun holen wir die Daten
 	$request = \Httpful\Request::get($fullUrl);
 	try {
 		$response = $request->send();
 		if ($response->hasErrors()) {
 			echo "Fehler bei der Response. <br>"; print_r ($response); echo "<br>";
 		} else {
 			// Im Body steckt die Antwort
 			$result = $response->body;
 			// Die Antwort vom HVW hat am Anfang und am Ende runde Klammern, die zunaecsht entfernt werden muessen
 			$result = substr($result, 1, -1);
 			// print_r ($result); echo "<br>";

			// Jetzt kann man das Resultat in ein Json-Objekt wandeln lassen
 			$json_result = json_decode($result);
 			// print_r ($json_result); echo "<br>";
 			
 			// Nun konstruieren wir ein richtiges Objekt daraus
 			$verband = \HVWData\HVWVerband::loadFromJson($json_result);
 		}
 	}
 	catch (Exception $e) {
 		print $e;
 	}
 	

 }
 
?>