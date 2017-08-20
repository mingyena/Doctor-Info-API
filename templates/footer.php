<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<footer>
		<div id="footer-info" class="wrapper">
			<ul class="first">
				<li class="border-tp-bk">
					<h4 class="title-text aqua-text">FIND US</h4>
					<div class="image-box-bk">
				    <!--google map///////////////////////////////////////////////////////-->
			
					    <div>
				            <div class="map">
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
									if(!empty($json3))
									{


									echo "<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>";

						            
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
													//array_push($fullAddressJ,$fullAddressTemp);
													/*$geoAddress="http://maps.google.com/maps/api/geocode/json?address=".$fullAddress."&sensor=false";
													$geocode=file_get_contents($geoAddress);
													$output= json_decode($geocode);
													$latTemp = $output->results[0]->geometry->location->lat;
													if (is_array($lat)) {
						                                   array_push($lat,$latTemp);
														}
													else {echo "occupied.";}
													
													
													$longTemp = $output->results[0]->geometry->location->lng;
													array_push($long,$longTemp);*/
													
													//Insert to map
						                            					
													
													
													//echo "<a href=''>View in the map</a>";
												    //echo "<a href='https://maps.google.com/maps?f=d&saddr=&daddr=".$fullAddress."'>Get Directions</a>";
													//$counter++;

													//echo "<br/><br/>";
										}
						                //echo "longitutde: ".$long[15];
										$locationMarkers = "";
										$latlngArray = "";
										$count = 1;
										
										
										
										
										for($i=0; $i < sizeof($addressLine1J); $i++)
										{
										
										    $locations[$i]=str_replace("'","\'",$locations[$i]);
						                    $contentString = "var contentString" . $count . " = '<div class=mapflyout2><strong>" . $locations[$i] . "</strong><br/>".$addressLine1J[$i]."<br/>".$addressLine2J[$i]."<br/>".$addressJ[$i]."</div>';";
											
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
						                $initJavascript .= "var gmarkers = []\n"; 
						                $initJavascript .= "var currentinfowindow = null;\n";

						                $initJavascript .= "function initialize() {\n";
						                $initJavascript .= "var latlng = new google.maps.LatLng(30.2669444, -97.7427778);\n";
						                $initJavascript .= "var myOptions = { zoom: 9, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };\n";
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

										
								?>	
				
								<div id="map_canvas"></div>
								
					            <script type="text/javascript">
					           
							    <?php echo $initJavascript; ?>

								          
					            </script>	

							</div>
						</div>	


								
	    <!--////////////////////////////////End of google map/////////////////////////////-->

					</div>
				</li>
			</ul>
			<ul>
				<li class="border-tp-bk">
					<h4 class="title-text aqua-text">CONTACT</h4>
					<p><div class="phone-icon" aria-hidden="true" data-icon="&#xe009;"></div><a href="tel:15123247468">512.324.7468</a> | FAX: 512.324.7469</p>
					<p><div class="email-icon" aria-hidden="true" data-icon="&#xe006;"></div><a href="mailto:info@adsc.com">info@adsc.com</a></p>
				</li>
				<li class="border-tp-bk border-bt-bk">
					<h4 class="title-text aqua-text">WHAT WE TREAT</h4>
					<ul>
						<li><a href="http://austindermatology.wordpress.vertex.com/skin-cancer/">Skin Cancer</a></li>
						<li><a href="http://austindermatology.wordpress.vertex.com/mole-and-cyst-removal/">Moles and Cysts</a></li>
						
					</ul>
				</li>
			</ul>
			<ul id="mobile-footer">
				<li><a href="/location/" class="button-aqua"><div class="map-icon-aqua" aria-hidden="true" data-icon="&#xe008;"></div>FIND US</a></li>
				<li><a href="/contact-us/" class="button-aqua"><div class="phone-icon-aqua" aria-hidden="true" data-icon="&#xe009;"></div>CONTACT US</a></li>
				<li><a href="/contact-us/" class="button-aqua">MAKE AN APPOINTMENT<div class="arrow-aqua" aria-hidden="true" data-icon="&#xe005;"></div></a></li>
			</ul>
			<small>&copy; <?php echo date("Y") ?> Seton Healthcare Family</small>
			<a href="/website-feedback/" class="feedback">Website Feedback</a>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>