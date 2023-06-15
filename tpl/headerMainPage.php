<?php
	$output = null;
	$username = $_SESSION["Username"];
	
	$output .= '
				<div class="containerHeader2">
				
					<h3 class="my_h3_header2">Dobrodošel ' . $username . '</h3>
				
				</div>
	
	
	';
	
	echo $output;
?>