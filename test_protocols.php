<?php
/*
  test_protocols - This file is part of remoteDBdiscovery.
  
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
$protocol = 'JVC'; // change default here to run this alone
$number   = 1; // number of stream repetitions
if (!isset($_GET['protocol'])){
echo "<HTML><HEAD></HEAD><BODY>";
echo StyleSheet();
echo " <h1>  Test protocol </h1>
 <div class='note'><form action='test_protocols.php' mode='GET'>
                    Choose protocol:
                    <select name='protocol'>";
echo  getProtocolsOptionList();					
echo " </select> &nbsp;&nbsp;&nbsp;&nbsp; data:  ";
echo "<input type='text' name='datax'></input> &nbsp;&nbsp;&nbsp;&nbsp;  repeat: <select name='times'>";
echo  optionsNList(1, 5, 1)	;			
echo " </select><hr>";
echo "<input type='submit' value='execute test'></form></div>";
echo '<hr><center> <a href="index.html"><<< back </a> </center>';
echo '</BODY></HTML>';
exit;
	
}
// ======================================  test code ==========

echo '<HTML><HEAD></HEAD><BODY>';
echo StyleSheet();
$data = trim($_GET['datax']);
$protocol = $_GET['protocol'];
$times = $_GET['times'];
$theprotocol = sqlRecord("SELECT * FROM irp_protocols WHERE idprotocol = $protocol");
echo "<h1>  Test protocol ".$theprotocol['name']." </h1>";

if ( strlen($data)< 2 || !(ctype_xdigit($data) ||  (irp_getRMatchBrace($data, '{', 0,'}') !== false))) {
	echo "<div class= 'error'> Bad <i>data</i> value. <br> Data must be <i>HEX:</i>  '3A3B00F' or <i>data-set:</i> '{D=35, F=0x2A}' </div>";
	echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a> </center>';
	echo '</BODY></HTML>';
	exit;
}
if ($theprotocol['IRP'] == NULL) {
	echo "<div class= 'error'> Protocol without IRP. <br> Only for RAW learning mode. </div>";
	echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a> </center>';
	echo '</BODY></HTML>';
	exit;
}



if ($theprotocol['notes'] != NULL){
echo "<div class='note'><i>".$theprotocol['notes']."</i></div><br>";
}

echo "<hr> ==== PROTOCOL INFOS by toString() ====<br>";
// create object
$aProtocol = new irp_protocol($theprotocol['IRP']);
// prints some infos about protocol
$aProtocol->toString();
// data name

echo '<br>==== ENCODE: RAW output from encodeRaw(): <br>';
$raw1 = $aProtocol->encodeRaw($data, $times); //  RAW is default
print('RAW   = ' . $raw1 . '<br>');
echo '<br>==== ENCODE: RAW output compressed by RAWprocess(): <br>';
$raw2 = $aProtocol->RAWprocess($raw1,0);
print('<b>RAW-0 = ' . $raw2 . '</b><br>');
$raw_1 = $aProtocol->RAWprocess($raw1,1);
print('<span style="color:blue">RAW-1 = ' . $raw_1 . '</span><br>');
print('RAW-2 = ' . $aProtocol->RAWprocess($raw1, 2) . '<br>');
echo '<br>==== ENCODE: statistics (<i>note: uses only samples in range</i> [4..-8])<br>';
$items = explode('|', $raw2);
$len = count($items);
if ($len >  4){
	$min = abs($items[4]);
	$max = abs($items[4]);
	}
 $done = false;
 foreach($items as $i => $value)
     if (irp_isInRange($i, $len)) { 
       $x = abs($value);
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
       }
echo "Total time by irp_rawMicros() = ".irp_rawMicros($raw2)."<br>";
if ($done == true){
    echo "Sample min.        = $min<br>";
    echo "Sample max.        = $max<br>";
}

echo '<br>==== ENCODE: user data  <br>';
echo 'DATA = ' . $data . '<br>';
$aProtocol->resetData(); // in case of permanence, restart
$out1 = $aProtocol->decodeRaw($raw_1);
$aProtocol->resetData(); // in case of permanence, restart
$out = $aProtocol->decodeRaw($raw2);
echo '<br>==== DECODE: RAW output by decodeRaw(), using RAW_1 as input:<br>';
print('DATA = <span style="color:blue">' . $out1 . '</span><br>');
echo '<br>==== DECODE: RAW output by decodeRaw(), using RAW_0 as input:<br>';
print('DATA = <span style="color:blue">' . $out . '</span><br>');
echo '<br>==== DECODE: dataVerify(true) - verbose output:<br>';
echo '<pre>' . $aProtocol->dataVerify(true) . '</pre>';
echo '<br>==== COMPARISON ENCODE/DECODE BIN<br>';
// now output mode BIN:
$aProtocol->setOutputBin();
// get DECODE again with output bin
$aProtocol->resetData(); // in case of permanence, restart
$bin2 = $aProtocol->decodeRaw($raw2);
// get ENCODE again with output bin
$aProtocol->resetData(); // in case of permanence, restart
$bin = $aProtocol->encodeRaw($data, $number);
print('<pre>E-BIN   = ' . $bin . '<br>');
print('D-BIN   = ' . $bin2 . '<br>');
// transform BINs using RAWprocess()
print('E-BIN-0 = ' . $aProtocol->RAWprocess($bin, 0) . '<br>');
print('D-BIN-0 = ' . $aProtocol->RAWprocess($bin2, 0) . '<br>');
print('E-BIN-1 = <span style="color:blue">' . $aProtocol->RAWprocess($bin, 1) . '</span><br>');
print('D-BIN-1 = <span style="color:blue">' . $aProtocol->RAWprocess($bin2, 1) . '</span><br>');
print('E-BIN-2 = ' . $aProtocol->RAWprocess($bin, 2) . '<br>');
print('D-BIN-2 = ' . $aProtocol->RAWprocess($bin2, 2) . '</pre><br>');
echo '<hr><center> <a href="index.html"><<< back </a> </center><br>';

echo '</BODY></HTML>';
?>