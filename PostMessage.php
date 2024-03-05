<!-- Chapter 6 example -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post A Message</title>
</head>
<body>
    <?php 
        // check to see if this page has been loaded based on submitting the form
        if(isset($_POST["submit"])) {
            $Subject = stripslashes($_POST["subject"]);
            $Name = stripslashes($_POST["name"]);
            $Message = stripslashes($_POST["message"]);
            // Replace any '~'
            $Subject = str_replace("~", "-", $Subject);
            $Name = str_replace("~", "-", $Name);
            $Message = str_replace("~", "-", $Message);

            $ExistingSubjects = array();
            // Check that the file both exists AND has at least ine message before continuing
            if((file_exists("message.txt") === true) && (filesize("message.txt") > 0)) {
                $MessageArray = file("message.txt");
                $count = count($MessageArray);
                // loop through each old message, and extract only the subject
                for($i = 0; $i < $count; ++$i){
                    $CurrMsg = explode("~", $MessageArray[$i]);
                    $ExistingSubjects[] = $CurrMsg[0];
                } // end of for loop

            } // end of message check if statement
            
            // check the new subject against the ExistingSubjects array
            if(in_array($Subject, $ExistingSubjects) === true) {
                echo "<p>The subject you entered already exists!<br/>Please enter a new subject and try again.";
                echo "<p>Your message was not saved!</p>";
                $Subject = "";

            } else {
     
            // Combine the three input variables into a single string
            $MessageRecord = "$Subject~$Name~$Message\n";
            $MessageFile = fopen("message.txt", "a");
            // check to see if the file can't be created
            if($MessageFile === false) {
                echo "<p>There was an error saving your message! </p>";
            } else {
                fwrite($MessageFile, $MessageRecord);
                fclose($MessageFile);
                echo "<p>Your message has been saved!</p>";
                $Subject = "";
                $Message = "";
            } // end of IF/ELSE statement

          }// end of duplicate subject IF statement
        } // end of IF statement
        else {
            $Subject = "";
            $Name = "";
            $Message = "";
        }
    ?>

    <h1>
        Post New Message
    </h1>
    <hr/>
    <form action="PostMessage.php" method="post">
        <label style="font-weight: bold;" for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" value="<?php echo $Subject ?>" />
        <label style="font-weight: bold;" for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $Name; ?>"/>
        <br/>
        <br/>
        <textarea name="message" rows="6" cols="80"><?php echo $Message; ?></textarea>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Post Message" />
        <input type="reset" name="reset" value="Reset Form" />
    </form>
    <hr/>
    <p><a href="MessageBoard.php">View Messages</a></p>
</body>
</html>