<?php
	include("tpl/menu.php");
	$output = null;

	$output .= '<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">BudgetPlanner</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">';
						foreach ($links as $key=>$value) {
							$Link = $value["link"];
							$Title = $value["title"];
							if ($Link == basename($_SERVER['SCRIPT_FILENAME'])) {
								$output.= '	<a class="nav-link" href="'. $Link .'"><strong>'. $Title .'</strong></a>';
							}
							else {
								$output.= '<a class="nav-link" href="'. $Link .'">'. $Title .'</a>';
							}
						}
	$output .= '      </div>
    </div>
  </div>
</nav>';


	echo $output;
?>

        









