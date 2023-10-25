<?php
function whoIsThatLevel($user_id, $except="none"){
	if(check_login()){
		$res = db_element('user_data', $user_id, 'rank');
		if($res==true){
			if($res=="1"){
				if($except!="lid"){
					return "Lid";
				}else{ return false; }
			}elseif($res=="2"){
				return "Administrator";
			}
		}else{ return false; }
	}else{ return false; }
}
function isUserAuthorized($sectionlevel){
    if(check_login()){
		$userlevel = intval(db_element("login",myID(),"rank"));
		return($userlevel & $sectionlevel) > 0 ;
	}else{ return false; }
}
/* verschillende gebruiker niveaus binnen de applicatie */
define("POSTER", 1 );
define("ADMIN", 2 );

/* verschillende secties binnen de applicatie met bijbehorende autorisatie niveaus */
/* Administratie Systeem */
define("Administratie",			POSTER + ADMIN );
define("addBlog",				POSTER );
define("editBlog",				POSTER );
define("editOthersBlog",		ADMIN );
define("deleteBlog",			POSTER );
define("deleteOthersBlog",		ADMIN );

?>