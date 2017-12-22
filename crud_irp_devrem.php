<?php
/*
  crud_irp_devrem - This file is part of remoteDBdiscovery.
  
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


$r=dirname(dirname(__FILE__));
include("$r/remoteDBdiscovery/libs/crudClass.php");
require_once ("$r/remoteDB/irp_commonSQL.php");

if (isset($_GET['idremote'])){
   $_POST = $_GET;
   }

echo "<html><head>";
echo StyleSheet();
echo "</head><body>";
// echo"<pre>";print_r($_POST);echo"</pre>";
echo "<h1> Discovery: <b>irp_devrem</b> <i>add/edit/delete records</i></h1>";
//--------------------------------------------------
function crud_action_hook($record){
    $code =  "<form action='./../remoteDB/do_file2remote.php'  mode='GET' >";	   
    $code .= "<input type='hidden' name='remote' value=".$record['idremote'].">";
    $code .= "<input type='hidden' name='code' value=".$record['code'].">";
    $code .= "<input type='hidden' name='protocol' value=".$record['idprotocol'].">";
    $code .= "<input type='submit' name='toFile' style='width:120;' value='EXPORT SHEET'>";
    $code .= "<input type='submit' name='copy' style='width:120;' value='IMPORT SHEET'></form>";
    $code .= "</td><td>";
	$code .=  "<form action='./../remoteDB/usr_rawremote.php'  mode='GET' >";	   
    $code .= "<input type='hidden' name='remote' value=".$record['idremote'].">";
    $code .= "<input type='hidden' name='code' value=".$record['code'].">";
    $code .= "<input type='hidden' name='protocol' value=".$record['idprotocol'].">";
    $code .= "<input type='submit' name='copy' style='width:80; height:84; white-space: normal;' value='RAW CAPTURE' title='This tool captures RAW IR streams'></form>";
   $code .= "</td><td>";
    $code .=  "<form action='./../remoteDB/do_fillupd.php'  mode='GET' >";	   
    $code .= "<input type='hidden' name='remote' value=".$record['idremote'].">";
    $code .= "<input type='hidden' name='code' value=".$record['code'].">";
	$code .= "<small><input type='radio' name = 'do' value='streams'>Verify Streams <br>"; 
	$code .= "<input type='radio' name = 'do' value='device'>Link Device <br>";
	$code .= "<input type='radio' name = 'do' value='both' checked > Both <br>";
    $code .= "<input type='submit' name='go' style='width:120;'  value='EXECUTE' title='Verify streams and links it to device: do it after SHEET import or RAW capture' ></small></form>";
 		$code .= "</td><td>";
		$code .=  "<form action='test_unknown.php'  mode='GET' >";	   
		$code .= "<input type='hidden' name='protocol' value=".$record['idprotocol'].">";
	if (sqlValue("SELECT IRP FROM irp_protocols WHERE idprotocol = ".$record['idprotocol']) === NULL)
		$code .= "<input type='submit' name='copy' style='width:98; height:84; white-space: normal;' value='DISCOVERY PROTOCOL'  title='Test the RAW streams to discovery protocol name and IRP'></form>";
	    else 
		$code .= "<input type='submit' name='copy' disabled style='width:98; height:84; white-space: normal;' value='DISCOVERY PROTOCOL' title='Disabled for known protocols'></form>";
   return $code;
}

// callback for input fields (new)
function crud_get_input($field){
    $code = NULL;
  // custom special cases   
    if ($field == 'iddevice')
          $code ="[<a href='crud_irp_devices.php'>add new</a>] ". crudClass::make_select($field, "SELECT iddevice, concat(iddevice,': ',brand,' ',dev_model ) FROM irp_devices ORDER BY brand") ;    
    if ($field == 'idremote')
          $code = $code ="[<a href='crud_irp_remotes.php'>add new</a>] ". crudClass::make_select($field, "SELECT idremote, concat(idremote,': ',brand,' ',rem_model ) FROM irp_remotes ORDER BY brand") ;  
    if ($field == 'idprotocol')
          $code =$code ="[<a href='crud_irp_protocols.php'>add new</a>] ".  crudClass::make_select($field, "SELECT idprotocol, concat(idprotocol,': ',name) FROM irp_protocols ORDER BY name") ;
   return $code;
}
// callback for edit fields 
function crud_get_edit($field, $value){
   $code = NULL;
   if ($field == 'idprotocol')
          $code = crudClass::make_select($field, "SELECT idprotocol, concat(idprotocol,': ',name) FROM irp_protocols ORDER BY name", $value);
   return $code;
}
//callback for show fields (view)
function crud_get_show($field, $value) {
     $code = NULL;
 // special cases     
     if ( ($field == 'iddevice')){
          $code = "$value: <a href='crud_irp_devices.php?edit=yes&$field=$value'>".sqlValue("SELECT concat(brand,' ',dev_model ) FROM irp_devices WHERE $field = $value")."</a>";
         }      
    if ( ($field == 'idremote')){
           $code = "$value: <a href='crud_irp_remotes.php?edit=yes&$field=$value'>".sqlValue("SELECT concat(brand,' ',rem_model ) FROM irp_remotes WHERE $field = $value")."</a>";
        }      
    if ( ($field == 'idprotocol')){
            $code = "$value: <a href='crud_irp_protocols.php?edit=yes&$field=$value'>".sqlValue("SELECT name FROM irp_protocols WHERE $field = $value")."</a>";
       }      
         
    return $code;
}
// --------------------------------------------------

$crud = new crudClass('irp_devrem','idremote,code,iddevice,idprotocol,mode1,mode2,mode3,notes','iddevice,code,idremote' );// Initiate the class

if (isset($_POST['submit'])){
    $create_sql = $crud->create();//Fetch INSERT query
    sql($create_sql);
}

if (isset($_POST['update'])){
    $update_sql = $crud->update();//Fetch UPDATE query
   sql($update_sql);
}
if (isset($_POST['delete'])){
    $delete_sql = $crud->delete();//Fetch DELETE query
    sql($delete_sql);
}

if (isset($_POST['edit'])){
// edit
    echo "<div class='note' align='right'>";
    echo $crud->renderEditor();//Prepare data edit form
    echo '</div>' ;
    } else {
// or insert   
    echo "<div class='note' align='right'>";
    echo $crud->create_form();//Prepare data entry form
    echo '</div>';
    }
 // table   
echo $crud->renderVertically();// SHOW data table
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo "</body></html>";
?>
