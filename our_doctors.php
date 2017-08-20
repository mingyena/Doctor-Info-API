<?php
/*
Plugin Name: Seton Our Doctors

Description: 
Version: 1.0
Author: 

License: GPL
*/
//All admin parameter hook///////////////////////////////////
include "meta.php";
add_action('init','our_doctors');
add_action('init','API_key');
add_action('init','image');
add_action('init','ourdoctors_single_pg');
add_action('init','physician_single_pg');
add_action('init','search_single_pg');
add_action('init', 'location_single_pg');

function our_doctors()
{
return (get_option('our_doctors_data'));
}


function API_key(){
return(get_option('API_key_data'));
}
 
function image(){
return(get_option('image_data'));
} 
/*
function my_jsLoader() {
 // if (!is_admin()) {
	wp_enqueue_script('the_js', plugins_url('/jquery.DOMWindow.js',__FILE__) );
  //}
}*/
function ourdoctors_single_pg(){
return(get_option('ourdoctors_single_pg_data'));
}
function physician_single_pg(){
return (get_option('physician_single_pg_data'));
}
function search_single_pg(){
return (get_option('search_single_pg_data'));
}
function location_single_pg(){
return (get_option('location_single_pg_data'));
}

//Passing template//////////////////////////////////////////////////
add_filter('page_template','template_reg');
function template_reg( $page_template )
{
	/*if ( is_page( ourdoctors_single_pg() ) ) {
		$page_template = dirname( __FILE__ ) . '\templates\our_doctors.php';
	}
	if ( is_page(  physician_single_pg() ) ) {
		$page_template = dirname( __FILE__ ) . '\templates\our_physician.php';
	}
	if ( is_page( location_single_pg()) ) {
		$page_template = dirname( __FILE__ ) . '\templates\location.php';
	}
	if ( is_page( search_single_pg() ) ) {
		$page_template = dirname( __FILE__ ) . '\templates\page_search_form.php';
	}
	if ( is_page( "location" ) ) {
		$page_template = dirname( __FILE__ ) . '\templates\location.php';
	}*/
	/*if(is_page('Research Staff')){
		 $page_template = dirname( __FILE__ ) . '\templates\research_staff.php';
	}*/
	
	return $page_template;
}
 

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'our_doctors_data_install');
 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'our_doctors_data_remove' );

function our_doctors_data_install() {
/* Creates new database field */
add_option("our_doctors_data", 'Institute of Reconstructive Plastic Surgery of Central Texas', '', 'yes');
add_option("API_key_data", '2a5de188-4abc-4c26-87a2-bbdc5c847382', '', 'yes');
add_option("image_data", 'http://www.setonfamilyofdoctors.com/assets/', '', 'yes');
add_option("ourdoctors_single_pg_data", 'our-doctors', '', 'yes');
add_option("physician_single_pg_data", 'our-physician', '', 'yes');
add_option("search_single_pg_data", 'search-doctors', '', 'yes');
add_option("location_single_pg_data", 'location', '', 'yes');
}


function our_doctors_data_remove() {
/* Deletes the database field */
delete_option('our_doctors_data');
delete_option('API_key_data');
delete_option('image_data');
delete_option('ourdoctors_single_pg_data');
delete_option('physician_single_pg_data');
delete_option('search_single_pg_data');
delete_option('location_single_pg_data');
}


if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'our_doctors_admin_menu');

function our_doctors_admin_menu() {
add_options_page('Seton Our Doctors', 'Seton Our Doctors', 'administrator',
'our-doctors', 'our_doctors_html_page');
}
}
//<!--Title=============================================-->
add_filter( 'wp_title', 'my_wp_title', 10, 2 );

function my_wp_title( $title, $sep = '-' ) {
		$doctor = str_replace('-',' ',get_query_var( 'lastName' ));
		$title1 = our_doctors();
		$title = "test".' | '.$title1.' | '; 
	return $title;

}
add_filter( 'query_vars', 'my_query_vars' );

function my_query_vars( $vars ) {

	$vars[] = 'lastName';

	return $vars;
}
/*bhc rewrite*/
function add_rewrite_rule_and_tag() {
 global $wp_rewrite;

	add_rewrite_rule( '^physicians/provider-profile/([^/]*)/?', 'index.php?pagename=physicians/provider-profile&lastName=$matches[1]', 'top' );
	//add_rewrite_rule( '^provider-profile/([^/]*)/?', 'provider-profile&lastName=$matches[1]', 'top' );
	add_rewrite_tag( '%lastName%','([^&]+)' );

	if ( ! isset( $wp_rewrite->rules['^physicians/provider-profile/([^/]*)/?'] ) )
		$wp_rewrite->flush_rules();
	return;
}
add_action( 'init', 'add_rewrite_rule_and_tag', 99 );

/*seton heart rewrite*/
function add_rewrite_rule_and_tag_shi() {
 global $wp_rewrite;

    add_rewrite_rule( '^providers/provider-profile/([^/]*)/?', 'index.php?pagename=providers/provider-profile&lastName=$matches[1]', 'top' );
	//add_rewrite_rule( '^provider-profile/([^/]*)/?', 'provider-profile&lastName=$matches[1]', 'top' );
	add_rewrite_tag( '%lastName%','([^&]+)' );

    if ( ! isset( $wp_rewrite->rules['^providers/provider-profile/([^/]*)/?'] ) )
        $wp_rewrite->flush_rules();
    return;
}
add_action( 'init', 'add_rewrite_rule_and_tag_shi', 99 );

/*Skin Care rewrite*/
function add_rewrite_rule_and_tag_skin_care() {
 global $wp_rewrite;

	add_rewrite_rule( '^care-team/provider-profile/([^/]*)/?', 'index.php?pagename=care-team/provider-profile&lastName=$matches[1]', 'top' );
	//add_rewrite_rule( '^provider-profile/([^/]*)/?', 'provider-profile&lastName=$matches[1]', 'top' );
	add_rewrite_tag( '%lastName%','([^&]+)' );

	if ( ! isset( $wp_rewrite->rules['^care-team/provider-profile/([^/]*)/?'] ) )
		$wp_rewrite->flush_rules();
	return;
}
add_action( 'init', 'add_rewrite_rule_and_tag_skin_care', 99 );

/*function add_rewrite_midprovider_rule_and_tag() {
	global $wp_rewrite;

	add_rewrite_rule( '^seton-heart-institute/providers/midProvider-profile/([^/]*)/?', 'index.php?pagename=seton-heart-institute/providers/midProvider-profile&lastName=$matches[1]', 'top' );
	add_rewrite_tag( '%lastName%','([^&]+)' );

	if ( ! isset( $wp_rewrite->rules['^midProvider/([^/]*)/?'] ) )
		$wp_rewrite->flush_rules();
	return;
}
add_action( 'init', 'add_rewrite_midprovider_rule_and_tag', 99 );*/

//<!--Meta changed============================================-->
function sfod_add_meta_to_head() {
	$tempName= get_query_var('lastName');
	if ((strlen($tempName))>2) {
		$doctorName=str_replace("-"," ",$tempName);
		get_metadescription($doctorName);
	}
}
//add_action('wp_head', 'sfod_add_meta_to_head',2,10);

