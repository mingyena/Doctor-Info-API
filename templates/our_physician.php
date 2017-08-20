<?php
/*
Template Name: physician-profile
*/
?>



<?php get_header() ?>
	<div class="page-wrapper border-rt">
		<div id="primary" class="site-content">
			<?php the_post() ?>
			<div id="content" role="main">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="entry-content">
								
				<?php	
                //echo (get_query_var('lastName'));  
                 if(isset($wp_query->query_vars['lastName'])) {
                 $lastName=(urldecode($wp_query->query_vars['lastName']));}
				 
			 
				 
				//if (strlen(urldecode($wp_query->query_vars['lastName']))>0 )
				if(true)
				{
				 
                  
					$LastName = "Matthew-Fox";//urldecode($wp_query->query_vars['lastName']);
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
			
					<div id="physician-photo">					
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
					
				<div id="physician-bio"> 
					<?php 
					    echo "<h1>".$json["FirstName"]."&nbsp".$json["LastName"].$credentials."</h1>";
						//echo "<h3>Specialties</h3>";
						//echo $json["Specialties"]."<br/>"; 
						//echo "<h3>Bio</h3>";						
						echo $json["Biography"];
						
						if (!isset($json["AdditionalInfo"])||!empty($json["AdditionalInfo"]))
						 {	//$imageSource=str_replace("..","",($json["$AdditionalInfo"]));						 	
							echo $json["AdditionalInfo"];
						    //echo "<img src=".$imageSource."/>";
						 }//echo "<br class='clearAll'>";
					?>	
				</div>
		  		<div class="cf"></div>
				</div><!-- .entry-content -->
			</article><!-- #post -->
			</div><!-- #content -->
		</div><!-- #primary -->

	<?php get_sidebar(); ?>

	</div><!-- #container -->


<?php get_footer() ?>
<?php
function physicianChecker($phyInfo){
  if ((isset($phyInfo))||empty($phyInfo))
    {
	  print " ";
	}
  else
      print " ,".$phyInfo;
}}
?>