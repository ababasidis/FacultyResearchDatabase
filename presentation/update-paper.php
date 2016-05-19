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
		//check to see if a paper should be updated
		if(isset($_POST['updatePaper'])){
			$paperInfo = array();
			//get current paper information
			$paperInfo = $db->getPaper($_POST['paperID']);

			foreach($paperInfo as $row){
				$ID = $row['ID'];
				$title = $row['title'];
				$citation = $row['citation'];
				$abstract = $row['abstract'];

			}
		 	

			
		}

		

		echo '<div class="row">
			<div class="col-sm-12">
				<h3>Update Paper</h3>
				<form method="post" name="updatePaper" action="profile.php">
					<label>Title</label>
					<input class="input-bar" type="text" name="updatePaperTitle" value='.$title.'>
					<label>Abstract</label>
					<textarea class="input-bar" rows="8" name="updatePaperAbstract" value='.$abstract.'></textarea>
					<label>Citation</label>
					<input class="input-bar" type="text" name="updatePaperCitation" value='.$citation.'>
					<label>Add Keywords (optional)</label>
					<input class="input-bar" type="text" name="updatePaperKeyword">
					<input class="btn comment-btn" type="submit" value="Save Changes" name="updateCurrPaper">
				</form>
			</div>
		</div>
	</div>';


	include "includes/footer.inc"; ?>
</body>
</html>
