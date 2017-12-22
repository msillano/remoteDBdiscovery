<?php
/*
  crudClass is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public
  License as published by the Free Software Foundation; either
  version 2 of the License, or (at your option) any later version.

  crudClass is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public
  License along with this library; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * Author: Mahbub (2016-05-09)
 * Author URI: mahboobz.com
 * from: https://www.phpclasses.org/package/9761-PHP-Generate-SQL-and-forms-to-perform-CRUD-operations.html
 *
 * modified by m.sillano (08/08/2017) for use with remoteDB:
 *        - use of irp_commonSQL.php for unified DB access
 *        - added $this->index array to store one or more PK names (in place of one pre-defined 'id')
 *        - added get_where(), get_hidden($record) to handle multiple PKs
 *        - added optional hook and callback to customize the CRUD page:
 *                1) special input fields: select, radio... (crud_get_input)
 *                2) special edit fields: select, radio... (crud_get_edit)
 *                3) special show fields: links, references... (crud_get_show)
 *                4) more actions in table (crud_action_hook)
 *        - added 3 static utility: make_select, make_radio and make_checkbox for input/edit fields
 *        - added CONFIRM to delete
 *        - added $extrasql parameter to renderVertically(), 
 *                       it extends the basic sql: "SELECT * FROM ".$this->table 
 *        - cosmetic minor variations, use of css/style.css
 *        - if a field name is equal to a mySQL reserved name, must use the (`) for fields
 *
 *  As examples of the use of modified crudClass see all sources crud_irp_xxxxxxxx.php in dir remoteDBdiscovery.
 */
$d =  dirname(dirname(dirname(__FILE__)));     // this is in www/remoteDBdiscovery/libs, $d = www    
require_once ("$d/remoteDB/irp_commonSQL.php");

class crudClass {
    
    /*
     * @var $table string : table name
     */
    public $table;

    /*
     * @var $raw_fields string : columns name (no pk))
     */
    public $raw_fields;

    /*
     * @var $fields array : columns name array
     */
    public $fields = array();
    
    /*
     * @var $index array : all PK names
     */
    public $index= array();
    
/*
* modified: added $pk primary keys list, and $this->index array
* Rules: 
*   if PK is only one field and it is autoincrement:  NO PK in fields list, YES PK in $pk 
*   if PK is only one field and not autoincrement:    YES PK in fields list, YES PK in $pk 
*   if PK is more than one field (not autoincrement): YES all PKs in fields list, YES all PKs in $pk list as 'pk1,pk2...'
*  note: $fields can be partial, you can omit fields with mySQL defaults or NULL
*/
   public function __construct($table, $fields, $pk){
        $this->table = $table;
        $this->raw_fields = $fields;
        $this->fields = explode(',', $fields);
        $this->index = explode(',', $pk);   // added
   }

 // new: static utility, generates code for HTML select, to be used in callback 
 // the $sql query must generate a list of keys, values. Optional $selected is a key or a value. 
   public static function make_select($field, $sql, $selected = NULL){
      $code = "$field: <select name='$field'>";
      $code .= optionsList($sql, $selected);
      $code .= '</select><br>';
      return ($code);
   }
   
 // new: static utility, generates code for HTML select, to be used in callback 
 // the $optionlist is a string list of values == keys. Optional $selected is a value. 
   public static function make_select4list($field, $optionlist, $selected = NULL){
      $code = "$field: <select name='$field'>";
      $options =  explode(',', $optionlist);  
	  foreach($options as $value){
        $code .= "<option value='$value' ".(($selected == $value)?'selected = "selected" ':'').">$value</option>\n";
        }
      $code .= '</select><br>';
      return ($code);
   }
    
 // new: static utility, generates code for HTML radio, to be used in callback 
 // the $optionlist is a string list of values. Optional $checked is a value. 
   public static function make_radio($field, $optionlist, $checked = NULL){
      $options =  explode(',', $optionlist);  
	  $code = "$field: &nbsp;";
	  foreach($options as $radio){
	      $code .= "<input type='radio' name='$field' ".(($checked == $radio)?"checked='true' ":"")."value ='$radio'/> $radio &nbsp;&nbsp;";
	  }
      return ($code."<br>");
   }
   
 // new: static utility, generates code for HTML checkbox, to be used in callback
 //  the $sql query must generate a list of keys, values. $checked is an array of values or true or false.  
   public static function make_checkbox($field, $sql, $checked = false){
        return checkList($sql, $field, $checked)."<br>";   
   }

 // new: all hidden fields required by get_where() (values from $record)
   private function get_hidden($record){
        $hidden='';
        foreach($this->index as $pk){
             $hidden .= "<input type='hidden' name='$pk' value='".$record[$pk]."' />";
        }
        return $hidden;
    }
    
