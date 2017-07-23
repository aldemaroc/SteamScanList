<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>SteamScanList</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
	<center>
	<h1>SteamScanList</h1>
	<h3>Download me on <a href="https://github.com/AldemaroC/SteamScanList">GitHub!</a>
  <div class="wrapper">
  
  <div class="table">
  <div class="row header">
      <div class="cell">
        Game
      </div>
      <div class="cell">
        Server Name
      </div>
      <div class="cell">
        Players
      </div>
      <div class="cell">
        Password
      </div>
      <div class="cell">
        Address
      </div>
    </div>
<?php

	// This is a really bad PHP code, made for the sake of proof of concept
	// Please send your pull requests with better clean code
	require __DIR__ . '/SourceQuery/bootstrap.php';

	use xPaw\SourceQuery\SourceQuery;
	
	$Query = new SourceQuery( );
	$totaldeservidores = 0;
	$totaldejogadores = 0;
	$totaldeslots = 0;
	
	$contador = 0;
	
	include 'config.php';
	
	foreach ($ips as &$ip) {
	$contador++;
	$ipserver[$contador]=$ip;
	while (@ ob_end_flush());
	@ flush();
	for ($porta = $startport; $porta <= $endport; $porta++) {
	try
	{
		while (@ ob_end_flush());
			$Query->Connect( $ip, $porta, $timeout, "SourceQuery::SOURCE" );		
			$servidor = $Query->GetInfo( );
			if (!empty($servidor["HostName"])) {
				echo '<div class="row">';
				echo '<div class="cell">';				
				echo $servidor["ModDesc"];
				echo "</div>";
				echo '<div class="cell">';
				echo substr($servidor["HostName"], 0, 60);
				echo "</div>";
				echo '<div class="cell">';
				echo $servidor["Players"].'/'.$servidor["MaxPlayers"];
				echo "</div>";
				echo '<div class="cell">';
				if ($servidor["Password"] === false){echo "No";}else{echo "Yes";}
				echo '</div>';
				echo '<div class="cell">';
				echo '<a href="steam://connect/'.$ip.':'.$porta.'">'.$ip.':'.$porta.'</a>';
				echo "</div>";
				echo "</div>";
				
			
				$totaldeservidores++;
				$totaldejogadores = $totaldejogadores+$servidor["Players"];
				$totaldeslots = $totaldeslots+$servidor["MaxPlayers"];
				
				$statsservers[$contador]++;
				$statsjogadores[$contador]=$statsjogadores[$contador]+$servidor["Players"];
				$statslots[$contador] = $statslots[$contador]+$servidor["MaxPlayers"];
			}		
			
			
		@ flush();
	}
	catch( Exception $e )
	{
		//echo $e->getMessage( );
	}
	finally
	{
		$Query->Disconnect( );
	}
	}
}
?>
	</div><br>
	<div class="row header green">
      <div class="cell">
        IP
      </div>
      <div class="cell">
        Number of Servers
      </div>
      <div class="cell">
		Number of Players
      </div>
      <div class="cell">
        Number of slots
      </div>
    </div>
	<div class="row">
<?php
	echo '<div class="cell">All</div>';
	echo '<div class="cell">'.$totaldeservidores.'</div>';
	echo '<div class="cell">'.$totaldejogadores.'</div>';
	echo '<div class="cell">'.$totaldeslots.'</div></div>';
		
	$contador = 0;
	foreach ($ips as &$ip) {
	$contador++;
	echo '<div class="row">';
	echo '<div class="cell">'.$ipserver[$contador]=$ip.'</div>';
	echo '<div class="cell">'.$statsservers[$contador].'</div>';
	echo '<div class="cell">'.$statsjogadores[$contador].'</div>';
	echo '<div class="cell">'.$statslots[$contador].'</div></div>';
	}
?>

</div>
</div>
</center>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
</body>
