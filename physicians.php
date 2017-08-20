

		<?php
		    add_filter('widget_text', 'do_shortcode');
		function physicianList(){
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
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianSearch.aspx?AuthCode=".$practiceURLTemp."&PhysicianName=&PracticeID=".$practiceID."&ShowNonPhysicians=true" );
					
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
					   $middleName=$EachProfile["MiddleInitial"];
					   $credential=$EachProfile["Credentials"];
					   $spec=$EachProfile["Specialties"];
						
					   $FullName=str_replace ("-"," $middleName ",$DaFullName);
                      //echo "full name: ".$FullName."<br/>";				   
					   $linkName=str_replace(' ', '-', $DaFullName);
					   $linkName=str_replace(". ",".",$DaFullName);
					  
					  // echo "link name: ".$linkName;
					   
					   echo "<div class='doctor_thumb'>";
					  
					   echo "<a href='/seton-heart-institute/our-team/doctor-profile/".($linkName). "'><img src='".(image()).$Name."' alt='" . $FullName . ", " . $credential. "'/></a>";
					   
					   if(!isset($credential))
					   echo "<br/><a class='doctor_name' href='/seton-heart-institute/our-team/doctor-profile/".($linkName). "'>". $FullName."</a>";
					    //echo "<a href='/index.php/physician-profile?lastName=".($val['PhysicianName'])."'>". $FullName ."</a><br/>";
					   else echo "<br/><a class='doctor_name' href='/seton-heart-institute/our-team/doctor-profile/".($linkName). "'>". $FullName .", ".$credential."</a>";
					   echo "<div class='doctor_specialties'>".$spec."</div>";
   					   echo "</div>";//<!--Doctor thumb-->

						
					}	
					}
					add_shortcode('Physician_List', 'physicianList');
        ?>					