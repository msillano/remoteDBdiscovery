<?php
/*
  test_dataprotocols -  This file is part of remoteDBdiscovery.
  
  remoteDBdiscovery is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public
  License as published by the Free Software Foundation; either
  version 2 of the License, or (at your option) any later version.

  remoteDBdiscovery is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  --------
  Copyright (c) 2017 Marco Sillano.  All right reserved.
 */

$r = dirname(dirname(__FILE__));
require_once ("$r/remoteDB/irp_commonSQL.php");
require_once ("$r/remoteDB/irp_remotedb_tools.php");
require_once ("$r/remoteDB/irp_remotedb_stream.php");
require_once ("$r/phpIRPlib/irp_classes.php");

// ------------------------------------- test code
echo " <HTML><HEAD>";
echo StyleSheet();
echo "</HEAD><BODY>";
if (isset($_GET['save'])) { // save
// echo "<pre>"; print_r($_GET); echo "</pre>";
 $protocol = $_GET['protocol'];
 if (isset($_GET['do'])){   // save minmax
    sql("UPDATE irp_protocoldata SET min=".$_GET['min'].",
                                  max=".$_GET['max'].",
                                  len00=".$_GET['len00'].",
                                  rawMicros00=".$_GET['rawMicros00'].",
                                  len55=".$_GET['len55'].",
                                  rawMicros55=".$_GET['rawMicros55'].",
                                  lenAA=".$_GET['lenAA'].",
                                  rawMicrosAA=".$_GET['rawMicrosAA'].",
                                  lenFF=".$_GET['lenFF'].",
                                  rawMicrosFF=".$_GET['rawMicrosFF']."
							WHERE idprotocol = $protocol ");
								 
 }  else  {                 // no save min max
   sql("UPDATE irp_protocoldata SET  len00=".$_GET['len00'].",
                                  rawMicros00=".$_GET['rawMicros00'].",
                                  len55=".$_GET['len55'].",
                                  rawMicros55=".$_GET['rawMicros55'].",
                                  lenAA=".$_GET['lenAA'].",
                                  rawMicrosAA=".$_GET['rawMicrosAA'].",
                                  lenFF=".$_GET['lenFF'].",
                                  rawMicrosFF=".$_GET['rawMicrosFF']."
							WHERE idprotocol = $protocol ");
 }
 $name = sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $protocol");

echo "<h4> Updated irp_protocoldata for $name.</h4>";
unset($_GET['protocol']);
}

if (!isset($_GET['protocol']) || isset($_GET['more'])) {
echo "<h1>  Test protocol data </h1>
      <div class='note'><form action='test_dataprotocols.php' mode='GET'> Choose protocol: <select name='protocol'>";
echo  getProtocolsOptionList();					
echo " </select> <hr>";
echo " <input type='submit' value='execute test'></form></div>";
echo "<hr><center> <a href='index.html'><<< back </a> </center></BODY></HTML>";
exit;	
}

$protocol = $_GET['protocol'];
// ======================================  test code ==========
$protocols = sqlRecord("SELECT * FROM irp_protocols WHERE idprotocol = $protocol");
$dataold   = sqlRecord("SELECT * FROM irp_protocoldata WHERE idprotocol = $protocol" );

echo "<h1> Data for protocol ".$protocols['name'].",  id = $protocol </h1>";
if ($protocols['notes'] != NULL){
echo "<div class='note'><i>".$protocols['notes']."</i></div><br>";
}

echo '<b><span style="color:blue">'. $protocols['IRP'].'</span></b><br><br>';
echo  $dataold['coding'].'<hr><br>';

echo "<b>DB values: </b><br><pre> \tmin: ".$dataold['min']."   \tMAX: ".$dataold['MAX']." 

 data00:  len ".$dataold['len00']."  \trawMicros:  ".$dataold['rawMicros00']." 
 data55:  len ".$dataold['len55']."  \trawMicros:  ".$dataold['rawMicros55']." 
 dataAA:  len ".$dataold['lenAA']."  \trawMicros:  ".$dataold['rawMicrosAA']." 
 dataFF:  len ".$dataold['lenFF']."  \trawMicros:  ".$dataold['rawMicrosFF']." 
 </pre>";
// ===================================================
$data00 = '000000000000000000000000000000000000000000000000';
$data55 = '555555555555555555555555555555555555555555555555';
$dataAA = 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
$dataFF = 'FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
// not used but...
$data3C = '3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C3C';
$data0F = '0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F0F';
//
 $min = 1000000000;
 $max = 0;
// create object
$aProtocol = new irp_protocol($protocols['IRP']);
//
$raw1 = $aProtocol->encodeRaw($data00, 1); 
$raw2 = $aProtocol->RAWprocess($raw1,0);
$rawMicros00 = irp_rawMicros($raw2);
$times = explode('|', $raw2);
$len00 = count($times);
$done = false;
foreach($times as $i => $value)
   if (irp_isInRange($i, $len00)) { 
       $x = abs($value);
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
       }
//	   
$raw1 = $aProtocol->encodeRaw($data55, 1); 
$raw2 = $aProtocol->RAWprocess($raw1,0);
$rawMicros55 = irp_rawMicros($raw2);
$times = explode('|', $raw2);
$len55 = count($times);
foreach($times as $i => $value)
   if (irp_isInRange($i, $len55)) { 
       $x = abs($value);
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
       }

//	   
$raw1 = $aProtocol->encodeRaw($dataAA, 1); 
$raw2 = $aProtocol->RAWprocess($raw1,0);
$rawMicrosAA = irp_rawMicros($raw2);
$times = explode('|', $raw2);
$lenAA = count($times);
foreach($times as $i => $value)
   if (irp_isInRange($i, $lenAA)) { 
       $x = abs($value);
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
       }
//	   
$raw1 = $aProtocol->encodeRaw($dataFF, 1); 
$raw2 = $aProtocol->RAWprocess($raw1,0);
$rawMicrosFF = irp_rawMicros($raw2);
$times = explode('|', $raw2);
$lenFF = count($times);
foreach($times as $i => $value)
   if (irp_isInRange($i, $lenFF)) { 
       $x = abs($value);
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
       }
echo "<form action='test_dataprotocols.php' >";	   
echo "<input type='hidden' name='protocol' value='$protocol'>";
if ($done == true){
	echo "<input type='hidden' name='min' value='$min'>";
	echo "<input type='hidden' name='max' value='$max'>";
}
echo "<input type='hidden' name='len00' value='$len00'>";
echo "<input type='hidden' name='rawMicros00' value='$rawMicros00'>";
echo "<input type='hidden' name='len55' value='$len55'>";
echo "<input type='hidden' name='rawMicros55' value='$rawMicros55'>";
echo "<input type='hidden' name='lenAA' value='$lenAA'>";
echo "<input type='hidden' name='rawMicrosAA' value='$rawMicrosAA'>";
echo "<input type='hidden' name='lenFF' value='$lenFF'>";
echo "<input type='hidden' name='rawMicrosFF' value='$rawMicrosFF'>";
if ($done == true){
	echo "<b>Test values: </b><br><pre><input type='checkbox' name='do' value='min'> \tmin: $min   \tMAX: $max 
";
} else {
	echo "<b>Test values: </b><br><pre> \tmin: ???   \tMAX: ??? 
"; 
}

echo "
 data00:  len $len00  \trawMicros:  $rawMicros00 
 data55:  len $len55  \trawMicros:  $rawMicros55
 dataAA:  len $lenAA  \trawMicros:  $rawMicrosAA 
 dataFF:  len $lenFF  \trawMicros:  $rawMicrosFF 
 </pre><hr>";
echo "<input type='submit' name='save' value='UPDATE'>&nbsp;&nbsp;&nbsp;<input type='submit' name='more' value=' SKIP '></form>";
echo '<hr><center> <a href="index.html"><<< back </a>  </center><br>';
echo "</BODY></HTML>";

 
 
 
 
 
 
 
?>