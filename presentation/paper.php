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
		<a href="index.php">< View All Papers</a>
	<?php


		$paperInfo = array();
		$paperInfo = $db->getPaper($_POST['paperID']);
		
		$authorInfo = array();
		$authorInfo = $db->getPaper_Users($_POST['paperID']);
		
		
		$authorString = "";
		foreach($authorInfo as $row){
			$authorID = $row['userID'];
			

			//gather author name based on their ID
			$authorName = array();
			$authorName = $db->getSomeUserInformation($authorID);
			//get authors name and add to the author string
			foreach($authorName as $row){
				$authorString .= $row['lname'].', '.$row['fname'].'; ';
			}


		}
		foreach($paperInfo as $row){

			$title = $row['title'];
			$citation = $row['citation'];
			$abstract = $row['abstract'];



			$htmlString = 
				'<div class="row">
					<div class="col-sm-8 paper-content">
						<form action="paper.php" method="post" name="paperBody">
							<h2>'.$title.'</h2>
								<h4>Author(s): '.$authorString.'</h4>

								<p>'.$abstract.'</p>

								<p>'.$citation.'</p>
			
						</form>


			<hr/>';
	}

					

				echo $htmlString;
 
 ?>
</div>
	</div>


	</div>
	<?php include "includes/footer.inc"; ?>
</body>
</html>
