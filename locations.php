
   <?php
   include ('our_doctors.php');
   function locations()
   {
           echo "<div class='map cf'>
            	
                <div id='map_canvas'></div>";
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
			  //echo $url;
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
								
					echo "//Get Geo data////////////////////////////////////////////////////////";
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
				$initJavascript .= "var directionsDisplay = new google.maps.DirectionsRenderer({
				preserveViewport: true});\n";				 
                $initJavascript .= "var latlng = new google.maps.LatLng(30.2669444, -97.7427778);\n";
                $initJavascript .= "var myOptions = { zoom:8, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP };\n";
                $initJavascript .= "map = new google.maps.Map(document.getElementById(\"map_canvas\"), myOptions);\n";
				$initJavascript .= "directionsDisplay.setMap(map);";
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
			
			echo "<!--locations=========================================-->";
			
            
            echo "<div class='location_header_row cf'>";
            echo "<div class='location_name'><span>Location</span></div>";
            echo "<div class='map_address'>Address</div>";
            echo "<div class='map_phone_fax'>Phone</div>";
            echo "<div class='map_view'>&nbsp;</div></div>";
            
			  
			  
			  $counter=1;
			  $root = home_url();
			  
				if(!empty($json3))
			{
			     
			      foreach($json3 as $key=>$val){
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
					echo $address1." ";
					echo $address2."<br/>";
					echo $city.", ".$state." ".$zip;
					echo "</div>";
					echo "<div class='mobile_address'><a class='btn btn-bdr-red' href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>";
					echo $address1." ";
					echo $address2."<br/>";
					echo $city.", ".$state." ".$zip;
					echo "</a></div>";
					echo "<div class='map_phone_fax'>";					
					if(strlen($PhoneNumber) > 0 )
					{
						echo "P: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber);
					}
					if(strlen($fax) > 0 )
					{
						echo "<br />F: ".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $fax);
					}
					echo "</div>";
					echo "<div class='mobile_phone'><a class='btn btn-red' href='tel:".$PhoneNumber."'>".preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $PhoneNumber)."</a></div>";
					echo "<div class='map_view'>";
				    echo "<a href='javascript:myclick(".$counter.");doClose();'> View on Map</a><br/>";
					echo "<a href='http://maps.google.com/maps?saddr=&daddr=".$fullAddress."'>Get Directions</a>";
				echo "</div></div>";
				$counter++;
				  }
			}
		}?>
           