//physician for short code=============================================================
//add_filter('widget_text', 'do_shortcode');
function physicianList() {
	$practiceName = our_doctors();
	$practiceName = str_replace (" ","%20",$practiceName);
	$practiceName = str_replace ("&", "%26", $practiceName);

	if(function_exists('API_key')) { $practiceURLTemp=(API_key()); }
	else { echo "API is wrong"; }

	$practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);
	$practiceURL=str_replace(" ","%20",$practiceURL);
	$practiceString = file_get_contents($practiceURL);
	$json2=json_decode($practiceString, true);

	$practiceID = $json2["ID"];
	$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianSearch.aspx?AuthCode=".$practiceURLTemp."&PhysicianName=&PracticeID=".$practiceID."&ShowNonPhysicians=true" );
	$url=str_replace(" ","%20",$url);
	$strings= file_get_contents($url);
	$json=json_decode($strings, true);
	//echo $url;
	$currentPath=($_SERVER['REQUEST_URI']);
	//print_r ($json);
	echo "<div class='doctor_wrapper'>";
	//For each name
	foreach($json as $key=>$val)
	{
		$DaFullName=$val['PhysicianName'];
		$EachProfileURL = ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$DaFullName);

		$EachProfileURL=str_replace(" ","%20",$EachProfileURL); $profileString= file_get_contents($EachProfileURL);
		$EachProfile = json_decode($profileString, true);
		$Name= $EachProfile["ImageLink"];
		$middleName=$EachProfile["MiddleInitial"];
		$credential=$EachProfile["Credentials"];
		$spec=$EachProfile["Specialties"];

		$FullName=str_replace ("-"," $middleName ",$DaFullName);
		//echo "full name: ".$FullName."<br/>";				   
		$linkName=str_replace(' ', '-', $DaFullName);
		$linkName=str_replace(". ",".",$DaFullName);

		// echo "link name: ".$linkName;

		echo "<div class='doctor_thumb'>";
		$link= $currentPath."/provider-profile/".($linkName);
		$link = str_replace("//","/",$link);
		//echo $link;
		// echo "<a href='$link'><img src='".(image()).$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
		echo "<a href='$link'><img src='"."/images/sfod/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
		// echo "<a href='$link'><img src='"."/images/profiles/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";

		if(!isset($credential))
		{
			echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName."</a>";
		}
		else
		{
			echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName .", ".$credential."</a><br/>";
		}
		//echo "<a href='provider-profile?lastName=".($val['PhysicianName'])."'>". $FullName ."</a><br/>";
		echo $spec."</div>";
		echo "</div>";//<!--Doctor thumb-->

						
	}	
	echo "</div>"; //<!--full docotor wrapper-->
}
add_shortcode('Physician_List', 'physicianList');

//physician for short code=============================================================
//add_filter('widget_text', 'do_shortcode');
function physicianListBySpecialty($atts) {
	extract(shortcode_atts(array(
		'specialties' => ''
	), $atts));
	if($specialties == '') { return ''; }
	else {
		if(function_exists('API_key')) { $apiKey=(API_key()); }
		else { echo "API is wrong"; }

		$url = "http://www.setonfamilyofdoctors.com/api/PhysicianBySpecialty.aspx?AuthCode=".$apiKey."&PhysicianSpecialty=".$specialties;
		$url = str_replace(" ","%20",$url);
		$strings = file_get_contents($url);
		$json = json_decode($strings, true);

		$currentPath = $_SERVER['REQUEST_URI'];
		echo "<div class='doctor_wrapper'>";
		//For each name
		foreach($json as $key=>$val)
		{
			// FirstName is actually LastName, FirstName
			$realFirstName = str_replace($val['LastName'] . ", ", "", $val['FirstName']);
			$DaFullName=$realFirstName . "-" . $val['LastName'];
			$Name= $val["ImageLink"];
			$middleName=$val["MiddleInitial"];
			$credential=$val["Credentials"];
			$spec=$val["Specialties"];

			$FullName=str_replace ("-"," $middleName ",$DaFullName);
			$linkName=str_replace(' ', '-', $DaFullName);
			$linkName=str_replace(". ",".",$DaFullName);

			echo "<div class='doctor_thumb'>";
			$link= $currentPath."/provider-profile/".($linkName);
			$link = str_replace("//","/",$link);
			// echo "<a href='$link'><img src='".(image()).$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
			echo "<a href='$link'><img src='"."/images/sfod/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
			// echo "<a href='$link'><img src='"."/images/profiles/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";

			if(!isset($credential)) { echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName."</a>"; }
			else { echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName .", ".$credential."</a><br/>"; }

			echo $spec."</div>";
			echo "</div>";//<!--Doctor thumb-->
		}	
		echo "</div>"; //<!--full docotor wrapper-->
	}
}
add_shortcode('Physician_List_By_Specialty', 'physicianListBySpecialty');

//custom physician list for short code=============================================================
function physicianListCustom($atts) {
	extract(shortcode_atts(array(
		'query' => ''
	), $atts));
	if($query == '') { return ''; }
	else {
		if(function_exists('API_key')) { $apiKey=(API_key()); }
		else { echo "API is wrong"; }

		 $url = "http://www.setonfamilyofdoctors.com/api/" . $query . ".aspx?AuthCode=".$apiKey;
		//$url = "http://www.setonfamilyofdoctors.com/api/" . $query . ".aspx?AuthCode=".$apiKey;
		$url = str_replace(" ","%20",$url);
		$strings = file_get_contents($url);
		// var_dump($strings);
		$json = json_decode($strings, true);

		$currentPath = $_SERVER['REQUEST_URI'];
		echo "<div class='doctor_wrapper'>";
		//For each name
		foreach($json as $key=>$val)
		{
			// FirstName is actually LastName, FirstName
			$realFirstName = str_replace($val['LastName'] . ", ", "", $val['FirstName']);
			$DaFullName=$realFirstName . "-" . $val['LastName'];
			$Name= $val["ImageLink"];
			$middleName=$val["MiddleInitial"];
			$credential=$val["Credentials"];
			$spec=$val["Specialties"];

			$FullName=str_replace ("-"," $middleName ",$DaFullName);
			$linkName=str_replace(' ', '-', $DaFullName);
			$linkName=str_replace(". ",".",$DaFullName);

			echo "<div class='doctor_thumb'>";
			$link= $currentPath."/provider-profile/".($linkName);
			$link = str_replace("//","/",$link);
			// echo "<a href='$link'><img src='".(image()).$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
			echo "<a href='$link'><img src='"."/images/sfod/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
			// echo "<a href='$link'><img src='"."/images/profiles/".$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";

			if(!isset($credential)) { echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName."</a>"; }
			else { echo "<br/><div class='doctor_specialties'><a class='doctor_name' href='$link'>". $FullName .", ".$credential."</a><br/>"; }

			echo $spec."</div>";
			echo "</div>";//<!--Doctor thumb-->
		}	
		echo "</div>"; //<!--full docotor wrapper-->
	}
}
add_shortcode('Physician_List_Custom', 'physicianListCustom');

