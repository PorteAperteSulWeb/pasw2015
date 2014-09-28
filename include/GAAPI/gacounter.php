<?php
//ini_set("error_reporting","E_ALL");
/** GAcounter 1.1 - 03 settembre 2012
* based on GAPI php class
* ( http://code.google.com/p/gapi-google-analytics-php-interface/ )
* developed by Marco Cilia ( http://www.goanalytics.info )
* developed by MAXX Berni per Porteapertesulweb 
* Comunità di pratica per accessibilità dei siti scolastici( http://www.porteapertesulweb.it )
*/
// inserisci login e password che usi abitualmente per accedere a Google Analytics

register_shutdown_function('shutdownFunction');

function shutDownFunction() { 
    $error = error_get_last();
    if ($error['type'] == 1) {
    	session_destroy();
    	die('<strong>ERRORE PASW2015@S01</strong>');

    } 
}

error_reporting(0);

function pasw_decryptIt($q) {
    $cryptKey = get_option('pasw_key');
    $qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

define('ga_email',get_option('pasw_ga_user'));
define('ga_password',pasw_decryptIt(get_option('pasw_ga_password')));
define('ga_profile_id',get_option('pasw_ga_profile_id'));

require_once 'gapi.class.php';


$giorni_anno = 365;
$giorni_mese = 30;
$giorni_settimana = 7;
$giorni_giorno = 1;
$data_ricerca_anno = date("Y-m-d", time()-(86400*$giorni_anno));
$data_ricerca_mese = date("Y-m-d", time()-(86400*$giorni_mese));
$data_ricerca_settimana = date("Y-m-d", time()-(86400*$giorni_settimana));
$data_ricerca_giorno = date("Y-m-d", time()-(86400*$giorni_giorno));
$oggi = date("Y-m-d");


	$ga = new gapi(ga_email,ga_password);
	
//////////////
// GIORNO
//////////////
	$ga->requestReportData(ga_profile_id,array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_giorno, date("Y-m-d"), 1,1000);
	echo "<div class=\"gacounter\">";
	echo "<h3>Periodo osservazione: ultimo giorno </h3>";
	echo "<p> dal ".date("d-m-Y", time()-(86400*$giorni_giorno))." al ".date("d-m-Y")."</p>";
	echo "<ul><li>visite totali: " . $ga->getVisits() . "</li>";
	echo "<li class=\"alternato\">visitatori totali: " . $ga->getVisitors() . "</li>";	
	echo "<li>nuovi visitatori: " . $ga->getnewVisits() . "</li>";	
	echo "<li class=\"alternato\">pagine viste: " . $ga->getPageviews() . "</li>";	
	echo "<li>pagine viste per visita: " . round($ga->getpageviewsPerVisit(),2) . "</li>";	
	echo "<li class=\"alternato\">pagine uniche: " . $ga->getuniquePageviews() . "</li>";	
	$t_medio = tempo_medio($ga->getavgTimeOnSite());
	echo "<li>tempo medio di permanenza sul sito: " .$t_medio. "</li></ul>";	
	echo "</div>";
	

//////////////
// SETTIMANA
//////////////
	$ga->requestReportData(ga_profile_id,array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_settimana, date("Y-m-d"), 1,1000);
	echo "<div class=\"gacounter\">";
	echo "<h3>Periodo osservazione: ultimi 7 giorni</h3>";
	echo "<p> dal ".date("d-m-Y", time()-(86400*$giorni_settimana))." al ".date("d-m-Y")."</p>";
	echo "<ul><li>visite totali: " . $ga->getVisits() . "</li>";
	echo "<li class=\"alternato\">visitatori totali: " . $ga->getVisitors() . "</li>";	
	echo "<li>nuovi visitatori: " . $ga->getnewVisits() . "</li>";	
	echo "<li class=\"alternato\">pagine viste: " . $ga->getPageviews() . "</li>";	
	echo "<li>pagine viste per visita: " . round($ga->getpageviewsPerVisit(),2) . "</li>";	
	echo "<li class=\"alternato\">pagine uniche: " . $ga->getuniquePageviews() . "</li>";	
	$t_medio = tempo_medio($ga->getavgTimeOnSite());
	echo "<li>tempo medio di permanenza sul sito: " .$t_medio. "</li></ul>";	
	echo "</div>";		
	


//////////////
// MESE
//////////////
	$ga->requestReportData(ga_profile_id,array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_mese, date("Y-m-d"), 1,1000);
	echo "<div class=\"gacounter\">";
	echo "<h3>Periodo osservazione: ultimi 30 giorni</h3>";
	echo "<p> dal ".date("d-m-Y", time()-(86400*$giorni_mese))." al ".date("d-m-Y")."</p>";
	echo "<ul><li>visite totali: " . $ga->getVisits() . "</li>";
	echo "<li class=\"alternato\">visitatori totali: " . $ga->getVisitors() . "</li>";	
	echo "<li>nuovi visitatori: " . $ga->getnewVisits() . "</li>";	
	echo "<li class=\"alternato\">pagine viste: " . $ga->getPageviews() . "</li>";	
	echo "<li>pagine viste per visita: " . round($ga->getpageviewsPerVisit(),2) . "</li>";	
	echo "<li class=\"alternato\">pagine uniche: " . $ga->getuniquePageviews() . "</li>";	
	$t_medio = tempo_medio($ga->getavgTimeOnSite());
	echo "<li>tempo medio di permanenza sul sito: " .$t_medio. "</li></ul>";	
	echo "</div>";




//////////////
// ANNO
//////////////

	$ga->requestReportData(ga_profile_id,array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_anno, date("Y-m-d"), 1,1000);
	echo "<div class=\"gacounter\">";
	echo "<h3>Periodo osservazione: ultimi 365 giorni</h3>";
	echo "<p>dal ".date("d-m-Y", time()-(86400*$giorni_anno))." al ".date("d-m-Y")."</p>";
	echo "<ul><li>visite totali: " . $ga->getVisits() . "</li>";
	echo "<li class=\"alternato\">visitatori totali: " . $ga->getVisitors() . "</li>";	
	echo "<li>nuovi visitatori: " . $ga->getnewVisits() . "</li>";	
	echo "<li class=\"alternato\">pagine viste: " . $ga->getPageviews() . "</li>";	
	echo "<li>pagine viste per visita: " . round($ga->getpageviewsPerVisit(),2) . "</li>";	
	echo "<li class=\"alternato\">pagine uniche: " . $ga->getuniquePageviews() . "</li>";	
	$t_medio = tempo_medio($ga->getavgTimeOnSite());
	echo "<li>tempo medio di permanenza sul sito: " .$t_medio. "</li></ul>";	
	echo "</div>";	

function tempo_medio($getavgTimeOnSite)
{
	$time_divisione = explode('.',$getavgTimeOnSite);
	$min_totali=intval($time_divisione[0]/60);
	$secondi=$time_divisione[0]-($min_totali*60);
	$ore=intval($min_totali/60);
	$minuti=$min_totali-(60*$ore);
  if($ore < 10) {
  	$ore='0'.$ore;
  }
  if($minuti < 10) {
  	$minuti='0'.$minuti;
  }
  if($secondi < 10) {
  	$secondi='0'.$secondi;
  }
  return($ore.':'.$minuti.':'.$secondi);	
}
?>
