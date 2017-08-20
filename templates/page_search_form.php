<?php
/*
Template Name: Contact
*/
?>


<?php get_header() ?>
	<div id="container">
		<div id="content">
			<?php the_post() ?>
			<div id="post-<?php the_ID() ?>" class="post">
				<div class="entry-content">
				<form>
				</form>
				
				<!--Form=================================--->
				
				<!-- action="wp-content/plugins/JsonParser/JsonParser.php" -->
				
				  <form  method="POST" >
				     <strong>Search by a Doctor's Name</strong><br/><br/>
					 Last Name:<br/>
					 <input type="text" name="lastName"  size=25 maxlength=25/><input type="submit" value="Search"/>
					 <input type="hidden" name="HDN_FormClicked" value="WasClicked" />
     					 
				  </form>
				  
				  
				  
          <!--EndForm=================================-->
		  
			<?php
			
			//If type nothing, will show all physicians after click the button
		  	if(isset ($_POST)){	
				if (strlen($_POST["HDN_FormClicked"])>0 && (strlen($_POST["lastName"])<=0))
				{
					if(function_exists('our_doctors')) {
					 $practiceName= our_doctors();
					}
					//else($practiceName = "Institute of Reconstructive Plastic Surgery of Central Texas";)
					$practiceName = str_replace (" ","%20",$practiceName);
					
					$practiceURL = ("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PracticeIDByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PracticeName=".$practiceName);
					$practiceString = file_get_contents($practiceURL); 

					$json2=json_decode($practiceString, true);					
				  $practiceID = $json2["ID"];
					
          $url= ("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PhysicianSearch.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=&PracticeID=".$practiceID );
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);	
          foreach($json as $key=>$val)
					{  $DaFullName=$val['PhysicianName'];
					   $FullName=str_replace ("-"," ",$DaFullName);
						echo "<a href='/index.php/physician-profile?lastName=" . ($val['PhysicianName']) . "'>". $FullName ."</a><br/>";
						
					}						
				
				
				}
				
				}
			 
            //Type something			 
				if (strlen($_POST["lastName"])>0 )
				{
				
					$LastName = $_POST["lastName"];
					
					$LastName = str_replace ("%20"," ",$LastName);
					
				
					echo "Search Results For: " . $LastName;
					
					//get search results
					//if(("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PhysicianSearch.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$LastName )){
					  $url=("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PhysicianSearch.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$LastName );
					
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);
					
					echo "<br/>";	
					if(!isset($json)&& (!empty($json))){
					foreach($json as $key=>$val)
					{
					    $DaFullName=$val['PhysicianName'];
					    $FullName=str_replace ("-"," ",$DaFullName);
						echo "<a href='/index.php/physician-profile?lastName=" . $val['PhysicianName'] . "'>". $val['PhysicianName'] ."</a><br/>";
						
					//}	
					}
					}
					else{
					
					//if type partial words
					$practiceName = "Institute of Reconstructive Plastic Surgery of Central Texas";
					$practiceName = str_replace (" ","%20",$practiceName);
					
					$practiceURL = ("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PracticeIDByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PracticeName=".$practiceName);
					$practiceString = file_get_contents($practiceURL); 

					$json2=json_decode($practiceString, true);					
				    $practiceID = $json2["ID"];//echo $practiceID;echo $LastName;
					$url=("http://setonfamilyofdoctors.setonnetdev2.vertex.com/api/PhysicianSearch.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$LastName."&PracticeID=".$practiceID);
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);
									
					if(!empty($json)){
					  foreach($json as $key=>$val)
					{
					    $DaFullName=$val['PhysicianName'];
					    $FullName=str_replace ("-"," ",$DaFullName);
						echo "<a href='/index.php/physician-profile?lastName=" . $val['PhysicianName'] . "'>". $FullName ."</a><br/>";						
						
					}
					}
					else{
					  echo "No Physician Found";
					  
					}
					}}
			?>		  
		  
		  
		  
		  
		  
		 
				</div><!-- .entry-content ->
			</div><!-- .post-->
		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>