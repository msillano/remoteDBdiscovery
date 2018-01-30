<?php
/*
  crud_irp_protoclodata - This file is part of remoteDBdiscovery.
  
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
//echo "<pre>"; print_r($_POST); echo "</pre>"; 
// ================================================= update here for new crud page
echo "<h1> Table <b>irp_protocoldata</b>: <i>add/edit/delete/verify records</i></h1>";

$crud = new crudClass('irp_protocoldata','idprotocol,base_time,coding','idprotocol' );// Initiate the class with table information
//--------------------------------------------------
// add action verify/update record using test_dataprotocols.php
function crud_action_hook($record){
    $code =  "<td><form action='test_dataprotocols.php'  mode='GET'>";	   
    $code .= "<input type='hidden' name='protocol' value=".$record['idprotocol'].">";
    $code .= "<input type='submit' value='verify/update'></form></td>";
    return $code;
}
// callback for input fields (new)
function crud_get_input($field){
  $code = "$field: <input type='text' name='$field' /><br>";
  // custom special cases    
  if ($field == 'idprotocol'){
          $code = crudClass::make_select($field, "SELECT irp_protocols.idprotocol, concat(irp_protocols.idprotocol,': ',name) FROM irp_protocols LEFT JOIN irp_protocoldata ON irp_protocols.idprotocol = irp_protocoldata.idprotocol WHERE irp_protocoldata.idprotocol IS NULL AND IRP IS NOT NULL ORDER BY name") ;
         }      
  if ($field == 'coding'){
          $code = crudClass::make_select4list($field,"VARIABLE SPACE,VARIABLE PHASE,VARIABLE MARK,VARIABLE MARK SPACE,ASYNC",'VARIABLE SPACE');
          }      
  return $code;
}
// callback for input fields (edit)

function crud_get_edit($field, $value){
  $code = "$field: <input type='text' name='$field' value='$value' /><br>";
   // custom special cases    
  if ($field == 'idprotocol'){
         $code = "$field (PK): <input type='text' name='$field' value='$value: ".sqlValue("SELECT name FROM irp_protocols WHERE $field = $value")."'  disabled /><br>";   // is the unique PK
         }      
  if ($field == 'coding'){
         $code = crudClass::make_radio($field,'VARIABLE SPACE,VARIABLE PHASE,ASYNC,VARIABLE MARK,VARIABLE MARK SPACE', $value);
         }      
  return $code;
} 

//callback for show fields (view)
function crud_get_show($field, $value) {
     $code = $value;
 // special cases    
    if ( ($field == 'idprotocol')){
            $code = "$value: <a href='crud_irp_protocols.php?edit=yes&$field=$value'>".sqlValue("SELECT name FROM irp_protocols WHERE $field = $value")."</a>";
       }      
     return $code;
}
// ======================================================= ends update

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

// special condition for show add form:
$newNumber  = sqlValue("SELECT COUNT(*) FROM irp_protocols LEFT JOIN irp_protocoldata ON irp_protocols.idprotocol = irp_protocoldata.idprotocol WHERE irp_protocoldata.idprotocol IS NULL AND IRP IS NOT NULL");

if (isset($_POST['edit'])){
//  edit
    echo "<div class='note' align='right'>";
    echo $crud->renderEditor();//Prepare data edit form
    echo '</div>' ;
    } else {
// or insert (only if $newNumber >0) 
    if  ($newNumber >0) {
      echo "<div class='note' align='right'>";
      echo $crud->create_form();//Prepare data entry form
      echo '</div>';
      } else {
      echo "<div class='note' align='center'>";
      echo "Any <code>irp_protocols</code> protocol is with the related record in <code>irp_protocolsdata</code>.<br> ";
      echo "Nothing to do. <b>Create NEW record disabled.</b><br>";
      echo '</div>';
      }
    }
	
 // SHOW data table, order by protocol name 
echo $crud->renderVertically(' NATURAL JOIN irp_protocols ORDER BY name');
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo "</body></html>";

?>
