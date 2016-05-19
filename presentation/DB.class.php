<?php
	class DB{
		//connection object
		private $connection;
		//Default constructor
		function __construct(){
			require_once("../../dbInfo.php");
			$this->connection = new mysqli($host, $user, $pass, $db);
			if($this->connection->connect_error){
				echo "Connection failed".mysqli_connect_error();
				die();
			}	
		}//end of default constructor


		/*
		* All papers that contain the search phrase - use when searching all fields
		* @param searchString
		*/
		function getPapersAllFields($searchString){
			$data = Array();
			if($stmt = $this->connection->prepare("select ID, title, abstract, citation from papers WHERE title LIKE '%".$searchString."%' OR abstract LIKE '%".$searchString."%' OR citation LIKE '%".$searchString."%';")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($ID, $title, $abstract, $citation);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'ID'=>$ID,
				 			'title'=>$title,
				 			'abstract'=>$abstract,
				 			'citation'=>$citation
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getPapersAllFields


		/*
		* All papers that contain the search phrase - search a specified field only
		* @param searchString
		* @param searchField
		*/
		function getPapersOneFields($searchString, $searchField){
			$data = Array();
			$statement = "select ID, title, abstract, citation from papers WHERE ".$searchField." LIKE '%".$searchString."%';";
			if($stmt = $this->connection->prepare($statement)){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($ID, $title, $abstract, $citation);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'ID'=>$ID,
				 			'title'=>$title,
				 			'abstract'=>$abstract,
				 			'citation'=>$citation
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getPapersOneFields


		/*
		* Get paper based off a paperID
		* @param paperID
		*/
		function getPaper($paperID){
			$data = Array();
			if($stmt = $this->connection->prepare("select ID, title, abstract, citation from papers WHERE ID = '".$paperID."';")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($ID, $title, $abstract, $citation);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'ID'=>$ID,
				 			'title'=>$title,
				 			'abstract'=>$abstract,
				 			'citation'=>$citation
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getPaper



		/*
		* All comments attached to a specific paperId
		* @param currentPaperID
		*/
		function getComments($currentPaperID){
			$data = Array();
			if($stmt = $this->connection->prepare("select commentID, userID, paperID, aComment from comments WHERE paperID = ".$currentPaperId.";")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($commentID, $userID, $paperID, $aComment);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'commentID'=>$commentID,
				 			'userID'=>$userID,
				 			'paperID'=>$paperID,
				 			'aComment'=>$aComment
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getComments


		/*
		* Show subscribe status and count subscribing users
		* @param currentPaperID
		*/
		function getSubscribeData($currentPaperID){
			$data = Array();
			if($stmt = $this->connection->prepare("select count(userID), userID, subscription from paper_users WHERE paperID = ".$currentPaperID.";")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($subscribeCount, $userID, $subscription);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'subscribeCount'=>$subscribeCount,
				 			'userID'=>$userID,
				 			'subscription'=>$subscription
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getSubscribeData


		/*
		* Get users information using their userID
		* @param currentUserID
		*/
		function getUserInformation($email,$password){
			$data = Array();
			if($stmt = $this->connection->prepare("select ID, fname, lname, password, email, role from users where email like '".$email."' and password like '".md5($password)."';")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($ID, $fname, $lname, $password, $email, $role);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data = array(
				 			'ID'=>$ID,
				 			'fname'=>$fname,
				 			'lname'=>$lname,
				 			'password'=>$password,
				 			'email'=>$email,
				 			'role'=>$role
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getUserInformation




		/*
		* Get users information using their ID 
		* @param ID
		*/
		function getSomeUserInformation($ID){
			$data = Array();
			if($stmt = $this->connection->prepare("select ID, fName, lName from users where ID='".$ID."';")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($ID, $fname, $lname);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'ID'=>$ID,
				 			'fname'=>$fname,
				 			'lname'=>$lname
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getSomeUserInformation



		/*
		* All keywords associated to the current paper
		* @param currentPaperID
		*/
		function getKeywordsOnePaper($currentPaperID){
			$data = Array();
			if($stmt = $this->connection->prepare("select paperID, keyword from paper_keywords WHERE paperID = ".$currentPaperID."; ")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($paperID, $keyword);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'paperID'=>$paperID,
				 			'keyword'=>$keyword
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getKeywordsOnePaper

		/*
		* All keywords
		*/
		function getAllKeywords(){
			$data = Array();
			if($stmt = $this->connection->prepare("select paperID, keyword from paper_keywords;")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($paperID, $keyword);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'paperID'=>$paperID,
				 			'keyword'=>$keyword
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getAllKeywords

		/*
		* Get userID given a paperID - where the userID is an author
		*/
		function getPaper_Users($paperID){
			$data = Array();
			if($stmt = $this->connection->prepare("select userID, paperID, subscription, author from paper_users where paperID = '".$paperID."' AND author;")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($userID, $paperID, $subscription, $author);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'userID'=>$userID,
				 			'paperID'=>$paperID,
				 			'subscription'=>$subscription,
				 			'author'=>$author
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getPaper_Users



		/*
		* Using the userID get the paperIDs that they authored
		*/
		function getAuthorPaper_Users($userID){
			$data = Array();
			if($stmt = $this->connection->prepare("select userID, paperID, subscription, author from paper_users WHERE userID='".$userID."' AND author = 1")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($userID, $paperID, $subscription, $author);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'userID'=>$userID,
				 			'paperID'=>$paperID,
				 			'subscription'=>$subscription,
				 			'author'=>$author
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getAuthorPaper_Users



		/*
		* Using the userID get the paperIDs that they are subscribed to
		*/
		function getSubscribedPaper_Users($userID){
			$data = Array();
			if($stmt = $this->connection->prepare("select userID, paperID, subscription, author from paper_users WHERE userID='".$userID."' AND subscription = 1")){
				 $stmt->execute();
				 $stmt->store_result();
				 $stmt->bind_result($userID, $paperID, $subscription, $author);
				 if($stmt->num_rows > 0){
				 	while($stmt->fetch()){
				 		$data[] = array(
				 			'userID'=>$userID,
				 			'paperID'=>$paperID,
				 			'subscription'=>$subscription,
				 			'author'=>$author
				 		);
				 	}
				 }
			}
			return $data;
		}//end of getSubscribedPaper_Users






		/*
		* Update a paper - pass in an associative array with the field name and the value for that field
		* @param field and value
		*/
		function updatePaper($fields){
			$queryString = "update papers set ";
			$insertID = 0;
			$numRows = 0;
			foreach($fields as $k=>$v){
				switch($k){
					case "ID":
						$insertID = intval($v);
						break;
					case "title":
						$queryString .= "title = '$v', ";
						break;
					case "abstract":
						$queryString .= "abstract = '$v', ";
						break;
					case "citation":
						$queryString .= "citation = $v, ";
						break;
				}//end of switch
			}//end of foreach
			$queryString = trim($queryString," ,");
			$queryString .= " where ID = ?";

			if($stmt = $this->connection->prepare($queryString)){
				$stmt->bind_param("i",$insertID);
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}//end of if
			return $numRows;
		}//end of updatePaper



		/*
		* Update subscription or author status - pass in a associative array with the field name and the value for that field
		* @param field and value
		*/
		function updateSubscribeAuthorStatus($fields){
			$queryString = "update paper_users set ";
			$insertID = 0;
			$numRows = 0;
			foreach($fields as $k=>$v){
				switch($k){
					case "userID":
						$insertID = intval($v);
						break;
					case "paperID":
						$queryString .= "paperID = '$v', ";
						break;
					case "subscription":
						$queryString .= "subscription = '$v', ";
						break;
					case "author":
						$queryString .= "author = $v, ";
						break;
				}//end of switch
			}//end of foreach
			$queryString = trim($queryString," ,");
			$queryString .= " where userID = ?";

			if($stmt = $this->connection->prepare($queryString)){
				$stmt->bind_param("i",$insertID);
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}//end of if
			return $numRows;
		}//end of updateSubscribeAuthorStatus




		/*
		* Insert a comment tied to a user and a paper
		* @param userID
		* @param paperID
		* @param aComment
		*/
		function insertComment($userID, $paperID, $aComment){
			$queryString = "insert into comments (userID, paperID, aComment) values(?,?,?)"; 
			$insertID = "-1";
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->bind_param("iis", $userID, $paperID, $aComment);
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
				$insertID = $stmt->insert_id;
			}
			return $insertID;
			
		}//end of insertComment


		/*
		* Add a new paper
		* @param title
		* @param abstract
		* @param citation
		*/
		function insertPaper($title, $abstract, $citation){
			$queryString = "insert into papers (title, abstract, citation) values(?,?,?)"; 
			$insertID = "-1";
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->bind_param("sss", $title, $abstract, $citation);
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
				$insertID = $stmt->insert_id;
			}
			return $insertID;
			
		}//end of insertPaper


		/*
		* Delete a paper using the currentPaperID
		* @param currentPaperID
		*/
		function deletePaper($currentPaperID){
			$queryString = "delete from papers where ID = ".$currentPaperID.";";
			$numRows = 0;
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}	
			return $numRows;
		}//end of deletePaper

		/*
		* Delete from paper_users using the currentPaperID
		* @param currentPaperID
		*/
		function deletePaper_users($currentPaperID){
			$queryString = "delete from paper_users where paperID = ".$currentPaperID.";";
			$numRows = 0;
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}	
			return $numRows;
		}//end of deletePaper_users

		/*
		* Delete from paper_keywords using the currentPaperID
		* @param currentPaperID
		*/
		function deletePaper_keywords($currentPaperID){
			$queryString = "delete from paper_keywords where ID = ".$currentPaperID.";";
			$numRows = 0;
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}	
			return $numRows;
		}//end of deletePaper_keywords

		/*
		* Delete from comment using the currentPaperID
		* @param currentPaperID
		*/
		function deleteCommentsForPaper($currentPaperID){
			$queryString = "delete from comments where paperID = ".$currentPaperID.";";
			$numRows = 0;
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}	
			return $numRows;
		}//end of deleteCommentsForPaper

		/*
		* Delete a comment using the currentCommentID
		* @param currentCommentID
		*/
		function deleteComment($currentCommentID){
			$queryString = "delete from comments where commentID = ".$currentCommentID.";";
			$numRows = 0;
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
			}	
			return $numRows;
		}//end of deleteComment



		/*
		* add a record in paper_users
		* @param paperID
		* @param userID
		* @param subscription
		* @param author
		*/
		function insertPaper_Users($paperID, $userID, $subscription, $author){
			$queryString = "insert into paper_users (userID, paperID, subscription, author) values(?,?,?,?)"; 
			$insertID = "-1";
			if($stmt = $this->connection->prepare($queryString)){
				$stmt->bind_param("iiii", $userID, $paperID, $subscription, $author);
				$stmt->execute();
				$stmt->store_result();
				$numRows = $stmt->affected_rows;
				$insertID = $stmt->insert_id;
			}
			return $insertID;
			
		}//end of insertPaper_Users






}//end of DB class
?>