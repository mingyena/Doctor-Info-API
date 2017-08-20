<?php 

/*
Template Name: Research Staff
*/

get_header(); ?>
    <div class="wrapper cf">
        <section id="content" class="cf" role="main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="header cf">
					<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Top Right Links')) : ?><?php endif; ?>
                    <h1 class="entry-title">
						<?php if($post->post_parent) {
                            $ancestors = get_post_ancestors($post->ID);
                            $root = count($ancestors)-1;
                            $parent = $ancestors[$root];
                            $parent_title = get_the_title($parent); ?>
                            <a href="<?php echo get_permalink($parent) ?>" class="breadcrumb"><?php echo $parent_title;?></a>
                        <?php } ?>
						<?php the_title(); ?>
					</h1>
                </header>
                <div class="with-sidebar">
                    <section class="entry-content">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
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
					$url= ("http://www.setonfamilyofdoctors.com/api/PhysicianSearch.aspx?AuthCode=".$practiceURLTemp."&PhysicianName=&PracticeID=".$practiceID."&ShowNonPhysicians=true" );
					$url=str_replace(" ","%20",$url);
					$strings= file_get_contents($url);  
					$json=json_decode($strings, true);
				
         					
					//For each name
					$doctorString="";
					$providerString="";
					foreach($json as $key=>$val)
					{  $DaFullName=$val['PhysicianName'];
					  // $DaFullName = str_replace (".","'.'",$DaFullName);
					    $EachProfileURL = ("http://www.setonfamilyofdoctors.com/api/PhysicianByName.aspx?AuthCode=2a5de188-4abc-4c26-87a2-bbdc5c847382&PhysicianName=".$DaFullName);
					   $EachProfileURL=str_replace(" ","%20",$EachProfileURL);
					   $profileString= file_get_contents($EachProfileURL);
					   $EachProfile = json_decode($profileString, true);
					  if($EachProfile["IsResearchPhysician"]){
					   $Name= $EachProfile["ImageLink"];
					   $FullName=str_replace ("-"," ",$DaFullName);		   
					   $linkName=str_replace(' ', '-', $DaFullName);
					   $linkName=str_replace(". ",".",$DaFullName);
					  // echo "link name: ".$linkName;
					   if(strlen($EachProfile["Specialties"])>0) {
					   $doctorString.= "<div class='doctor_thumb'>";
					  
					   $doctorString.= "<img src='".(image()).$Name."'/>";
					   
					   $doctorString.= "<a href='/seton-heart-institute/our-team/doctor-profile/".($linkName). "'>". $FullName ."</a><br/>";
					   $doctorString.= ($val['PhysicianSpecialties']) ."<br/>";
   					   $doctorString.= "</div>";
						}
					  else{
					      $providerString.= "<div class='doctor_thumb research'>";
					   $providerString.= "<img src='".(image()).$Name."'/>";
					    $providerString.= "<a href='/seton-heart-institute/our-team/doctor-profile/".($linkName). "'>". $FullName ."</a><br/>";
					   $providerString.= ($val['PhysicianSpecialties']) ."<br/>";
   					   $providerString.= "</div>";
					  }
					  }
					}
					echo "<div class='doctor_research'>$doctorString</div>";
					
					echo "<div class='provider_research'>$providerString</div>";?>
					<div style="clear:both"></div>
									
		</div>
                        <div class="entry-links"><?php wp_link_pages(); ?></div>
                    </section>
                </div>
                <?php get_sidebar(); ?>
            </article>
            <?php endwhile; endif; ?>
        </section>
    </div>
<?php get_footer(); ?>