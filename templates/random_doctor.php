		 <!--physician info block: RL, Vertex-->
		 
		   <?php
		     $practiceName = our_doctors();			
			
					$practiceName = str_replace (" ","%20",$practiceName);
					$practiceName = str_replace ("&", "%26", $practiceName);
					
		if(function_exists('API_key')) {          
			
			$practiceURLTemp=(API_key());
			}
		  else{
		   echo "API is wrong";
		      }
			  
		    $doctorName=array();
		    $practiceURL = ("http://www.setonfamilyofdoctors.com/api/PracticeIDByName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);
				
				
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
					 
					   $EachProfileURL = ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$DaFullName);
					   $EachProfileURL=str_replace(" ","%20",$EachProfileURL);
					   
					   $profileString= file_get_contents($EachProfileURL);
					   $EachProfile = json_decode($profileString, true);
					   //$Name= $EachProfile["ImageLink"];
					   $FullName=str_replace ("-"," ",$DaFullName);
                    		   
					   $linkName=str_replace(' ', '-', $DaFullName);
					   $linkName=str_replace(". ",".",$DaFullName);
					 
					   array_push($doctorName, $linkName);
					   /*echo "<div class='doctor_thumb'>";
					  
					   echo "<img src='".(image()).$Name."'/>";
					   
					    echo "<a href='/physician-profile/".($linkName). "'>". $FullName ."</a><br/>";
                        					
					   echo ($val['PhysicianSpecialties']) ."<br/>";
   					   echo "</div>";*/

						
					}	//}
					  
					 
					   $randomDoctor=array_rand($doctorName, 1);
					   $singleDoctor=$doctorName[$randomDoctor];
					

					//get random doctor information//////////////////////////////////////////
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$singleDoctor );
					$url = str_replace(" ","%20",$url);
					//echo $url;
					$strings= file_get_contents($url);
					
					
					$json=json_decode($strings, true);
					//image
					$imageURL= (image().$json["ImageLink"]);					
				    //echo "<img src='".$imageURL."'/>";
					
					//name
					//echo $singleDoctor."<br/>";
					
					//$credentials
					
						
						if(strlen($json["Credentials"]) > 0){
							$credentials = $json["Credentials"];
							}
						else{
						   $credentials = "";
						}
						$imageURL= (image().$json["ImageLink"]);
						//echo "<img src='".$imageURL."'/>"; 
						
					//Specialties
					$specialy=$json["Specialties"];
					//bio
					$summary = implode('.', array_slice(explode('.', $json['Biography']), 0, 2)) . '.';
					//$json['Biography']
					  
					$string= "<div id='physician-showcase'>
								<h2>Physician <span class='text-blue'>Showcase</span></h2>
									<div id='physician'>
										<img src=$imageURL alt=$singleDoctor class='physician-image' />
										<p class='bio'><a href='#' class='name text-blue'>$singleDoctor,</a>$credentials, $specialy</p>
										<p>$summary</p>
										</div>
								<a class='button button-blue'>Meet All Our Physicians <span class='arrow-icon' aria-hidden='true' data-icon='&#x25BB;'></span></a>
								</div>";
					
					  
					   
        ?>	