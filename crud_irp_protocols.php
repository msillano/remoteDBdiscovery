<?php
/*
  crud_irp_protocols - This file is part of remoteDBdiscovery.
  
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

if (isset($_GET['idprotocol'])){
   $_POST = $_GET;
   }

echo "<html><head>";
echo StyleSheet();
echo "</head><body>";
// 
// echo "<pre>"; print_r($_POST); echo "</pre>"; 
echo "<h1> Table <b>irp_protocols</b>: <i>add/edit/delete records</i></h1>";
//--------------------------------------------------

//callback for show fields (view)
function crud_get_show($field, $value) {
     $code = NULL;
 // special cases    
     if ($field == 'prt_url'){
	 	  $url = str_replace ('./doc', './../remoteDB/doc', $value);  // relative url correction 
          $code = "<A href='$url' target='_blank' >$value</A>" ;
         }      
     return $code;
}

// --------------------------------------------------
// Initialize the class with table information:
$crud = new crudClass('irp_protocols','name,IRP,prt_url,phpadapter,notes','idprotocol' );

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
echo $crud->renderVertically(' ORDER BY name');// SHOW data table
echo '<hr><center> <a href="javascript:history.go(-1)"><<< back </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="discovery.html">discovery</a> </center><br>';  
echo "</body></html>";

?>
