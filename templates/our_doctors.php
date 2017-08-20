<?php
/**
 * Template Name: Our Doctor Page
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<style>
.doctor_thumb {
line-height: 1.2em !important;
margin: 0 15px 0 0;
max-width: 145px;
text-align: left;
float: left;
min-height: 310px;
}

</style>

	<div id="primary" class="site-content">
		<div id="content" role="main">
		
		<div style="display: block; ">
		<h2>Our Doctors</h2><br/>
		</div>
		
		<div style="display: block;">
		<?php
		

         
          
			$practiceName = our_doctors();
			
			//$practiceName = "Seton Heart Institute";
					$practiceName = str_replace (" ","%20",$practiceName);
					$practiceName = str_replace ("&", "%26", $practiceName);
					
		if(function_exists('API_key')) {          
			
			$practiceURLTemp=(API_key());
			}
		  else{
		   echo "API is wrong";
		      }
		//else{
		    $practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);
			//echo $practiceURL;
			//}		
				//echo $practiceURL;
                    $practiceURL=str_replace(" ","%20",$practiceURL);				
					$practiceString = file_get_contents($practiceURL); 

					$json2=json_decode($practiceString, true);					
					$practiceID = $json2["ID"];					
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianSearch.aspx?AuthCode=".$practiceURLTemp."&PhysicianName=&PracticeID=".$practiceID );
					$url=str_replace(" ","%20",$url);
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);
				
         					
					//For each name
					foreach($json as $key=>$val)
					{  $DaFullName=$val['PhysicianName'];
					  // $DaFullName = str_replace (".","'.'",$DaFullName);
					   $EachProfileURL = ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$DaFullName);
					   $EachProfileURL=str_replace(" ","%20",$EachProfileURL);
					   //$profileString = file_get_cocntents("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=J.%20Brian-Kang");
					   //$profileString = file_get_cocntents("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=J.%20Brian-Kang");
					   $profileString= file_get_contents($EachProfileURL);
					   $EachProfile = json_decode($profileString, true);
					   $Name= $EachProfile["ImageLink"];
					   $FullName=str_replace ("-"," ",$DaFullName);
                      //echo "full name: ".$FullName."<br/>";				   
					   $linkName=str_replace(' ', '-', $DaFullName);
					   $linkName=str_replace(". ",".",$DaFullName);
					  // echo "link name: ".$linkName;
					   
					   echo "<div class='doctor_thumb'>";
					  
					   echo "<img src='".(image()).$Name."'/>";
					   
					    echo "<a href='/physician-profile/".($linkName). "'>". $FullName ."</a><br/>";
					    //echo "<a href='/index.php/physician-profile?lastName=".($val['PhysicianName'])."'>". $FullName ."</a><br/>";
                        					
					   echo ($val['PhysicianSpecialties']) ."<br/>";
   					   echo "</div>";

						
					}	//}
        ?>					
		</div>
		
		</div><!-- #content -->
	</div><!-- #primary -->
<?php



 get_sidebar( 'front' ); ?>
<?php get_footer(); ?>