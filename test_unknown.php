<?php
/*
  test_unknown.php - This file is part of remoteDBdiscovery.

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

//
echo "<HTML><HEAD>";
echo StyleSheet();
echo "</HEAD><BODY>";
if (isset($_GET['newprotocol'])) {
// echo "<pre>"; print_r($_GET); echo "</pre>";
/* 
   [newprotocol] => 2
    [protocol] => 4
*/
  $protocol = $_GET['protocol'];
  $newprotocol = $_GET['newprotocol'];
  $name = sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $protocol");
  $newname = sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $newprotocol");
  echo "1) unlink devices...<br>";
  $idstreams = sqlArray("SELECT idstream FROM irp_streams WHERE idprotocol = $protocol");
  foreach ($idstreams as $ids){
     sql("DELETE FROM irp_devcommands WHERE idstream = $ids ");
     }
 
  echo "2) merge streams...<br>";
  foreach ($idstreams as $ids){
     $crc = sqlValue("SELECT CRCRAW FROM irp_streams WHERE idstream = $ids LIMIT 1");
	 $idnew = sqlValue("SELECT idstream FROM irp_streams WHERE CRCRAW = '$crc' AND idprotocol = $newprotocol LIMIT 1");
     if ($idnew == NULL){
			 sql("UPDATE irp_streams SET CRCRAW = NULL, idprotocol =  $newprotocol WHERE idstream = $ids");
		 }
		 else {
			 sql("DELETE FROM irp_streams WHERE idstream = $ids LIMIT 1");
			 sql("UPDATE irp_remcommands SET idstream = $idnew WHERE idstream = $ids");
		 } 
	 }
  echo "3) UPDATE irp_devrem...<br>";
     sql("UPDATE irp_devrem SET idprotocol =  $newprotocol WHERE idprotocol =  $protocol");
/*	 
echo "4) delete protocol $name...<br>";
	   sql("DELETE FROM irp_protocols WHERE idprotocol =  $protocol LIMIT 1");
	   sql("DELETE IGNORE FROM protocol_data WHERE idprotocol =  $protocol LIMIT 1");
 */
  echo "5) TODO:<br><A href='test_fillUpd.php'>Fill/update tool: completes IR streams data and update Device tables</A>"; 
  echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
  echo '</BODY></HTML>';
  exit;
}
//
if (isset($_GET['protocol'])) 
    $protocol = $_GET['protocol'];
else {
echo "<h1> Discovery new streams </h1>";
echo "<div class='note'> <form action='test_unknown.php' mode='GET'>
                    Choose protocol (verified):
                    <select name='protocol'>";
echo  optionsList('SELECT DISTINCT irp_protocols.idprotocol, name FROM irp_protocols, irp_streams WHERE    irp_protocols.idprotocol = irp_streams.idprotocol AND CRCRAW IS NOT NULL ORDER by name;');					
echo " </select><hr>";
echo " <input type='submit' value='execute test'>
                </form></div><br>";
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo '</BODY></HTML>';
exit;
}

if (!isset($_GET['idstream']) ||($_GET['idstream'] == $_GET['idstream2'])) {
$protocol = $_GET['protocol'];
$name = sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $protocol");

echo "<h1> Test RAW streams from protocol $name  </h1>";
echo "<div class='note'><form action='test_unknown.php' mode='GET'>
                    Choose 2 different streams:
                    <select name='idstream'>";
echo  optionsList("SELECT idstream, CRCRAW FROM irp_streams WHERE idprotocol = $protocol AND CRCRAW IS NOT NULL");					
echo " </select> &nbsp;&nbsp;&nbsp;&nbsp;<select name='idstream2'>";
echo  optionsList("SELECT idstream, CRCRAW FROM irp_streams WHERE idprotocol = $protocol AND CRCRAW IS NOT NULL");
echo " </select>          <select name='tolerance'><option value=1.01> 1 %</option>
                                                   <option value=1.02> 2 %</option> 
 												   <option value=1.05> 5 %</option> 
												   <option value=1.08> 8 %</option> 
												   <option value=1.12> 12 %</option> 
												   <option value=1.16> 16 %</option> 
												   <option value=1.20> 20 %</option> 
												   <option value=1.30> 30 %</option> ></select>
												   <hr>";
echo "<input type='hidden' name='protocol' value='$protocol'>";
echo "                    <input type='submit' value='execute test'>
                </form></div>";
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo '</BODY></HTML>';
exit;
}
// ------------------------------------- test code

$protocol = $_GET['protocol'];
$idstream = $_GET['idstream'];
$idstream2 = $_GET['idstream2'];
$tolerance = $_GET['tolerance'];
//
$name = sqlValue("SELECT name FROM irp_protocols WHERE idprotocol = $protocol");

echo "<h1> Test RAW streams from protocol $name  </h1> <hr>";

$rawk1 = sqlValue("SELECT RAW1 FROM  irp_streams WHERE idstream = $idstream" );
$tmp = explode('}', $rawk1);
$parts = explode(',',$tmp[0]);
$base = $parts[1];
$len1 = $parts[2];
$times = explode('|',$tmp[1]);
$min = 1000000000;
$max = 0;
$tot1 = 0;
$done = false;
foreach($times as $i => $value)
     if (irp_isInRange($i, $len1)) { 
       $x = abs($value)*$base;
	   $done = true;  
 	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
	   $tot1 += $x;
       }
