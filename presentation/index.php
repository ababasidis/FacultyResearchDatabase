<?php
	require_once("DB.class.php");
?>

<!doctype html>
<html>
<head>
	<?php include "includes/head.inc"; ?>
</head>
<body>  
	<?php include "includes/nav.php"; ?>
	<div class="container">
		<?php
			include "includes/papers-search.inc"; 

			if (isset($_POST['searched'])){
				$searchPhrase = $_POST['searchPhrase'];
				$searchField = $_POST['searchField'];
				
				$searchResults = array();
				if($searchField == "allFields"){

					$searchResults = array();
					$searchResults = $db->getPapersAllFields($searchPhrase);
					//var_dump($searchResults);
				}
				else{
					$searchResults = $db->getPapersOneFields($searchPhrase, $searchField);
					
				}
				foreach($searchResults as $row){
					$ID = $row['ID'];
					$title = $row['title'];
					$abstract = $row['abstract'];
					$citation = $row['citation'];

							$htmlString = '
								<div class="paper-container">
									<form action="paper.php" method="post" name="papersFound">
										<input type="hidden" name="paperID" value="'.$ID.'">

										<h4>'.$title.'</h4>
											<p>'.substr($abstract, 0, 80).'...</p>
										<input type="submit" class="btn comment-btn" name="submitPaperIndividualView" value="View Paper">
									</form>
								</div>';
						echo $htmlString;
				}
			}
		

		?>

		</div>

	</div>

	</div>
	<?php include "includes/footer.inc"; ?>
</body>
</html>