 // new: makes a WHERE string to select one record, single or multiple PK (values on _POST) for read()  
   private function get_where(){
        $update_where = array();
        foreach($this->index as $pk){
                  $update_where[] = "`$pk`='".$_POST[$pk]."'";
        }
      return "WHERE ".implode(" AND ", $update_where);
    }
	
// new: true if $field is PK (if it is in $this->index)  	
   public function isPK($field){
     return in_array( $field, $this->index);
    }
    /*
     * create function is used to create new record using only fields in $fields
	 * modified: NULL in case of '', to use mySQL defaults
     * */
   public function create(){
        $post_fields = array();
        foreach($this->fields as $field){
                $post_fields[] = (($_POST[$field] == '')?'NULL':"'".$_POST[$field]."'");
        }
        $values = implode(",", $post_fields);// Form Post values to Insert
		$ifields = implode("`,`",$this->fields);
        $create_sql = "INSERT into `".$this->table."` (`".$ifields."`) VALUES ($values)";
        return $create_sql;
        }
            
    /*
     * read function is used to read rows of the table
     * additionally it takes WHERE clause value as $where variable
     * */
   public function read($where = ''){
        $read_sql = "SELECT * FROM `".$this->table."` ".$where;
        return $read_sql;
    }
    /*
     * update function is used to update a row
	 * modified: NULL in case of '', to use mySQL defaults
     * */
   public function update(){
        $update_array = array();
        foreach($this->fields as $field){
            $update_array[] = "`$field` = ".(($_POST[$field] == '')?'NULL':"'".$_POST[$field]."'");
            }
        $values = implode(", ", $update_array);// Form Post values to update
        $update_sql = "UPDATE `".$this->table."` SET $values ". self::get_where()." LIMIT 1";
        return $update_sql;
    }

    /*
     * delete function is used to delete a row
     * */
    public function delete(){
        $delete_sql = "DELETE FROM `".$this->table."` ". self::get_where()." LIMIT 1";
        return $delete_sql;
    }
        
    /*
     * create_form function is used to develop a form for NEW record according to given attributes
	 * modified: added optional crud_get_input() function to format special inputs
     * */
    public function create_form(){
        $form = '<form method="post" action="crud_'.$this->table.'.php">';      
        foreach($this->fields as $field){
            if (function_exists('crud_get_input')  && ( $user = call_user_func('crud_get_input', $field))) 
			  $form .= $user;
            else    // default
              $form .= "$field: <input type='text' name='$field' /><br>";
            }
        $form .= '<hr><input type="submit" name="submit" value="NEW RECORD"/> </form>';
        return $form;
    }
  
    /*
     * renderVertically function is used to show records in table
 	   * modified: added optional crud_get_show() function to format special fields
  	 * modified: added optional crud_action_hook() function to add more action buttons
  	 * modified: added 'confirm popup' to delete button
	   * modified: added optional $extrasql (extends the basic sql: "SELECT * FROM ".$this->table )
     * */
  public function renderVertically($extrasql = ''){
        $result = sqlArrayTot(self::read($extrasql));
        $render = '<table >';
        $render .= '<tr>';
        foreach($this->fields as $field){        
            $render .= '<th>'.$field.'</th>'; // cosmetic modifications: td changed in th, removed ucfirst
        }
        $render .='<th><i>action</th></i></tr>';
        foreach($result as $record){
            $render .= '<tr>';
            foreach($this->fields as $field){
                if (function_exists('crud_get_show')&& ( $user = call_user_func('crud_get_show', $field, $record[$field]))) 
					   $render .= '<td>'.$user.'</td>';
                else  // standard
                       $render .= '<td>'.$record[$field].'</td>';
               }
            $render .= '<td><table><tr><td><form method="post" action="crud_'.$this->table.'.php" >';
            $render .=  self::get_hidden($record);   // pk data
            $render .= '<input type="submit" style="width:70;" name="edit" value="EDIT"/>';
            $render .= '<input type="submit" style="width:70;" name="delete" value="DELETE" onclick="return confirm(\'WARNING: not safe delete!\nAre you sure?\');" />';
            $render .= '</form></td>';
            if (function_exists('crud_action_hook'))            // this hook is for special actions on record. 
                $render .= '<td>'.call_user_func('crud_action_hook',$record).'</td>'; //see crud_irp_devrem.php
            $render .= '</tr></table></td>';
            $render .='</tr>';
        }
        $render .='</table>';
        return $render;
    }

    /*
     * renderEditor function is used to make the row edit form
	 * modified: added optional crud_get_edit() function to format special fields
	 * modified to handle more than one PK
	 * note: if field is PK, the input is disabled (but added as hidden): user can't edit PK
     * */
    public function renderEditor(){
        $record = sqlRecord(self::read(self::get_where()));
		$render = '';
        $render .= '<form method="post" action="crud_'.$this->table.'.php">';
        $addhidden = true;
        foreach($this->fields as $field){
                if (function_exists('crud_get_edit') && ( $user = call_user_func('crud_get_edit', $field, $record[$field]))) 
					   $render .= $user;
                else    
				   //default: htmlspecialchars to allow (") in values, PKs disabled (no edit)
                      $render .= $field.': <input type="text" name="'.$field.'"  value="'.htmlspecialchars( $record[$field]).'"'.(self::isPK($field)?' disabled ':'').'/><br>';  
            }
        $render .= self::get_hidden($record);  // adds, hidden PKs fields to select record
        $render .= '<hr><input type="submit" name="update" value="UPDATE"/>';
        $render .= '</form>';         
        return $render;
    }
}