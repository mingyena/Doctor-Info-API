


In the header.php, please replace meta and title tag like below:

<!--Meta=====================================================-->
<meta name="description" content=<?php
       if (is_page( physician_single_pg()))
	    {
		 {      $tempName= $wp_query->query_vars['lastName'];
				$doctorName=str_replace("-"," ",$tempName);
			    echo ($doctorName)." practices at ".(our_doctors());			    				
		 }
		}
		else
		{
		  bloginfo('name');
		}
      ?>
/>
<!--Title==========================================================-->

<title><?php if (is_page( physician_single_pg()))
               {
			    $tempName= $wp_query->query_vars['lastName'];
				$doctorName=str_replace("-"," ",$tempName);
			    echo ($doctorName);
			    echo " | ".(our_doctors());
				
			   }
			  else
			    {
			    wp_title( '|', true, 'right' );
				}
       ?>
</title>


In the function.php, please add codes like below:
//Rewrite Rules///////////////////////////////////////////////////////////////////////////////////////////

 function add_query_vars($aVars) {
    $aVars[] = 'lastName'; 
    return $aVars;
    }

   // hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rule_and_tag() {

    global $wp_rewrite;

    add_rewrite_rule( '^physician-profile/([^/]*)/?', 'index.php?pagename=physician-profile&lastName=$matches[1]', 'top' );
    add_rewrite_tag( '%lastName%','([^&]+)' );

    if ( ! isset( $wp_rewrite->rules['^physician-profile/([^/]*)/?'] ) )
        $wp_rewrite->flush_rules();

    return;

}