<?php
function check_login(){
	if(isset($_SESSION['logged_in']) && isset($_SESSION['logged_id']) && ($_SESSION['logged_in']==TRUE) && (is_numeric($_SESSION['logged_id']))){
		$sql = "SELECT * FROM `login` WHERE `id`='".$_SESSION['logged_id']."'"; 
		$res = mysql_query($sql); 
		$fetch = mysql_fetch_assoc($res);
		if((mysql_num_rows($res) == 1)){
			return $fetch['user'];
		}else{ return false; }
    }else{ return false; }
}
function myID(){
 	if(check_login()==TRUE){
		$sql = "SELECT * FROM `login` WHERE `id`='".$_SESSION['logged_id']."'";
		$res = mysql_query($sql); 
		$fetch = mysql_fetch_assoc($res); 
		if((mysql_num_rows($res) == 1)){
			return $fetch['id'];
		}else{ return false; }
	}else{ return false; }
}
function db_element($table, $id, $element){
	if(!empty($table) && !empty($element) && is_numeric($id)){
		$sql = mysql_query("SELECT * FROM `".$table."` WHERE `id`='".$id."'");
		$fetch = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)!=0){
			return htmlentities($fetch[$element]);
		}else{ return false; }
	}else{ return false; }
}
function checkmail($mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
		$explode = explode("@", $mail);
		$explode2 = explode(".", $explode);
		
		$personal = $explode['0'];
		$host = $explode2['0'];
		$tld = $explode2['1'];
		
		$preg1 = preg_match("/^\w[-.\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/", $personal);
		$preg2 = preg_match("/^\w[-.\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/", $host);
		if($preg1 || $preg2 || $tld=="nl"){
			return 1;
		}else{
			return 0;
		}
    }else{ return 0; }
}
function error_msg($err_type, $err_msg, $err_file, $err_line){
	echo '<strong>Error:</strong><br />';
	echo 'Onze excuses, Maar is helaas een fout opgetreden op deze pagina.<br />';
	echo 'Probeer het later nog eens!<br />';
	echo '<br />';
	echo 'Foutmelding '.$err_type.': '.$err_msg.' in '.$err_file.' op regel '.$err_line;
	echo '<hr />';
}
set_error_handler("error_msg");
?>