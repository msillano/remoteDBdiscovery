<?php
/*
  crud_irp_devices - This file is part of remoteDBdiscovery.
  
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

$d=dirname(dirname(__FILE__));                      // this file is in     www/remoteDBdiscovery/, %d is www
include("$d/remoteDBdiscovery/libs/crudClass.php"); // crudClass is in     www/remoteDBdiscovery/libs/
require_once ("$d/remoteDB/irp_commonSQL.php");     // irp_commonSQL is in www/remoteDB/

if (isset($_GET['iddevice'])){         // so works with POST (used by crudClass) and GET
   $_POST = $_GET;
   }
echo "<html><head>";
echo StyleSheet();
echo "</head><body>";

echo "<h1> Table <b>irp_devices</b>: <i>add/edit/delete records</i></h1>";       // title
//-------------------------------------------------- optional customizations
// hook for add actions in table
function crud_action_hook($record){
// add action 'verify/update' to $record using test_dataprotocols.php must be a "<td><form...>...</form></td>")
    $code =  "<td><form action='test_dataprotocols.php'  mode='GET'>";	   
    $code .= "<input type='hidden' name='protocol' value=".$record['idprotocol'].">";
    $code .= "<input type='submit' value='verify/update'></form></td>";
    return $code;
}
//callback for input fields (new)
function crud_get_input($field){
  $code = "$field: <input type='text' name='$field' /><br>";   // default
  // custom special cases   
  if ($field == 'brand'){
          $code = crudClass::make_select($field, "SELECT brand, brand FROM irp_brands") ;  // select
         }        
  return $code;
}
//callback for show fields (view)
function crud_get_show($field, $value) {
     $code = $value;        // default
   // custom special cases   
     if ($field == 'dev_url'){
          $code = "<A href='$value' target='_blank' >$value</A>" ;  // a link
         }      
    return $code;
}
// -------------------------------------------------- end optional

$crud = new crudClass('irp_devices','brand,dev_model,kind,dev_url,group,status,photo,dicon,description','iddevice' );          // Initialize the class with table information
// -------------------------------------------------- actions 
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
//-------------------------------------------------- the page
if (isset($_POST['edit'])){
// edit
    echo "<div class='note' align='right'>";
    echo $crud->renderEditor();     // data edit form
    echo '</div>' ;
    } else {
// or insert    
    echo "<div class='note' align='right'>";
    echo $crud->create_form();     // data entry form
    echo '</div>';
    }
 // table   
echo $crud->renderVertically();    // SHOW data table
//
echo '<hr><center> <a href="index.html"><<< back </a> </center><br>';
echo "</body></html>";

?>
