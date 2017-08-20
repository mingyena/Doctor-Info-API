<?php
/*
Template Name: physician-profile
*/
?>



<?php get_header() ?>
	<div id="container">
		<div id="content">
			<?php the_post() ?>
			<div id="post-<?php the_ID() ?>" class="post">
				<div class="entry-content">
								
				<?php	
                //echo (get_query_var('lastName'));  
                 if(isset($wp_query->query_vars['lastName'])) {
                 $lastName=(urldecode($wp_query->query_vars['lastName']));}
				 
			 
				 
				if (strlen(urldecode($wp_query->query_vars['lastName']))>0 )
				{
				 
                  
					$LastName = urldecode($wp_query->query_vars['lastName']);
					//$LastName = str_replace ("%20","_",$LastName);
					$LastName = str_replace (".",".%20",$LastName);
					$LastName = str_replace (" ","_",$LastName);
					
					//echo $LastName."<br/>";
					//get search results//////////////////////////////////////////
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$LastName );
					$url = str_replace(" ","%20",$url);
					//echo $url;
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);	          
				?>			 
			
					<div>					
					<?php 	
					//Name, title, image/////////////////////////////////////////
						$credentials = $json["Credentials"];
						
						if(strlen($credentials) > 0){
							$credentials = ", ".$credentials;
							}
						else{
						   $credentials = "";
						}
						$imageURL= (image().$json["ImageLink"]);
						echo "<img src='".$imageURL."'/>";
						
					?>
					</div>
					
				<div> 
					<?php 
					    echo "<h1>".$json["FirstName"]."&nbsp".$json["LastName"].$credentials."</h1>";
						//echo "<h3>Specialties</h3>";
						echo $json["Specialties"]."<br/>"; 
						//echo "<h3>Bio</h3>";						
						echo "<font size='2'>".$json["Biography"]."</font>";
						
						//if (!isset($json["AdditionalInfo"])||!empty($json["AdditionalInfo"]))
						 {	//$imageSource=str_replace("..","",($json["$AdditionalInfo"]));						 	
							echo "certificate: ".$json["$AdditionalInfo"];
						    //echo "<img src=".$imageSource."/>";
						 }echo "<br class='clearAll'>";
					?>	
				</div>
		  
				<div>
				
				<?php
				//Video link////////////////////////////////////////////////////////////////////////////////////
					//Does this Physician Have a Video Link
					if(strlen($json["VideoLink"]) > 0)
					{ 
					$lastCode=substr($json["VideoLink"],(strrpos($json["VideoLink"],"/")));
					$lastCode= "http://www.youtube.com/v".$lastCode;					
				/*echo "
				<script type='text/javascript' src='/plugins/Senton Family of Doctors Plugin/jquery.DOMWindow.js'></script>
				<link rel='stylesheet' type='text/css' href='video_site.css'></link>

                     <div class='video'>

                    <img src='/Assets/VideoImages/harshbarger-raymond.jpg' alt='Video Preview'>

                    <a class='popup_640x390 btn_blue_rounded_small' href='http://www.youtube.com/embed/VZarq0U2UtI'>Video Introduction</a>

                </div>";*/

				
				
				  
                  echo "<object width='200' height='150' data=".$lastCode." type='application/x-shockwave-flash'><param name='src' value=".$lastCode." /></object>";
	
					  //print "Video Link: ".$json["VideoLink"];
					}
	  
					$practiceName = our_doctors(); //"Institute of Reconstructive Plastic Surgery of Central Texas";
					$practiceName = str_replace (" ","%20",$practiceName);
					$practiceName = str_replace ("&", "%26", $practiceName);
					
			      if(function_exists('API_key')) {          
			
			        $practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PracticeName=".$practiceName);
					}
		          else{
		            //$practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PracticeName=".$practiceName);
			           }
					$practiceURL=str_replace(" ","%20",$practiceURL);					   
					$practiceString = file_get_contents($practiceURL); 

					$json2=json_decode($practiceString, true);					
					$practiceID = $json2["ID"]; //Get Practice ID     

					$physicianID = $json["ID"]; //Get The Doctor ID

					
					
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianAddressesByID.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianID=".$physicianID."&PracticeID=".$practiceID );
					//echo $url;
					//echo $physicianID;
					$url = str_replace(" ","%20",$url);
					$strings= file_get_contents($url);  
					$json3=json_decode($strings, true);	

					//print $practiceString;
					
				?>
				<h3>Practice Information</h3>
				<?php
				//Address of doctors////////////////////////////////////////////////////	
					if(!empty($json3)){
						//$num_keys=count($key);
						//if(!(isset($num_keys))||!(empty($num_keys))){
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
					   
							print $location."<br/>";
							print $address1."<br/>";
							print $address2."<br/>";
							print $city.", ".$state." ".$zip."<br/>";
							
							if(strlen($phone) > 0 )
								print "Phone: ".$phone."<br/>";
							
							if(strlen($fax) > 0 )
								print "Fax: ".$fax."<br/>";

							print "<br/><br/>";
						}
					if(function_exists('our_doctors')) {
          
			            $practiceName = our_doctors();
			              
					echo "<a href='/locations-and-directions'>Map & Directions</a><br/>";				
					}}			
					}
					else
					{
						echo "No Physician Found";
					}
				
             
	  
      ?>
		 </div><!--addresses-->
				</div><!-- .entry-content ->
			</div><!-- .post-->
		</div><!-- #content -->
	<!-- #container -->


<?php get_footer() ?>
<?php
function physicianChecker($phyInfo){
  if ((isset($phyInfo))||empty($phyInfo))
    {
	  print " ";
	}
  else
      print " ,".$phyInfo;
}
?>