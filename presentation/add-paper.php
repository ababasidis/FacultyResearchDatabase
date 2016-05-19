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
		<?php include "includes/add-new-paper.inc"; 

		//check if the add paper form has been submitted
		if(isset($_POST['addNewPaper'])){
			//collect data values from form
			$title = $_POST['newPaperTitle'];
			$citation = $_POST['newPaperCitation'];
			$keyword = $_POST['newPaperKeyword'];
			$abstract = $_POST['newPaperAbstract'];
			//insert paper into database
			$addPaperResult = $db->insertPaper($title, $abstract, $citation);
			//paper was added
			if($addPaperResult > -1){
				//update database to represent that adder of the paper is an author
				$getNewPaperID = array();
				$getNewPaperID = $db->getPapersOneFields($title, "title");
				foreach($getNewPaperID as $row){

					//insert new record to tie authorship into the paper_users table
					$insertedID = $db->insertPaper_Users($row['ID'], $_SESSION['userID'], 0, 1);
				}
			}
			else{
				echo "The paper failed to insert";
			}
		}	



		?>
	</div>
	<?php include "includes/footer.inc"; ?>
</body>
</html>
