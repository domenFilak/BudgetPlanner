<?php
	include("menu.php");
	
		
	$output = null;
	
	$output .= '<div class="container pt-4">
    
					<section class="mb-4">';
					
					foreach ($links as $key=>$value) {
						$Link = $value["link"];
						$Title = $value["title"];
			
						if ($Link == basename($_SERVER['SCRIPT_FILENAME'])) {
							$output.= '<a class="my_a" href="' . $Link .'"><strong>' . $Title . '</strong></a>';
						}
						else {
							$output.= '<a class="my_a" href="' . $Link .'">' . $Title . '</a>';
						}
					}
						

					$output .= '</section>
    
				</div>

				<div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);margin:0px 0px 8px 0px;">
						© 2022 FIŠ NM
					
				</div>';
	
	echo $output;
	
?>
     