//physician detail for short code=============================================================
function physicianDetail() {
	$lastName= get_query_var('lastName');
	?>
	<div class="physician_profile"> 
	<?php 
		if(isset($lastName)) {
			$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$lastName );
			$url = str_replace(" ","%20",$url);
			$strings= file_get_contents($url);
			$json=json_decode($strings, true);

			$isVisible=$json["IsVisible"];
			if($isVisible==false){
				header( 'Location: /' ) ;
				die();
			}

			$credentials = $json["Credentials"];
			$firstName=$json["FirstName"];
			$middleName=$json["MiddleInitial"];

			if(strlen($middleName) > 0) { $middleName = $middleName . " "; }

			$lastName=$json["LastName"];
			$suffix=$json["Suffix"];

			if(strlen($suffix) > 0) { $suffix = " " . $suffix; }

			$FullName=$firstName . " " . $middleName . $lastName . $suffix;
		}
		// $imageURL= (image().$json["ImageLink"]);
		$imageURL= ("/images/sfod/".$json["ImageLink"]);
		// $imageURL= ("/images/profiles/".$json["ImageLink"]);
		echo "<img src='".$imageURL."' alt='" . $FullName . ", " . $credentials . "' />";
		$spec=$json["Specialties"];
		$temp = explode(',',$spec);
		if (isset($temp[1]) || array_key_exists(1, $temp)) {
			$secondSpec=$temp[1];
		}
		if(isset($spec) && strlen($spec) > 0)
		{
			if(isset($secondSpec)) {
				echo "<div class='profile_specialties'><h2>Specialties:</h2></div>";
			}
			else {
				echo "<div class='profile_specialties'><h2>Specialty:</h2></div>"; 
				echo "<div class='profile_credentials'>".$json["Specialties"]."</div>";
			}
		}
		// https://basecamp.com/1719596/projects/10037991/todos/221341581
		$bioWithFullImageURLs = str_replace('../assets/rawassets', 'http://www.setonfamilyofdoctors.com/assets/rawassets',$json["Biography"]);
		echo "<div class='profile_bio'>".$bioWithFullImageURLs."</div>";
	?>	
	</div>
	<div class="profile_sidebar">
	<?php
		//Video link////////////////////////////////////////////////////////////////////////////////////
		//Does this Physician Have a Video Link
		if(strlen($json["VideoLink"]) > 0)
		{ 
			$lastCode=substr($json["VideoLink"],(strrpos($json["VideoLink"],"://")));
			$lastCode= "https".$lastCode;					
			echo "<div class='video-container'><iframe src='".$lastCode."' frameborder='0' allowfullscreen></iframe></div>";
		}

		$practiceName = our_doctors(); //"Institute of Reconstructive Plastic Surgery of Central Texas";
		$practiceName = str_replace (" ","%20",$practiceName);
		$practiceName = str_replace ("&", "%26", $practiceName);
		if(function_exists('API_key')) 
		{          
			$practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PracticeName=".$practiceName);
		}
		else
		{
			echo "Wrong API Key in the admin dashboard.";
		}

		$practiceURL=str_replace(" ","%20",$practiceURL);					   
		$practiceString = file_get_contents($practiceURL); 
		$json2=json_decode($practiceString, true);					
		$practiceID = $json2["ID"]; //Get Practice ID     
		$physicianID = $json["ID"]; //Get The Doctor ID

		$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianAddressesByID.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianID=".$physicianID."&PracticeID=".$practiceID );
		$url = str_replace(" ","%20",$url);
		$strings= file_get_contents($url);  
		$json3=json_decode($strings, true);	

		//Address of doctors////////////////////////////////////////////////////	
		if(!empty($json3))
		{?>
			<h2>Practice Information</h2>
		<?php
			$len=count($json3);
			$counter=0;
			$practiceInfo="";
			foreach($json3 as $key=>$val)
			{
				$location= $val['AddressLocation'];
				$address1= $val['AddressLine1'];
				$address2= $val['AddressLine2'];
				$city= $val['City'];
				$state= $val['State'];
				$zip= $val['Zip'];
				$phone= $val['Phone'];
				$fax= $val['Fax'];
				$googleLocation="{$address1} {$address2} {$city} {$state} {$zip}";
				$googleLocation= urlencode($googleLocation);
		   
				$practiceInfo.= "<div class='location_sidebar'>";
				$practiceInfo.= "<div class='address'><strong>".$location."</strong><br/><br/>";
				$practiceInfo.= $address1."<br/>";

				if(strlen($address2)>2) { $practiceInfo.= $address2."<br/>"; }

				$practiceInfo.= $city.", ".$state." ".$zip."</div>";

				if(strlen($phone) > 0 )
				{
					if(strlen($phone)==15)
					{
						$phoneMain = explode('x', $phone);
						$practiceInfo.= "<div class='phone'>P: ".$phoneMain[0]."</div>";
					}
					else
					{
						$practiceInfo.= "<div class='phone'>P: ".$phone."</div>";
					}
				}
				if(strlen($fax) > 0 ) { $practiceInfo.= "<div class='fax'>F: ".$fax."</div>"; }
				//For BHC, it doesn't have location page
				$practiceInfo.= "<a href='http://maps.google.com/maps?saddr=&amp;daddr=$googleLocation' class='directions arrow'>Map & Directions</a>";
				$practiceInfo.= "</div>";
				if($counter!=$len-1)
				{
					$practiceInfo.= "<div class='location_sidebar_divider'></div>";
				}
				$counter++;
			}
			/*if(function_exists('our_doctors')) {
				$practiceName = our_doctors();
				$practiceInfo.= "<a href='/locations-and-directions'>Map & Directions</a><br/>";
			}*/
		}
		else
		{
			//$practiceInfo= "No Physician Found";
			echo "<style>.profile_sidebar{display:none !important;}</style>";
		}

		if (isset($practiceInfo) && $practiceInfo != "") {
			echo $practiceInfo;
		}
		else {
			echo "<script language='javascript'>$('.profile_sidebar').hide();</script>";
		}?>
	</div><!-- /profile_sidebar -->
	<?php	
}
add_shortcode('Physician_Detail', 'physicianDetail');
//physician detail for short code=============================================================
function physicianDetail2() {
	$lastName= get_query_var('lastName');
	if(function_exists('API_key')) { $apiKey=(API_key()); }
	else { echo "API is wrong"; }

	?>				 				
	<div class="physician_profile"> 
	<?php 
		if(isset($lastName)) {
			$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=".$apiKey."&PhysicianName=".$lastName );
			$url = str_replace(" ","%20",$url);
			$strings= file_get_contents($url);
			$json=json_decode($strings, true);
			$isVisible=$json["IsVisible"];
			//echo $apiKey."<br/>";
			//echo $lastName;
			//die();
			if($isVisible==false){
				header( 'Location: /' ) ;
				die();
			}
			$credentials = $json["Credentials"];
			$firstName=$json["FirstName"];
			$middleName=$json["MiddleInitial"];
			if(strlen($middleName) > 0) {$middleName = $middleName . " ";}
			$lastName=$json["LastName"];
			$suffix=$json["Suffix"];
			if(strlen($suffix) > 0) {$suffix = " " . $suffix;}
			$FullName=$firstName . " " . $middleName . $lastName . $suffix;
		}
		// $imageURL= (image().$json["ImageLink"]);
		$imageURL= ("/images/sfod/".$json["ImageLink"]);
		// $imageURL= ("/images/profiles/".$json["ImageLink"]);
		echo "<img src='".$imageURL."' alt='" . $FullName . ", " . $credentials . "' />";
		$spec=$json["Specialties"];
		$temp = explode(',',$spec);
		if (isset($temp[1]) || array_key_exists(1, $temp)) {
			$secondSpec=$temp[1];
		}
		if(isset($spec) && strlen($spec) > 0)
		{
			if(isset($secondSpec)) { echo "<div class='profile_specialties'><h2>Specialties:</h2></div>"; }
			else { echo "<div class='profile_specialties'><h2>Specialty:</h2></div>"; }

			echo "<div class='profile_credentials'>".$json["Specialties"]."</div>";
		}
		// https://basecamp.com/1719596/projects/10037991/todos/221341581
		// echo "<div class='profile_bio'>".$json["Biography"]."</div>";
		$bioWithFullImageURLs = str_replace('../assets/rawassets', 'http://www.setonfamilyofdoctors.com/assets/rawassets',$json["Biography"]);
		echo "<div class='profile_bio'>".$bioWithFullImageURLs."</div>";
		echo "<div class='profile_education'>".$json["Education"]."</div>";
	?>	
	</div>
	 <!--<a class="btn" href="#">Request a Consultation</a>	--> 
	<?php
		$currentPath = $_SERVER['REQUEST_URI'];
		$hostname = getenv('HTTP_HOST');
		if (strpos($currentPath,'/skin-care/care-team/') !== false) {
			$tempName="$firstName-$lastName";
			if($tempName!=("Lucia-Diaz")&&($tempName!=("Moise-Levy"))&&($tempName!=("Matthew-Fox"))){
		?>
			<div class="profile_sidebar" style="background:none;border:none;padding-left:0">
				<a href="http://<?php echo $hostname?>/skin-care/request-a-consultation/?provider=<?php echo "$firstName-$lastName";?>" class="btn">Request a Consultation</a>
			</div>
		<?php
		}
		}
	?>
	<div class="profile_sidebar">
	<?php
		//Video link////////////////////////////////////////////////////////////////////////////////////
		//Does this Physician Have a Video Link
		if(strlen($json["VideoLink"]) > 0)
		{
			if(strrpos($json["VideoLink"],"://") != false)
			{
				$lastCode=substr($json["VideoLink"],(strrpos($json["VideoLink"],"://")));
				$lastCode= "https".$lastCode;
			}
			else
			{
				$lastCode = "https://".$lastCode;
			}
			echo "<div class='video-container'><iframe src='".$lastCode."' frameborder='0' allowfullscreen></iframe></div>";
		}
  
		$physicianID = $json["ID"]; //Get The Doctor ID
		$url= ("http://www.setonfamilyofdoctors.com/api/LocationsByPhysician.aspx?AuthCode=".$apiKey."&Physician=".$physicianID );
		$url = str_replace(" ","%20",$url);
		$strings= file_get_contents($url);  
		$json3=json_decode($strings, true);	
	
	  //Address of doctors////////////////////////////////////////////////////	
		if(!empty($json3))
		{?>
			<h2>Practice Information</h2>
		<?php
			$len=count($json3);
			$counter=0;
			$practiceInfo="";
			foreach($json3 as $key=>$val)
			{
				$practice = ""; $location = ""; $address1 = ""; $address2 = ""; $city = ""; $state = ""; $zip = ""; $phone = ""; $fax = "";
				if(array_key_exists('Practice', $val)) { $practice= $val['Practice']; }
				if(array_key_exists('AddressLocation', $val)) { $location= $val['AddressLocation']; }
				if(array_key_exists('AddressLine1', $val)) { $address1= $val['AddressLine1']; }
				if(array_key_exists('AddressLine2', $val)) { $address2= $val['AddressLine2']; }
				if(array_key_exists('City', $val)) { $city= $val['City']; }
				if(array_key_exists('State', $val)) { $state= $val['State']; }
				if(array_key_exists('Zip', $val)) { $zip= $val['Zip']; }
				if(array_key_exists('Phone', $val)) { $phone= $val['Phone']; }
				if(array_key_exists('Fax', $val)) { $fax= $val['Fax']; }
				$googleLocation="{$address1} {$address2} {$city} {$state} {$zip}";
				$googleLocation= urlencode($googleLocation);
		   
				$practiceInfo.= "<div class='location_sidebar'>";					   
				$practiceInfo.= "<h3 class='practice'>".$practice."</h3>";
				$practiceInfo.= "<div class='address'>".$location."<br/>";
				$practiceInfo.= $address1."<br/>";
				if(strlen($address2)>2)
				{
					$practiceInfo.= $address2."<br/>";
				}
				$practiceInfo.= $city.", ".$state." ".$zip."</div>";
				if(strlen($phone) > 0 )
				{
					if(strlen($phone)==15){
						$phoneMain = explode('x', $phone);
						$phoneFormatted = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phoneMain[0]); /* http://stackoverflow.com/a/10741461/3019650 */
						$practiceInfo.= "<div class='phone'>P: ".$phoneFormatted."</div>";
					}
					else{
						$phoneFormatted = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone); /* http://stackoverflow.com/a/10741461/3019650 */
						$practiceInfo.= "<div class='phone'>P: ".$phoneFormatted."</div>";
					}
				}
				if(strlen($fax) > 0 )
				{
					$faxFormatted = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $fax); /* http://stackoverflow.com/a/10741461/3019650 */
					$practiceInfo.= "<div class='fax'>F: ".$faxFormatted."</div>";
				}
				//For BHC, it doesn't have location page
				$practiceInfo.= "<a href='http://maps.google.com/maps?saddr=&amp;daddr=$googleLocation' class='directions arrow'>Map & Directions</a>";
				$practiceInfo.= "</div>";							
				if($counter!=$len-1)
				{
					$practiceInfo.= "<div class='location_sidebar_divider'></div>";
				}
				$counter++;
			}
		}
		if (isset($practiceInfo) && $practiceInfo != "") {
			echo $practiceInfo;
		}
	?>
	</div><!-- /profile_sidebar -->
	<?php	
}
add_shortcode('Physician_Detail2', 'physicianDetail2');

