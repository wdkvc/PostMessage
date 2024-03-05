<!-- Chapter 6 exercise -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Message Board</title>
</head>
<body>
	<h1>Message Board</h1>
	<?php 

		if(isset($_GET["action"])) {
			if(file_exists("message.txt") === true && filesize("message.txt") != 0) {
			$MessageArray = file("message.txt");
			 // switch statement to determine which hyperlink was clicked on
			  switch($_GET["action"]) {
				case "Delete First":
					array_shift($MessageArray);
					break;
				case "Delete Last":
				    array_pop($MessageArray);
					break;

				case "Delete Message":
					if(isset($_GET["message"])) {
						array_splice($MessageArray, $_GET["message"], 1);
					} 
					break;
				case "Remove Duplicates":
					$MessageArray = array_unique($MessageArray);
					$MessageArray = array_values($MessageArray);
					break;

				case "Sort Ascending":
					sort($MessageArray);
					break;

				case "Sort Descending":
					rsort($MessageArray);
					break; 
			  }	// end of switch statement

			  // this is for when all messages have been deleted
			  if(count($MessageArray) > 0) {
				$NewMessages = implode($MessageArray);
				$MessageStore = fopen("message.txt", "w");
				if($MessageStore === false) {
					echo "<p>Sorry! There was an error updating the message file!</p>";
				} else {
					fwrite($MessageStore, $NewMessages);
					fclose($MessageStore);
				} // end of file data IF/ELSE statement
			  } else {
				  // we are here because $MessageArray is empty
				  unlink("message.txt");
			  } // end of IF/ELSE statement

			} // end of file checking IF statement
		} // end of initial IF statement

		if((!file_exists("message.txt")) || (filesize("message.txt") === 0)) {
			echo "<p>There are no messages posted!</p>";
		} else {
			$MessageArray = file("message.txt");
			echo "<table style='background-color: lightgray;' border='1' width='100%'>\n ";
			$count = count($MessageArray);
			// loop through the $MessageArray variable, each message is 1 row in the table
			for($i = 0; $i < $count; ++$i) {
				$CurrMsg = explode("~", $MessageArray[$i]);
				echo "<tr>\n";
				echo "<th width='5%'>", ($i + 1), "</th>\n";
				echo "<td width='85%'><span style='font-weight: bold'>Subject:</span> ", htmlentities($CurrMsg[0]), "<br/>\n";
				echo "<span style='font-weight: bold'>Name:</span> ", htmlentities($CurrMsg[1]), "<br/>\n";
				echo "<span style='font-weight: bold; text-decoration: underline;'>Message:</span> ", htmlentities($CurrMsg[2]), "</td>\n";
				echo "<td width='10%' style='text-align: center;'><a href='MessageBoard.php?action=Delete%20Message&message=$i'>Delete This Message</a></td>\n";
				echo "</tr>\n";
			} // end of FOR loop
			echo "</table>\n";

		} // end of IF/ELSE
	?>
	<p><a href="PostMessage.php">Post New Message</a></p>
	<p><a href="MessageBoard.php?action=Sort%20Ascending">Sort Subjects A-Z</a></p>
	<p><a href="MessageBoard.php?action=Sort%20Descending">Sort Subjects Z-A</a></p>
	<p><a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicate Messages</a></p> 
	<p><a href="MessageBoard.php?action=Delete%20First">Delete First Message</a></p>
	<p><a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a></p>
</body>
</html>