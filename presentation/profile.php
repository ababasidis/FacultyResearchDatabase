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
		<div class="row">
			<div class="col-xs-8">
				<h2><?php ECHO "{$_SESSION['fname']} "."{$_SESSION['lname']}"?></h2>
			</div>
			
			<?php
				//gather users role
				$role = $_SESSION['role'];
				//is the user a faculty member
				if($role == 'f'){
					echo '<div class="col-xs-4 right">
							<a href="add-paper.php">Add New Paper <button class="btn-circle">+</button></a>
						</div>';
				}//end of faculty add paper button
			?>

		</div>
	</div>
	<div class="container">
		<div class="row">
				<div class="col-xs-12">
		<?php
			//check is user is faculty then show authorships title
			if($role == 'f'){	
				echo '<h3>My Authorships</h3>';
			}

		//check to see if a paper was deleted and remove from the database
		if(isset($_POST['submitDeletePaper'])){
			$deletePaperID = $_POST['paperID'];
			//delete all connections to the paperID from the paper_users table
			$paper_userDeletedRows = $db->deletePaper_users($deletePaperID);
			if($paper_userDeletedRows > 0){
				//echo "SUCCESS - PAST THE FIRST STEP";
				//delete paper from paper table
				$rowsDeleted = $db->deletePaper($deletePaperID);
				if($rowsDeleted > 0){
					//successfully deleted
					//echo "The paper was deleted";
				}//end of successfully deleting from the paper table
				else{
					//no rows were changed
					//echo "There was an error while deleting the paper";
				}//end of failing to delete from paper table
			}//end of deleting from paper_users successfully
			else{
				//echo "There was an error while deleting the paper";
			}//end of failing to delete from paper_users

			//delete comments associated the the paperID
			$commentDelete = $db->deleteCommentsForPaper($deletePaperID);
			//delete keywords associated to the paperID
			$paper_keywordsDelete = $db->deletePaper_keywords($deletePaperID);
		}



		//current logged in userID and role
		$userID = $_SESSION['userID'];
		$role = $_SESSION['role'];

		if($role == 'f'){	//get authored papers of Faculty only
			$authoredPapers = array();

			//get all papers authored by the logged in user
			$authoredPapers = $db->getAuthorPaper_Users($userID);
			if(count($authoredPapers) > 0){
				foreach($authoredPapers as $rowe){

					$paper = array();
					$paper = $db->getPaper($rowe['paperID']);
					foreach($paper as $row){
						$ID = $row['ID'];
						$title = $row['title'];
						$abstract = $row['abstract'];
						$citation = $row['citation'];
						//display all papers authored by the logged in user
						$htmlString = '
							<div class="authorship-container">
								<form action="paper.php" method="post" name="papersFound">
									<input type="hidden" name="paperID" value="'.$ID.'">
									<h4>'.$title.'</h4>
										<p>'.substr($abstract, 0, 60).'...</p>
									<input type="submit" name="submitPaperIndividualView" class="btn comment-btn" value="View Paper"></br>
								</form>
								<form action="profile.php" method="post" name="deletePaper">
									<input type="hidden" name="paperID" value="'.$ID.'">
									<input type="submit" name="submitDeletePaper" class="btn comment-btn" value="Delete Paper">
								</form>
								<form action="update-paper.php" method="post" name="updatePaper">
									<input type="hidden" name="paperID" value="'.$ID.'">
									<input type="submit" name="updatePaper" class="btn comment-btn" value="Update Paper">
								</form>
							</div>';
					echo $htmlString;
					}//end of foreach

				}//end of foreach
			}//end of if
			else{
				echo 'You are not the author of any papers';
			}
		}



		?>
		</div>
	</div>
</div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h3>My Subscriptions</h3>
		<?php 

		$subscribedPapers = array();
		//get all papers the user is subscribed to
		$subscribedPapers = $db->getSubscribedPaper_Users($userID);
		if(count($subscribedPapers) > 0){
			foreach($subscribedPapers as $rowe){

				$paper = array();
				//get papers based of their paperID
				$paper = $db->getPaper($rowe['paperID']);
				foreach($paper as $row){
					$ID = $row['ID'];
					$title = $row['title'];
					$abstract = $row['abstract'];
					$citation = $row['citation'];
					//display all papers that current user is subscribed to
					$htmlString = '
						<div class="subscription-container">
							<form action="paper.php" method="post" name="papersFound">
								<input type="hidden" name="paperID" value="'.$ID.'">
								<h4>'.$title.'</h4>
									<p>'.substr($abstract, 0, 60).'...</p>
								<input type="submit" name="submitPaperIndividualView" class="btn comment-btn" value="View Paper">
							</form>
						</div>';
				echo $htmlString;
				}//end of foreach

			}//end of foreach
		}//end of if
		else{
			echo '<p>You are not currently subscribed to any Papers</p>';

		}//end of else


		?>

		</div>
	</div>
</div>
	<?php include "includes/footer.inc"; ?>
</body>
</html>
