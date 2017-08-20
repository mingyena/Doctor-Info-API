<?php
/**
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:700|Bitter:400,700' rel='stylesheet' type='text/css'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/twentytwelve-child/js/respond.min.js" type="text/javascript"></script>
<!--[if lte IE 7]><script src="js/lte-ie7.js"></script><![endif]-->

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed">
	<header id="masthead" class="site-header" role="banner">
		<div class="header-wrapper">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<div class="hgroup">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<h2 class="site-description">A .. member of the <img src="<?php bloginfo('wpurl'); ?>/wp-content/themes/twentytwelve-child/images/seton-logo.png" height="18" width="18" alt="Seton Healthcare Family Logo"> Seton Healthcare Family</h2>
				</div>
			</a>

			<div id="info-nav">
				<ul id="hover-icons">
					<li><div class="search-icon" aria-hidden="true" data-icon="&#xe007;"></div></li>
					<li><div class="map-icon" aria-hidden="true" data-icon="&#xe008;"></div></li>
					<li><div class="phone-icon" aria-hidden="true" data-icon="&#xe009;"></div></li>
				</ul>
				<div id="info-popup">
					<ul>
						<li>
							<h4 class="title-text aqua-text">FIND US</h4>
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
								                $initJavascript .= "map = new google.maps.Map(document.getElementById(\"map_canvas2\"), myOptions);\n";
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
						
										<div id="map_canvas2"></div>
										
							            <script type="text/javascript">
							           
									    <?php echo $initJavascript; ?>

										          
							            </script>	
							        </div>
								</div>		


										
			    <!--////////////////////////////////End of google map/////////////////////////////-->
						</li>
						<li>
							<h4 class="title-text aqua-text">LOCATION</h4>
							<p>1400 N. IH-35, Suite C2-450<br />Austin, TX 78701</p>
							<h4 class="title-text aqua-text">CALL</h4>
							<p><div class="phone-icon" aria-hidden="true" data-icon="&#xe009;"></div>(512)324-7468 | FAX: (512)324-7469</p>
							<h4 class="title-text aqua-text">SEARCH</h4>
							<div class="search_area search-location cf">
								<?php get_search_form( $echo ); ?>
							</div>
						</li>
					</ul>
				</div>
			</div>

			<nav id="site-navigation" class="main-navigation" role="navigation">
				<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
				<a id="info-toggle" onclick="popout('info-mobile')"><div class="search-icon" aria-hidden="true" data-icon="&#xe007;"></div><div class="map-icon" aria-hidden="true" data-icon="&#xe008;"></div><div class="phone-icon" aria-hidden="true" data-icon="&#xe009;"></div></a>
				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
				<ul id="info-mobile" style="display:none;">
					<li class="phone"><a href="tel:15129254932"><div class="phone-icon" aria-hidden="true" data-icon="&#xe009;"></div>512.925.4932</a></li>
					<li class="map"><a href="/location/"><div class="map-icon" aria-hidden="true" data-icon="&#xe008;"></div>FIND US</a></li>
					<li class="search_area search-location cf">
						<?php get_search_form( $echo ); ?>
					</li>
				</ul>
			</nav><!-- #site-navigation -->

<script>
    function popout(id) {
       var e = document.getElementById(id);
       if(e.style.display == '')
          e.style.display = 'none';
       else
          e.style.display = '';
    }

$('nav#site-navigation > div.nav-menu > ul > li').first().addClass('first');
</script>

			<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /></a>
			<?php endif; ?>
		</div>
	</header><!-- #masthead -->