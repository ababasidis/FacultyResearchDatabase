<?php
	require_once("DB.class.php");
	$db = new DB();
	
	session_start();
	
	$signedIn = false;
	
	if (isset($_SESSION['loggedIn'])){
		
		$signedIn = true;
		
		if ($_POST['signOut']=="true"){
			
			$_SESSION['loggedIn'] = false;
			$_SESSION = array();
			$signedIn = false;
			
			$_POST['email'] = null;
			$_POST['password'] = null;
		}
	}
	else if ($_POST['email'] && $_POST['password']){
		
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['password'] = $_POST['password'];
		if ($db->getUserInformation($_SESSION['email'],$_SESSION['password']) == true){
			
			$userInfo = $db->getUserInformation($_SESSION['email'],$_SESSION['password']);

			$_SESSION['fname'] = $userInfo['fname'];
			$_SESSION['lname'] = $userInfo['lname'];
			$_SESSION['userID'] = $userInfo['ID'];
			$_SESSION['role'] = $userInfo['role'];

			
			$_SESSION['loggedIn'] = true;
			$signedIn = true;
		}
		else{
			ECHO "<div class='feedback-wrong'>";
			ECHO "EMAIL/PASSWORD NOT RECOGNIZED";
			ECHO "</div>";
		}
	}
	else{
			ECHO "<div class='feedback-wrong'>";
			ECHO "PLEASE ENTER EMAIL/PASSWORD";
			ECHO "</div>";
	}

?>
<nav>
	<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<h1><a href="index.php">Faculty Research Database</a></h1>
		</div>
		<div class="col-sm-4 login-container">
			<div class="row">
			<div id="login">
			<?php
			
			if($signedIn){
				ECHO '<div class="col-xs-9">';
					ECHO "<a href='profile.php' class='profile-name'>{$_SESSION['email']}</a><br/>";
					ECHO 'Not You? ';
					ECHO '<form action = "index.php" method = "POST">';
					ECHO '<input type = "hidden" name="signOut" value = "true"></input>';
					ECHO '<input class="btn comment-btn" type ="submit" value="Sign out."></input>';
					ECHO '</form>';
				ECHO '</div>';
			}
			else{
				ECHO '<div class="col-xs-9">';
					ECHO '<form action = "index.php" method = "POST">';
					ECHO 'email: <input class="login-input" type="text" name="email" placeholder="email"><br>';
					ECHO 'Password: <input class="login-input" type="password" name="password" placeholder="password"><br>';
					ECHO '<input class="btn comment-btn" type="submit" value="Log in">';
					ECHO '</form>';
				ECHO '</div>';
			}
			
			?>
			</div>
				<div class="col-xs-3">
					<img src="img/avatar.jpg" class="img-circle" alt="Avatar" width="50" height="50"> 
				</div>
			</div>
		</div>
	</div>
	</div>
</nav>