//=========Locations========================================================
//include ('locations.php');
function locations() {
 	echo "<script type='text/javascript' src='//maps.google.com/maps/api/js?sensor=false'></script>";
	echo "<div class='map cf'>
				<div id='map_canvas'></div>";
	$practiceName = our_doctors();	 
	$practiceName=str_replace(" ","%20",$practiceName);
	$practiceName = str_replace ("&", "%26", $practiceName);

	if(function_exists('API_key')) { $practiceURLTemp=(API_key()); }
	else { echo "API is wrong"; }

	$url= ("http://www.setonfamilyofdoctors.com/api/LocationsByPracticeName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);			 
	$strings= file_get_contents($url);  
	$json3=json_decode($strings, true);
	$lat=array();
	$long=array();
	$locations=array();
	$addressLine1J=array();
	$addressLine2J=array();
	$addressJ=array();
	if(!empty($json3))
	{
		foreach($json3 as $key=>$val)
		{
			$location1= $val['Location'];
			
			array_push($locations,$location1);
			
			$address1= $val['AddressLine1'];
			array_push($addressLine1J, $address1);
			$address2= $val['AddressLine2'];
			array_push($addressLine2J, $address2);
			$city= $val['City'];
			$state= $val['State'];
			$zip= $val['ZipCode'];
			array_push($addressJ,($city." ".$state." ".$zip));
			$PhoneNumber= $val['PhoneNumber'];
			$fax= $val['Fax'];
			$latitude=$val['Latitude'];
			array_push ($lat,$latitude);
			$longitude=$val['Longitude'];
			array_push ($long,$longitude);
						
			//Get Geo data////////////////////////////////////////////////////////
			$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
			$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
		}
		
		$locationMarkers = "";
		$latlngArray = "";
		$count = 1;

		for($i=0; $i < sizeof($addressLine1J); $i++)
		{

			$locations[$i]=str_replace("'","\'",$locations[$i]);
			$contentString = "var contentString" . $count . " = '<div class=mapflyout2><span><strong>".$locations[$i]."</strong></span><span>".$addressLine1J[$i]."</span><span>".$addressLine2J[$i]."</span><span>".$addressJ[$i]."</span></div>';";
			
			$contentString .= "var infowindow" . $count . " = new google.maps.InfoWindow({content: contentString" . $count . ", maxWidth: 400} ); ";
			$locationMarkers .= "\n" . $contentString;

			$customPointer = "var myimage" . $count . " = '/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon" . $count . ".png'; ";
			
			$locationMarkers .= "\n" . $customPointer;

			// create a line of JavaScript for marker on map for this record 
			$locationMarkers .= "\n" . "var mylatlng" . $count . " = new google.maps.LatLng(" . $lat[$i] . "," . $long[$i] . ");";
		  
			$locationMarkers .= "\n" . "var marker" . $count . " = new google.maps.Marker({ position: mylatlng" . $count . ",  map: map, icon:myimage".$count.", title:\"" . $locations[$i] . "\" });";

			$infowindow = "var infowindow" . $count . " = new google.maps.InfoWindow({     content: contentString" . $count . " }); ";
			$locationMarkers .= "\n" . $infowindow;

			$listener = "google.maps.event.addListener(marker" . $count . ", 'click', function() { closewin(); currentinfowindow = infowindow" . $count . ";  infowindow" . $count . ".open(map,marker" . $count . "); });";

			$locationMarkers .= "\n" . $listener;
			$locationMarkers .= "\n" . "gmarkers.push(marker" . $count . ");";

			$latlngArray .= "mylatlng" . $count . ", ";						
			$count = $count +1;
		}

		$initJavascript = "var map = null;\n";
		$initJavascript .= "var gmarkers = [];\n"; 
		$initJavascript .= "var currentinfowindow = null;\n";

		$initJavascript .= "function initialize() {\n";
		$initJavascript .= "var latlng = new google.maps.LatLng(30.2669444, -97.7427778);\n";
		$initJavascript .= "var myOptions = { zoom: 7, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };\n";
		$initJavascript .= "map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);\n";
		$initJavascript .= $locationMarkers;
		//$initJavascript .= "ToggleCheckboxesVisibility();\n";
		$initJavascript .= "}\n\n";

		$initJavascript .= "function closewin()\n";
		$initJavascript .= "{\n";
		$initJavascript .= "    if (currentinfowindow!= null)\n";
		$initJavascript .= "    {\n";
		$initJavascript .= "        currentinfowindow.close();\n";
		$initJavascript .= "    }\n";
		$initJavascript .= "}\n\n";

		$initJavascript .= "function myclick(i) {\n";
		$initJavascript .= "    google.maps.event.trigger(gmarkers[i - 1], \"click\");\n";
		$initJavascript .= "}\n";

		$initJavascript .= "function doClose()\n ";
		$initJavascript .= "{\n";
		$initJavascript .= "    window.scrollTo(0,0);\n";
		$initJavascript .= "}\n\n";
		$initJavascript .= "initialize();\n";				

	}
	echo "<script type='text/javascript'>
			$initJavascript; 
		</script>
		</div>";

	echo "<div class='location_header_row cf'>";
	echo "<div class='location_name'><span>Location</span></div>";
	echo "<div class='map_address'>Address</div>";
	echo "<div class='map_phone_fax'>Phone</div>";
	echo "<div class='map_view'>&nbsp;</div></div>";
	$counter=1;
	$root = home_url();
	if(!empty($json3))
	{
		foreach($json3 as $key=>$val)
		{
			echo "<div class='location_row cf'>";
			echo "<div class='location_name'>";
			echo "<a href='javascript:myclick(".$counter.");doClose();'>";
			echo "<img src='" . $root . "/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon".$counter.".png'>";
			echo "</a>";
			//$customPointer = "var myimage_header_" . $count . " = '/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon" . $count . ".png'; ";
			echo "<span>".$val["Location"]."</span></div>";	

			echo "<div class='map_address'>";
			$address1= $val['AddressLine1'];
			$address2= $val['AddressLine2'];
			$city= $val['City'];
			$state= $val['State'];
			$zip= $val['ZipCode'];
			$PhoneNumber= $val['PhoneNumber'];
			$fax= $val['Fax'];	
			$location1= $val['Location'];
			//echo $location."<br/>";
			$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
			$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
			$fullAddressTemp=($address1." ".$address2." ".$city." ".$state." ".$zip);
			echo $address1." ";
			echo $address2."<br/>";
			echo $city.", ".$state." ".$zip;
			echo "</div>";
			echo "<div class='mobile_address'><a class='btn btn-bdr-white' href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>";
			echo $address1." ";
			echo $address2."<br/>";
			echo $city.", ".$state." ".$zip;
			echo "</a></div>";
			echo "<div class='map_phone_fax'>&nbsp;";					
			if(strlen($PhoneNumber) > 0 )
			{
				echo "P: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber);
			}
			if(strlen($fax) > 0 )
			{
				echo "<br />F: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $fax);
			}
			echo "</div>";
			echo "<div class='mobile_phone'><a class='btn btn-blue' href='tel:".$PhoneNumber."'>".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber)."</a></div>";
			echo "<div class='map_view'>";
			echo "<a href='javascript:myclick(".$counter.");doClose();'> View on Map</a><br/>";
			//echo "<a href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>Get Directions</a>";
			$fullAddress= urlencode($address1." ".$address2." ".$city." ".$state." ".$zip);
			echo "<a href='http://maps.google.com/maps?saddr=&daddr=$fullAddress' target='_blank'>Get Directions</a>";
			echo "</div></div>";
			$counter++;
		}
	}
}
add_shortcode('Locations', 'locations');

