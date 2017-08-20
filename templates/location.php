<?php
/**
 * Template Name: locations-and-directions
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * 
 * 
 */

 

get_header(); ?>
	<div class="page-wrapper border-rt">
		<div id="primary" class="site-content">
			<?php the_post() ?>
			<div id="content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content">
					<h1><?php the_title(); ?></h1>
					<p>The Austin Dermatologic Surgery Center is located in the Clinical Education Center at University Medical Center at Brackenridge in downtown Austin. Clinical services offered include Mohs micrographic surgery, skin cancer excision and reconstruction, mole and cyst removal, nail avulsion, as well as the management of melanoma and other high-risk skin cancers.</p>
					<p>For patient referrals, please call 512-324-7468.</p>
							
		    <!--google map///////////////////////////////////////////////////////-->
		
							<?php
								
								$practiceName = our_doctors();	 
								$practiceName=str_replace(" ","%20",$practiceName);
								$practiceName = str_replace ("&", "%26", $practiceName);
								if(function_exists('API_key')) {          
								
								$practiceURLTemp=(API_key());
								}
							  else{
							   echo "API is wrong";
							      }
								$url= ("http://www.setonfamilyofdoctors.com/api/LocationsByPracticeName.aspx?AuthCode=".$practiceURLTemp."&PracticeName=".$practiceName);			 
								  // echo $url;
									$strings= file_get_contents($url);  
										$json3=json_decode($strings, true);
								$lat=array();
								$long=array();
								$locations=array();
								$addressLine1J=array();
								$addressLine2J=array();
								$addressJ=array();
								//$fulladdressJ=array();
									
							?>	
			
							
							<h2>Austin Dermatologic Surgery Center | Clinical Education Center at Brackenridge</h2>
							<?php
								$counter=1;
								if(!empty($json3))
									{
								      foreach($json3 as $key=>$val){
											$address1= $val['AddressLine1'];
											$address2= $val['AddressLine2'];
											$city= $val['City'];
											$state= $val['State'];
											$zip= $val['ZipCode'];
											$PhoneNumber= $val['PhoneNumber'];
											$fax= $val['Fax'];				  
										    //echo $location."<br/>";
											echo "<p>".$address1.", ";
											echo $address2."<br/>";
											echo $city.", ".$state." ".$zip."<br/>";
											if(strlen($PhoneNumber) > 0 )
											{
												echo "Phone: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '$1-$2-$3', $PhoneNumber). "<br/>";
											}
											if(strlen($fax) > 0 )
											{
												echo "Fax: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '$1-$2-$3', $fax). "</p>";
											}
											echo "<a target='_blank' href='http://maps.google.com/maps?saddr=&daddr=".$address1."&nbsp;".$city."&nbsp;".$zip."'>Map &amp; Driving Directions</a></p>";
											$counter++;
										}
									}
							?>


							<h2>Parking and Directions</h2>
							<p>Our office is on the second floor of the Clinical Education Center at University Medical Center at Brackenridge in downtown Austin.</p>
							<p><em>From the North:</em><br />
							Take IH-35 South to Exit #235A toward 15th Street. Once on the frontage road, go through the traffic light at 15th street, then take your first right into the Clinical Education Center (CEC) entrance. Parking garage is on the left. Two spaces assigned to the Austin Dermatologic Surgery Center are available on the left side of the entrance ramp immediately after entering the garage.</p>

							<p><em>From the South:</em><br />
							Take IH-35 North to Exit #235A toward 15th Street. Once on the frontage road, make a U-turn before the traffic light at 15th street. Once on the southbound frontage road, take your first right into the Clinical Education Center (CEC) entrance. Parking garage is on the left. Two spaces assigned to the Austin Dermatologic Surgery Center are available on the left side of the entrance ramp immediately after entering the garage.</p>

							<p><em>From the West:</em><br />
							Take 15th St East past the State Capitol and the Erwin Center. Make a right onto the IH-35 southbound frontage road Once on the southbound frontage road, take your first right into the Clinical Education Center (CEC) entrance. Parking garage is on the left. Two spaces assigned to the Austin Dermatologic Surgery Center are available on the left side of the entrance ramp immediately after entering the garage.</p>



	    <!--////////////////////////////////End of google map/////////////////////////////-->

     




		
				</div><!-- .entry-content -->
			</article><!-- #post -->
			</div><!-- #content -->
		</div><!-- #primary -->

	<?php get_sidebar(); ?>

	</div><!-- #container -->


<?php get_footer() ?>