<?php

/* CLASSE GAPI
* based on GAPI php class
* ( http://code.google.com/p/gapi-google-analytics-php-interface/ )
* developed by Marco Cilia ( http://www.goanalytics.info )
* developed by MAXX Berni per Porteapertesulweb 
* Comunità di pratica per accessibilità dei siti scolastici( http://www.porteapertesulweb.it )
*/
?>

<div id="curve_chart" style="width: 100%; height: 300px"></div>
 <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>

<?php
require_once 'gapi.class.php';

// if ( is_pasw2015_child() && get_option( 'pasw_ga_user' ) ) {
	if ( get_option( 'pasw_ga_user' ) ) {
    $user = get_option( 'pasw_ga_user' );
    $path = get_stylesheet_directory() . '/ga-oauthkeyfile.p12';
} else {
    $user = '576457711209-4buphlu09fg6rakbpraf5qpe7hov7uri@developer.gserviceaccount.com';
    $path = dirname(__FILE__).'/oauthkeyfile.p12';
}

$giorni_anno = 365;
$giorni_mese = 30;
$giorni_settimana = 7;
$giorni_giorno = 1;
$data_ricerca_anno = date("Y-m-d", time()-(86400*$giorni_anno));
$data_ricerca_mese = date("Y-m-d", time()-(86400*$giorni_mese));
$data_ricerca_settimana = date("Y-m-d", time()-(86400*$giorni_settimana));
$data_ricerca_giorno = date("Y-m-d", time()-(86400*$giorni_giorno));
$oggi = date("Y-m-d");

$ga = new gapi($user, $path);


$ga->requestReportData(get_option('pasw_ga_profile_id'),array('date'),array('visits'),array('date'),'',$data_ricerca_anno,date("Y-m-d"),1,1000);

echo "<script type=\"text/javascript\">
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Giorno', 'Visite totali'],";
foreach($ga->getResults() as $result)
{
    echo "['".date("d-m-Y", strtotime($result))."',  ".$result->getVisits()."],";
}
echo "]);

        var options = {
          title: 'Accessi al sito (ultimi 365 giorni)',
          curveType: 'function',
          vAxis: {viewWindow: {min:0} },
          hAxis: { textPosition: 'none' },
          chartArea:{width:\"100%\"},
          legend: { position: 'none' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>";




$ga->requestReportData(get_option('pasw_ga_profile_id'),array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_giorno, date("Y-m-d"), 1,1000);


	echo "<h3>Ultimo Giorno";
    echo "<span style=\"float:right;font-size:0.8em;\">".date("d-m-Y", time()-(86400*$giorni_giorno))." ~ ".date("d-m-Y")."</span>";
    echo "</h3>";
?>
<table style="width:100%">
  <tr>
    <td>Visite totali:</td>
    <td align="center"><b><?php echo $ga->getVisits(); ?></b><br>(tempo medio: <?php echo substr(tempo_medio($ga->getavgTimeOnSite()), 3); ?>)</td>
  </tr>
  <tr>
    <td>Visitatori totali:</td>
    <td align="center"><b><?php echo $ga->getVisitors(); ?></b><br>(nuovi visitatori: <?php echo $ga->getnewVisits(); ?>)</td>
  </tr>
  <tr>
    <td>Pagine viste:</td>
    <td align="center"><b><?php echo $ga->getPageviews(); ?></b><br>(pagine per visita: <?php echo round($ga->getpageviewsPerVisit(),2); ?>)</td>
  </tr>
</table>
<?php

	$ga->requestReportData(get_option('pasw_ga_profile_id'),array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_settimana, date("Y-m-d"), 1,1000);

	echo "<h3>Ultima Settimana";
    echo "<span style=\"float:right;font-size:0.8em;\">".date("d-m-Y", time()-(86400*$giorni_settimana))." ~ ".date("d-m-Y")."</span>";
    echo "</h3>";
?>
<table style="width:100%">
  <tr>
    <td>Visite totali:</td>
    <td align="center"><b><?php echo $ga->getVisits(); ?></b><br>(tempo medio: <?php echo substr(tempo_medio($ga->getavgTimeOnSite()), 3); ?>)</td>
  </tr>
  <tr>
    <td>Visitatori totali:</td>
    <td align="center"><b><?php echo $ga->getVisitors(); ?></b><br>(nuovi visitatori: <?php echo $ga->getnewVisits(); ?>)</td>
  </tr>
  <tr>
    <td>Pagine viste:</td>
    <td align="center"><b><?php echo $ga->getPageviews(); ?></b><br>(pagine per visita: <?php echo round($ga->getpageviewsPerVisit(),2); ?>)</td>
  </tr>
</table>
<?php

	$ga->requestReportData(get_option('pasw_ga_profile_id'),array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_mese, date("Y-m-d"), 1,1000);

echo "<h3>Ultimo Mese";
    echo "<span style=\"float:right;font-size:0.8em;\">".date("d-m-Y", time()-(86400*$giorni_mese))." ~ ".date("d-m-Y")."</span>";
    echo "</h3>";
?>
<table style="width:100%">
  <tr>
    <td>Visite totali:</td>
    <td align="center"><b><?php echo $ga->getVisits(); ?></b><br>(tempo medio: <?php echo substr(tempo_medio($ga->getavgTimeOnSite()), 3); ?>)</td>
  </tr>
  <tr>
    <td>Visitatori totali:</td>
    <td align="center"><b><?php echo $ga->getVisitors(); ?></b><br>(nuovi visitatori: <?php echo $ga->getnewVisits(); ?>)</td>
  </tr>
  <tr>
    <td>Pagine viste:</td>
    <td align="center"><b><?php echo $ga->getPageviews(); ?></b><br>(pagine per visita: <?php echo round($ga->getpageviewsPerVisit(),2); ?>)</td>
  </tr>
</table>
<?php

	$ga->requestReportData(get_option('pasw_ga_profile_id'),array('visitorType'),array('visitors','pageviews','visits','timeOnSite','avgtimeOnsite','percentNewVisits','newVisits','pageviewsPerVisit','uniquePageviews'),'','',$data_ricerca_anno, date("Y-m-d"), 1,1000);

echo "<h3>Ultimo Anno";
    echo "<span style=\"float:right;font-size:0.8em;\">".date("d-m-Y", time()-(86400*$giorni_anno))." ~ ".date("d-m-Y")."</span>";
    echo "</h3>";
?>
<table style="width:100%">
  <tr>
    <td>Visite totali:</td>
    <td align="center"><b><?php echo $ga->getVisits(); ?></b><br>(tempo medio: <?php echo substr(tempo_medio($ga->getavgTimeOnSite()), 3); ?>)</td>
  </tr>
  <tr>
    <td>Visitatori totali:</td>
    <td align="center"><b><?php echo $ga->getVisitors(); ?></b><br>(nuovi visitatori: <?php echo $ga->getnewVisits(); ?>)</td>
  </tr>
  <tr>
    <td>Pagine viste:</td>
    <td align="center"><b><?php echo $ga->getPageviews(); ?></b><br>(pagine per visita: <?php echo round($ga->getpageviewsPerVisit(),2); ?>)</td>
  </tr>
</table>
<?php

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