echo "<b>raw stream #1:</b><pre> \tlen1 = $len1 \tmin = $min \tmax = $max \tRAWms1 = $tot1</pre>";
//
$rawk2 = sqlValue("SELECT RAW1 FROM  irp_streams WHERE idstream = $idstream2" );
$tmp = explode('}', $rawk2);
$parts = explode(',',$tmp[0]);
$base = $parts[1];
$len2 = $parts[2];
$times = explode('|',$tmp[1]);
$tot2 = 0;
foreach($times as $i => $value)
   if (irp_isInRange($i, $len2)) { 
       $x = abs($value)*$base ;
	   if ($x < $min)  $min = $x;
 	   if ($x > $max)  $max = $x;
	   $tot2 += $x;
       }
echo "<b>raw stream #2:</b><pre> \tlen2 = $len1 \tmin = $min \tmax = $max \tRAWms2 = $tot2 </pre>";

// tolerances
$t1 = ($min * $tolerance) - $min;
$t2 = ((($tot1 + $tot2) * $tolerance) - $tot1 - $tot2)/2;

if ($len1 == $len2){		  // variable space, variable mark, variable mark space
		  $result = sqlArrayTot("SELECT idprotocol, name, IRP, minLEN, maxLEN, minRAWms, maxRAWms, min, MAX FROM  view_protocoldata WHERE minLEN = maxLEN AND minLEN = $len1 AND minRAWms <= ($tot1+$t2)  AND minRAWms <= ($tot2+$t2)  AND maxRAWms >= ($tot1-$t2)  AND maxRAWms >= ($tot2-$t2)  AND min <= ($min+$t1) AND MAX >= ($max-$t1) ");
		  }
else 
          {
		  $result = sqlArrayTot("SELECT idprotocol, name, IRP, minLEN, maxLEN, minRAWms, maxRAWms, min, MAX  FROM  view_protocoldata WHERE minLEN != maxLEN AND minLEN <= $len1 AND minLEN <= $len2 AND maxLEN >= $len1 AND maxLEN >= $len2 AND minRAWms <= ($tot1+$t2)  AND minRAWms <= ($tot2+$t2)  AND maxRAWms >= ($tot1-$t2)  AND maxRAWms >= ($tot2-$t2)  AND min <= ($min+$t1) AND MAX >= ($max-$t1) ");
		  }
// echo "<pre>"; print_r($result); echo "</pre>";	 
echo "<hr>";
for ( $i=0; $i < count($result); $i++){
 $mess = "<H2> test ".$result[$i]['name']."</H2>";
 $mess .= "<H4> ".$result[$i]['IRP']."</H4>";
 //
 $myprotocol =  new irp_protocol($result[$i]['IRP']);
 $x1 = $myprotocol->decodeRaw($rawk1); 
 $mess2 = "<b>TEST #1:</b>";
 $r1 =$myprotocol->dataVerify(false);
 $mess2 .='<pre>' . $myprotocol->dataVerify(true) . '</pre>';
 $x1 = $myprotocol->decodeRaw($rawk2); 
 $mess2 .="<b>TEST #2:</b>";
 $r2 =$myprotocol->dataVerify(false);
 $mess2 .='<pre>' . $myprotocol->dataVerify(true) . '</pre>';
 //
 $tmp1 = irp_explodeVerify($r1);
 $tmp2 = irp_explodeVerify($r2);
 $ok = $tmp1['dataOK'] == 'true' && $tmp2['dataOK'] == 'true';
 if (!$ok) 
      echo "<div style='color:red'>";
 else	  
      echo "<div style='color:blue'>";
 echo $mess."</div>";
 // echo "<pre> \tminLen = ".$result[$i]['minLEN']." \tmaxLen = ".$result[$i]['maxLEN']." \tmin = ".$result[$i]['min']." \tmax = ".$result[$i]['MAX']."  \tminRAWms = ".$result[$i]['minRAWms']." \tmaxRAWms = ".$result[$i]['maxRAWms']."  </pre>";
 if ($ok)  
    echo $mess2;
 else
    $result[$i]['idprotocol'] = -1;
 }
$options = '';
for ( $i=0; $i < count($result); $i++){
     if($result[$i]['idprotocol'] > 0){
	     $options .=  "<option value='".$result[$i]['idprotocol']."'  >".$result[$i]['name']."</option>\n";    
     }
} 
echo " <hr><form action='test_unknown.php' mode='GET'>";
echo "<div style='color:blue'><big> &nbsp; &nbsp;  &nbsp;  Found? If yes, replace the protocol <b>$name</b> with:&nbsp;</big>";
echo "<select name='newprotocol'>".$options."</select> <big>&nbsp; &nbsp; &nbsp;</big>"; 
echo "<input type='hidden' name='protocol' value='$protocol'>";
echo " <input type='submit' value='execute'></div>"; 
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo '</BODY></HTML>';
exit;		  