//=========Locations========================================================
//include ('locations.php');
function locationsBySpecialty($atts) {
	extract(shortcode_atts(array(
		'specialties' => ''
	), $atts));
	if($specialties == '') { return ''; }
	else {
		echo "<script type='text/javascript' src='//maps.google.com/maps/api/js?sensor=false'></script>";
		echo "<script type='text/javascript' src='/wp-content/plugins/seton_our_doctors/js/OverlappingMarkerSpiderfier.min.js'></script>";
		echo "<div class='map cf'><div id='map_canvas'></div>";
		if(function_exists('API_key')) { $apiKey=(API_key()); }
		else { echo "API is wrong"; }
		$url= ("http://www.setonfamilyofdoctors.com/api/LocationsBySpecialty.aspx?AuthCode=".$apiKey."&LocationSpecialty=".$specialties);
		$strings= file_get_contents($url);  
		$json3=json_decode($strings, true);
		$lat=array();
		$long=array();
		$names=array();
		$locations=array();
		$addressLine1J=array();
		$addressLine2J=array();
		$addressJ=array();
		if(!empty($json3)) {
			$json3 = $json3['Locations']; // Weird array offset
			foreach($json3 as $key=>$val) {
				if(($val["Name"]=="Seton Mind Institute")||($specialties!="Psychiatry")){
				$name = "";
				$location1 = "";
				$address1 = "";
				$address2 = "";
				$city = "";
				$state = "";
				$zip = "";
				$PhoneNumber = "";
				$latitude = "";
				$longitude = "";
				$name = $val['Name'];
				array_push($names, $name);
				$location1= $val['Location'];
				array_push($locations,$location1);
				$address1= $val['AddressLine1'];
				array_push($addressLine1J, $address1);
				$address2= $val['AddressLine2'];
				array_push($addressLine2J, $address2);
				$city= $val['city'];
				$state= $val['state'];
				$zip= $val['zipcode'];
				array_push($addressJ,($city." ".$state." ".$zip));
				$PhoneNumber= $val['phonenumber'];
				// $fax= $val['Fax'];
				$latitude=$val['latitude'];
				array_push ($lat,$latitude);
				$longitude=$val['longitude'];
				array_push ($long,$longitude);

				//Get Geo data////////////////////////////////////////////////////////
				$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
			}
			}

			$locationMarkers = "";
			$latlngArray = "";
			$count = 1;

			for($i=0; $i < sizeof($addressLine1J); $i++) {
				$locations[$i]=str_replace("'","\'",$locations[$i]);
				$names[$i]=str_replace("'","\'",$names[$i]);
				$contentString = "var contentString" . $count . " = '<div class=mapflyout2><span><h4 class=\'iw-practicegroup\'>".$names[$i]."</h4><strong>".$locations[$i]."</strong></span><span>".$addressLine1J[$i]."</span><span>".$addressLine2J[$i]."</span><span>".$addressJ[$i]."</span></div>';";

				// $contentString .= "var infowindow" . $count . " = new google.maps.InfoWindow({content: contentString" . $count . ", maxWidth: 400} ); ";
				$locationMarkers .= "\n" . $contentString;

				$customPointer = "var myimage" . $count . " = '/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon" . $count . ".png'; ";


				$locationMarkers .= "\n" . $customPointer;

				// create a line of JavaScript for marker on map for this record 
				$locationMarkers .= "\n" . "var mylatlng" . $count . " = new google.maps.LatLng(" . $lat[$i] . "," . $long[$i] . ");";
				//extend map bounds
				$locationMarkers .= "\n" . "bounds.extend(mylatlng" . $count . ");";

				$locationMarkers .= "\n" . "var marker" . $count . " = new google.maps.Marker({ position: mylatlng" . $count . ",  map: map, icon:myimage".$count.", title:\"" . $locations[$i] . "\" });";
                $locationMarkers .= "\n" . "oms.addMarker(marker" . $count . ");";

				$infowindow = "var infowindow" . $count . " = new google.maps.InfoWindow({ content: contentString" . $count . ", maxWidth: 400}); ";
				$locationMarkers .= "\n" . $infowindow;

				$listener = "google.maps.event.addListener(marker" . $count . ", 'click', function() { closewin(); currentinfowindow = infowindow" . $count . ";  infowindow" . $count . ".open(map,marker" . $count . "); });";
				// $listener = "oms.addListener('click', function(marker" . $count . ", event) {\n";
				// $listener .= "	iw.setContent(contentString" . $count . ");\n";
				// $listener .= "	iw.open(map, marker" . $count . ");\n";
				// $listener .= "});\n";

				// $listener .= "oms.addListener('spiderfy', function(markers) {\n";
				// $listener .= "	iw.close();\n";
				// $listener .= "});\n";

				$locationMarkers .= "\n" . $listener;
				$locationMarkers .= "\n" . "gmarkers.push(marker" . $count . ");";

				$latlngArray .= "mylatlng" . $count . ", ";						
				$count = $count +1;
			}
			$initJavascript = "var map = null;\n";
			$initJavascript .= "var gmarkers = [];\n"; 
			$initJavascript .= "var bounds = new google.maps.LatLngBounds();\n";
			$initJavascript .="var directionsDisplay;\n";
			$initJavascript .= "var currentinfowindow = null;\n";
			$initJavascript .= "directionsDisplay = new google.maps.DirectionsRenderer({preserveViewport: true});\n";

			$initJavascript .= "function initialize() {\n";
			$initJavascript .= "var latlng = new google.maps.LatLng(30.2669444, -97.7427778);\n";
			$initJavascript .= "var myOptions = { zoom: 8, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };\n";
			$initJavascript .= "map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);\n";
			$initJavascript .= "directionsDisplay.setMap(map);\n\n";

			// add OverlappingMarkerSpiderfier instance
			$initJavascript .= "var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true, keepSpiderfied: true});\n\n";

			// add InfoWindow instance
			// $initJavascript .= "var iw = new google.maps.InfoWindow({maxWidth: 400});\n";

			//reset map bounds
			$initJavascript .= "bounds = new google.maps.LatLngBounds();\n";
			
			$initJavascript .= $locationMarkers;
			$initJavascript .= "\n" . "fitMap();";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function initSpiderfy() {\n";
			$initJavascript .= "	google.maps.event.addListenerOnce(map, 'idle', function(){\n";
			$initJavascript .= "		myclick(1); currentinfowindow.close();\n";
			$initJavascript .= "	});\n";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function closewin()\n";
			$initJavascript .= "{\n";
			$initJavascript .= "    if (currentinfowindow!= null)\n";
			$initJavascript .= "    {\n";
			$initJavascript .= "        currentinfowindow.close();\n";
			$initJavascript .= "    }\n";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function fitMap() {\n";
			$initJavascript .= "	closewin();\n";
			$initJavascript .= "	google.maps.event.trigger(map,'resize');\n";
			$initJavascript .= "	map.fitBounds(bounds);\n";
			//a single result will zoom all the way in...
			$initJavascript .= "	if (map.zoom > 17) { map.setZoom(17); }\n";
			$initJavascript .= "}\n";

			$initJavascript .= "function myclick(i) {\n";
			$initJavascript .= "    google.maps.event.trigger(gmarkers[i - 1], \"click\");\n";
			$initJavascript .= "}\n";

			$initJavascript .= "function doClose()\n ";
			$initJavascript .= "{\n";
			$initJavascript .= "    window.scrollTo(0,0);\n";
			$initJavascript .= "}\n\n";
			$initJavascript .= "initialize();initSpiderfy();\n";

			$initJavascript .= "var reboundMap = debounce(function() {\n";
			$initJavascript .= "	fitMap();\n";
			$initJavascript .= "}, 50);\n";

			$initJavascript .= "if (window.addEventListener) {\n";
			$initJavascript .= "	window.addEventListener('resize', reboundMap);\n";
			$initJavascript .= "}\n";
			$initJavascript .= "else { window.attachEvent('resize', reboundMap); }\n";
		}
		echo "<script type='text/javascript'>
				$initJavascript; 
			</script>
			</div>";

		echo "<div class='location_header_row cf'>";
		echo "<div class='location_name'><span>Location</span></div>";
		echo "<div class='map_address'>Address</div>";
		echo "<div class='map_phone_fax'>Phone</div>";
		echo "<div class='map_view'>&nbsp;</div></div>";
		$counter=1;
		$root = home_url();
		if(!empty($json3)) {
			foreach($json3 as $key=>$val) {
			if(($val["Name"]=="Seton Mind Institute")||($specialties!="Psychiatry")){
				echo "<div class='location_row cf'>";
				echo "<div class='location_name'>";
				echo "<a href='javascript:myclick(".$counter.");doClose();'>";
				echo "<img src='" . $root . "/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon".$counter.".png'>";
				echo "</a>";
				//$customPointer = "var myimage_header_" . $count . " = '/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon" . $count . ".png'; ";
				//add link for heart care location 
				if($specialties=="Cardiology"){
				echo "<h2 class='location_practicegroup'><a href='/heart-care/seton-heart-institute/'>".$val["Name"]."</a></h2>";
				}
				else if(($val["Name"]=="Seton Mind Institute")){
				echo "<h2 class='location_practicegroup'><a href='/behavioral-health-care/seton-mind-institute/'>".$val["Name"]."</a></h2>";
				}
				else{		
				
				echo "<h2 class='location_practicegroup'>".$val["Name"]."</h2>";
				}
				echo "<span class='location_building'>".$val["Location"]."</span></div>";

				echo "<div class='map_address'>";
				$address1= $val['AddressLine1'];
				$address2= $val['AddressLine2'];
				$city= $val['city'];
				$state= $val['state'];
				$zip= $val['zipcode'];
				$PhoneNumber= $val['phonenumber'];
				// $fax= $val['Fax'];	
				$location1= $val['Location'];
				//echo $location."<br/>";
				$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddressTemp=($address1." ".$address2." ".$city." ".$state." ".$zip);
				echo $address1." ";
				echo $address2."<br/>";
				echo $city.", ".$state." ".$zip;
				echo "</div>";
				echo "<div class='mobile_address'><a class='btn btn-bdr-white' href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>";
				echo $address1." ";
				echo $address2."<br/>";
				echo $city.", ".$state." ".$zip;
				echo "</a></div>";
				echo "<div class='map_phone_fax'>&nbsp;";
				if(strlen($PhoneNumber) > 0 ) { echo "P: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber); }
				// if(strlen($fax) > 0 ) { echo "<br />F: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $fax); }
				echo "</div>";
				echo "<div class='mobile_phone'><a class='btn btn-blue' href='tel:".$PhoneNumber."'>".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber)."</a></div>";
				echo "<div class='map_view'>";
				echo "<a href='javascript:myclick(".$counter.");doClose();'> View on Map</a><br/>";
				//echo "<a href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>Get Directions</a>";
				$fullAddress= urlencode($address1." ".$address2." ".$city." ".$state." ".$zip);
				echo "<a href='http://maps.google.com/maps?saddr=&daddr=$fullAddress' target='_blank'>Get Directions</a>";
				echo "</div></div>";
				$counter++;
			}
			}
		}
	}
}
add_shortcode('Locations_By_Specialty', 'locationsBySpecialty');

//=========Locations========================================================
function locationsCustom($atts) {
	extract(shortcode_atts(array(
		'query' => ''
	), $atts));
	if($query == '') { return ''; }
	else {
		echo "<script type='text/javascript' src='//maps.google.com/maps/api/js?sensor=false'></script>";
		echo "<script type='text/javascript' src='/wp-content/plugins/seton_our_doctors/js/OverlappingMarkerSpiderfier.min.js'></script>";
		echo "<div class='map cf'><div id='map_canvas'></div>";
		if(function_exists('API_key')) { $apiKey=(API_key()); }
		else { echo "API is wrong"; }
		//$url= "http://www.setonfamilyofdoctors.com/api/" . $query . ".aspx?AuthCode=".$apiKey;
		 $url= "http://www.setonfamilyofdoctors.com/api/" . $query . ".aspx?AuthCode=".$apiKey;
		$strings= file_get_contents($url);  
		$json3=json_decode($strings, true);
		// var_dump($json3);
		$lat=array();
		$long=array();
		$names=array();
		$locations=array();
		$addressLine1J=array();
		$addressLine2J=array();
		$addressJ=array();
		if(!empty($json3)) {
			// $json3 = $json3['Locations']; // Weird array offset
			foreach($json3 as $key=>$val) {
				$name = "";
				$location1 = "";
				$address1 = "";
				$address2 = "";
				$city = "";
				$state = "";
				$zip = "";
				$PhoneNumber = "";
				$latitude = "";
				$longitude = "";
				$name = $val['PracticeName'];
				array_push($names, $name);
				$location1= $val['LocationName'];
				array_push($locations,$location1);
				$address1= $val['AddressLine1'];
				array_push($addressLine1J, $address1);
				$address2= $val['AddressLine2'];
				array_push($addressLine2J, $address2);
				$city= $val['City'];
				$state= $val['State'];
				$zip= $val['Zip'];
				array_push($addressJ,($city." ".$state." ".$zip));
				$PhoneNumber= $val['Phone'];
				// $fax= $val['Fax'];
				$latitude=$val['Latitude'];
				if(!isset($latitude)){
					$latitude="30.2500"; 
				}
				array_push ($lat,$latitude);
				$longitude=$val['Longitude'];
				if(!isset($longitude)){
					$longitude="-97.7500";
				}
				array_push ($long,$longitude);

				//Get Geo data////////////////////////////////////////////////////////
				$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
			}

			$locationMarkers = "";
			$latlngArray = "";
			$count = 1;

			for($i=0; $i < sizeof($addressLine1J); $i++) {
				// $locations[$i]=str_replace("'","\'",$locations[$i]);
				$names[$i]=str_replace("'","\'",$names[$i]);
				$contentString = "var contentString" . $count . " = '<div class=mapflyout2><span><h4 class=\'iw-practicegroup\'>".$names[$i]."</h4><strong>".$locations[$i]."</strong></span><span>".$addressLine1J[$i]."</span><span>".$addressLine2J[$i]."</span><span>".$addressJ[$i]."</span></div>';";

				// $contentString .= "var infowindow" . $count . " = new google.maps.InfoWindow({content: contentString" . $count . ", maxWidth: 400} ); ";
				$locationMarkers .= "\n" . $contentString;

				$customPointer = "var myimage" . $count . " = '/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon" . $count . ".png'; ";


				$locationMarkers .= "\n" . $customPointer;

				// create a line of JavaScript for marker on map for this record 
				$locationMarkers .= "\n" . "var mylatlng" . $count . " = new google.maps.LatLng(" . $lat[$i] . "," . $long[$i] . ");";
				//extend map bounds
				$locationMarkers .= "\n" . "bounds.extend(mylatlng" . $count . ");";

				$locationMarkers .= "\n" . "var marker" . $count . " = new google.maps.Marker({ position: mylatlng" . $count . ",  map: map, icon:myimage".$count.", title:\"" . $locations[$i] . "\" });";
                $locationMarkers .= "\n" . "oms.addMarker(marker" . $count . ");";

				$infowindow = "var infowindow" . $count . " = new google.maps.InfoWindow({ content: contentString" . $count . ", maxWidth: 400}); ";
				$locationMarkers .= "\n" . $infowindow;

				$listener = "google.maps.event.addListener(marker" . $count . ", 'click', function() { closewin(); currentinfowindow = infowindow" . $count . ";  infowindow" . $count . ".open(map,marker" . $count . "); });";
				// $listener = "oms.addListener('click', function(marker" . $count . ", event) {\n";
				// $listener .= "	iw.setContent(contentString" . $count . ");\n";
				// $listener .= "	iw.open(map, marker" . $count . ");\n";
				// $listener .= "});\n";

				// $listener .= "oms.addListener('spiderfy', function(markers) {\n";
				// $listener .= "	iw.close();\n";
				// $listener .= "});\n";

				$locationMarkers .= "\n" . $listener;
				$locationMarkers .= "\n" . "gmarkers.push(marker" . $count . ");";

				$latlngArray .= "mylatlng" . $count . ", ";						
				$count = $count +1;
			}
			$initJavascript = "var map = null;\n";
			$initJavascript .= "var gmarkers = [];\n"; 
			$initJavascript .= "var bounds = new google.maps.LatLngBounds();\n";
			$initJavascript .="var directionsDisplay;\n";
			$initJavascript .= "var currentinfowindow = null;\n";
			$initJavascript .= "directionsDisplay = new google.maps.DirectionsRenderer({preserveViewport: true});\n";

			$initJavascript .= "function initialize() {\n";
			$initJavascript .= "var latlng = new google.maps.LatLng(30.2669444, -97.7427778);\n";
			$initJavascript .= "var myOptions = { zoom: 8, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };\n";
			$initJavascript .= "map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);\n";
			$initJavascript .= "directionsDisplay.setMap(map);\n\n";

			// add OverlappingMarkerSpiderfier instance
			$initJavascript .= "var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true, keepSpiderfied: true});\n\n";

			// add InfoWindow instance
			// $initJavascript .= "var iw = new google.maps.InfoWindow({maxWidth: 400});\n";

			//reset map bounds
			$initJavascript .= "bounds = new google.maps.LatLngBounds();\n";
			
			$initJavascript .= $locationMarkers;
			$initJavascript .= "\n" . "fitMap();";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function initSpiderfy() {\n";
			$initJavascript .= "	google.maps.event.addListenerOnce(map, 'idle', function(){\n";
			$initJavascript .= "		myclick(1); currentinfowindow.close();\n";
			$initJavascript .= "	});\n";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function closewin()\n";
			$initJavascript .= "{\n";
			$initJavascript .= "    if (currentinfowindow!= null)\n";
			$initJavascript .= "    {\n";
			$initJavascript .= "        currentinfowindow.close();\n";
			$initJavascript .= "    }\n";
			$initJavascript .= "}\n\n";

			$initJavascript .= "function fitMap() {\n";
			$initJavascript .= "	closewin();\n";
			$initJavascript .= "	google.maps.event.trigger(map,'resize');\n";
			$initJavascript .= "	map.fitBounds(bounds);\n";
			//a single result will zoom all the way in...
			$initJavascript .= "	if (map.zoom > 17) { map.setZoom(17); }\n";
			$initJavascript .= "}\n";

			$initJavascript .= "function myclick(i) {\n";
			$initJavascript .= "    google.maps.event.trigger(gmarkers[i - 1], \"click\");\n";
			$initJavascript .= "}\n";

			$initJavascript .= "function doClose()\n ";
			$initJavascript .= "{\n";
			$initJavascript .= "    window.scrollTo(0,0);\n";
			$initJavascript .= "}\n\n";
			$initJavascript .= "initialize();initSpiderfy();\n";

			$initJavascript .= "var reboundMap = debounce(function() {\n";
			$initJavascript .= "	fitMap();\n";
			$initJavascript .= "}, 50);\n";

			$initJavascript .= "if (window.addEventListener) {\n";
			$initJavascript .= "	window.addEventListener('resize', reboundMap);\n";
			$initJavascript .= "}\n";
			$initJavascript .= "else { window.attachEvent('resize', reboundMap); }\n";
		}
		echo "<script type='text/javascript'>
				$initJavascript; 
			</script>
			</div>";

		echo "<div class='location_header_row cf'>";
		echo "<div class='location_name'><span>Location</span></div>";
		echo "<div class='map_address'>Address</div>";
		echo "<div class='map_phone_fax'>Phone</div>";
		echo "<div class='map_view'>&nbsp;</div></div>";
		$counter=1;
		$root = home_url();
		if(!empty($json3)) {
			foreach($json3 as $key=>$val) {
				echo "<div class='location_row cf'>";
				echo "<div class='location_name'>";
				echo "<a href='javascript:myclick(".$counter.");doClose();'>";
				echo "<img src='" . $root . "/wp-content/plugins/seton_our_doctors/Img/mapIcons/mapIcon".$counter.".png'>";
				echo "</a>";
				echo "<h2 class='location_practicegroup'>".$val["PracticeName"]."</h2>";

				echo "<span class='location_building'>".$val["LocationName"]."</span></div>";

				echo "<div class='map_address'>";

				$address1= $val['AddressLine1'];
				$address2= $val['AddressLine2'];
				$city= $val['City'];
				$state= $val['State'];
				$zip= $val['Zip'];
				$PhoneNumber= $val['Phone'];
				// $fax= $val['Fax'];	
				// $location1= $val['AddressLocation'];
				$location1= $val['LocationName'];
				//echo $location."<br/>";
				$fullAddressTemp=($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddress= urlencode($location1." ".$address1." ".$address2." ".$city." ".$state." ".$zip);
				$fullAddressTemp=($address1." ".$address2." ".$city." ".$state." ".$zip);
				echo $address1." ";
				echo $address2."<br/>";
				echo $city.", ".$state." ".$zip;
				echo "</div>";
				echo "<div class='mobile_address'><a class='btn btn-bdr-white' href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>";
				echo $address1." ";
				echo $address2."<br/>";
				echo $city.", ".$state." ".$zip;
				echo "</a></div>";
				echo "<div class='map_phone_fax'>&nbsp;";
				if(strlen($PhoneNumber) > 0 ) { echo "P: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber); }
				// if(strlen($fax) > 0 ) { echo "<br />F: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $fax); }
				echo "</div>";
				echo "<div class='mobile_phone'><a class='btn btn-blue' href='tel:".$PhoneNumber."'>".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber)."</a></div>";
				echo "<div class='map_view'>";
				echo "<a href='javascript:myclick(".$counter.");doClose();'> View on Map</a><br/>";
				//echo "<a href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>Get Directions</a>";
				$fullAddress= urlencode($address1." ".$address2." ".$city." ".$state." ".$zip);
				echo "<a href='http://maps.google.com/maps?saddr=&daddr=$fullAddress' target='_blank'>Get Directions</a>";
				echo "</div></div>";
				$counter++;
			}
		}
	}
}
add_shortcode('Locations_Custom', 'locationsCustom');

function researchDoctors() {
	$practiceName = our_doctors();
	$practiceName = str_replace (" ","%20",$practiceName);
	$practiceName = str_replace ("&", "%26", $practiceName);
					
	if(function_exists('API_key')) { $practiceURLTemp=(API_key()); }
	else { echo "API is wrong"; }
	//else{
	$practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);
	//echo $practiceURL;
	//}		
	//echo $practiceURL;
	$practiceURL=str_replace(" ","%20",$practiceURL);				
	$practiceString = file_get_contents($practiceURL); 

	$json2=json_decode($practiceString, true);					
	$practiceID = $json2["ID"];					
	$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianSearch.aspx?AuthCode=".$practiceURLTemp."&PhysicianName=&PracticeID=".$practiceID."&ShowNonPhysicians=true" );
	$url=str_replace(" ","%20",$url);
	$strings= file_get_contents($url);  
	$json=json_decode($strings, true);

	//For each name
	$doctorString="";
	$providerString="";
	foreach($json as $key=>$val)
	{
		$DaFullName=$val['PhysicianName'];
		// $DaFullName = str_replace (".","'.'",$DaFullName);
		$EachProfileURL = ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$DaFullName);
		$EachProfileURL=str_replace(" ","%20",$EachProfileURL);
		$profileString= file_get_contents($EachProfileURL);
		$EachProfile = json_decode($profileString, true);
		if($EachProfile["IsResearchPhysician"])
		{
			$Name= $EachProfile["ImageLink"];
			$FullName=str_replace ("-"," ",$DaFullName);		   
			$linkName=str_replace(' ', '-', $DaFullName);
			$linkName=str_replace(". ",".",$DaFullName);
			// echo "link name: ".$linkName;
			if(strlen($EachProfile["Specialties"])>0)
			{
				$doctorString.= "<div class='doctor_thumb'>";
				// $doctorString.= "<img src='".(image()).$Name."'/>";
				$doctorString.= "<img src='/images/sfod/".$Name."'/>";
				// $doctorString.= "<img src='/images/profiles/".$Name."'/>";
				$doctorString.= "<a href='/heartcare/seton-heart-institute/providers/provider-profile/".($linkName). "'>". $FullName ."</a><br/>";
				$doctorString.= ($val['PhysicianSpecialties']) ."<br/>";
				$doctorString.= "</div>";
			}
			else
			{
				$providerString.= "<div class='doctor_thumb research'>";
				// $providerString.= "<img src='".(image()).$Name."'/>";
				$doctorString.= "<img src='/images/sfod/".$Name."'/>";
				// $doctorString.= "<img src='/images/profiles/".$Name."'/>";
				$providerString.= "<a href='/heartcare/providers/provider-profile/".($linkName). "'>". $FullName ."</a><br/>";
				$providerString.= ($val['PhysicianSpecialties']) ."<br/>";
				$providerString.= "</div>";
			}
		}
	}
	echo "<div class='doctor_research'>$doctorString</div>";
	echo "<div class='provider_research'>$providerString</div>";	
}
add_shortcode('research_doctors', 'researchDoctors');

//====================Admin page==================================-->	
function our_doctors_html_page() {
?>
	<div>
		<h2>Practice Options</h2>
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<!--table starts============================================================-->
			<table width="950" align="left">
				<!--practice name==============-->
				<tr valign="top">
					<th width="105" scope="row">Enter the practice name</th>
					<td width="800">
						<input name="our_doctors_data" type="text" id="our_doctors_data" size="100"
						value="<?php echo get_option('our_doctors_data'); ?>" /><br>
						(ex. Institute of Reconstructive Plastic Surgery of Central Texas)<br><br>
					</td>
				</tr>

				<!--API address================-->
				<tr valign="top">
					<th width="105" scope="row">Enter the API key</th>
					<td width="446">
						<input name="API_key_data" type="text" id="API_key_data" size="100"
						value="<?php echo get_option('API_key_data'); ?>" /><br>
						(ex. 2a5de188-4abc-4c26-87a2-bbdc5c847382)<br><br>
					</td>
				</tr>

				<!--Photo address===============-->
				<tr valign="top">
					<th width="105" scope="row">Enter the Image address" URL</th>
					<td width="446">
						<input name="image_data" type="text" id="image_data" size="100"
						value="<?php echo get_option('image_data'); ?>" /><br>
						(ex. http://www.setonfamilyofdoctors.com/assets/)<br><br>
					</td>
				</tr>

				<!--Our Doctors URL=======================-->
				<tr valign="top">
					<th width="105" scope="row">Enter the Doctors List Page URL</th>
					<td width="446">
						<input name="ourdoctors_single_pg_data" type="text" id="ourdoctors_single_pg_data" size="100"
						value="<?php echo get_option('ourdoctors_single_pg_data'); ?>" /><br>
						(ex. www.example.com/<font color="red">our-doctors</font>, the red part)<br><br>
					</td>
				</tr>

				<!--Practice location URL=======================-->
				<tr valign="top">
					<th width="105" scope="row">Enter the Practice location page URL</th>
					<td width="446">
						<input name="location_single_pg_data" type="text" id="location_single_pg_data" size="100"
						value="<?php echo get_option('location_single_pg_data'); ?>" /><br>
						(ex. location)<br><br>
					</td>
				</tr>

				<!--our-physician URL=======================-->
				<tr valign="top">
					<th width="105" scope="row">Enter the Physician profile page URL</th>
					<td width="446">
						<input name="physician_single_pg_data" type="text" id="physician_single_pg_data" size="100"
						value="<?php echo get_option('physician_single_pg_data'); ?>" /><br>
						(ex. our-physician)<br><br>
					</td>
				</tr>

				<!--Search page URL=======================-->
				<tr valign="top">
					<th width="105" scope="row">Enter the Search page URL</th>
					<td width="446">
						<input name="search_single_pg_data" type="text" id="search_single_pg_data" size="100"
						value="<?php echo get_option('search_single_pg_data'); ?>" /><br>
						(ex. search-doctors)<br><br>
					</td>
				</tr>
				<!--doctor meta================================-->

				<tr>
					<td>
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="our_doctors_data,API_key_data,image_data,ourdoctors_single_pg_data,physician_single_pg_data,search_single_pg_data,location_single_pg_data" />
						<!--<input type="hidden" name="page_options" value="API_key_data" />
						<input type="hidden" name="page_options" value="image_data" />-->

						<p>
						<input type="submit" value="<?php _e('Save Changes') ?>" />
						</p>
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php
}
?>