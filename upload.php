<?php
$page_title = 'DataCast - Upload';
include('includes/header.php');
echo '
<div class = "centerbox">
    <div class = "centered">';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require('../connect_db.php');
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    # check if file already exists
    if (file_exists($target_file)) {
        echo "<p>Error: upload directory contains file of the same name</p>";
        $uploadOk = 0;
    }
    # allow certain file formats
    if($fileType != "sql") {
        echo "<p>Sorry, only SQL files allowed.</p>";
        $uploadOk = 0;
    }
    # check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p>Your file was not uploaded.<p>";
    # if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p>The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.</p>";
            # this next segment of code removes comments and semicolons in the users .sql file and 
            # runs the sql file against the database.
            echo basename( $_FILES["fileToUpload"]["name"]);
            
            $q = 'USE _' . $_GET["db"];
 
            $r = mysqli_query($dbc,$q) or die(mysqli_error($dbc));
            # temporary variable, used to store current query
            $templine = '';
            # read in entire file
            $lines = file($target_file);
            # loop through each line
            foreach ($lines as $line){
                # skip it if it's a comment
                if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                # add this line to the current segment
                $templine .= $line;
                # if it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';')
                {
                    # perform the query
                    mysqli_query($dbc,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($dbc) . '<br /><br />');
                    # reset temp variable to empty
                    $templine = '';
                }
            }
            echo "<p>Tables imported successfully</p>";
            #finally, delete the file
            unlink($target_file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
        <form action = <?php echo '"upload.php?db=' . $_GET["db"] . '"';?> method="POST" enctype="multipart/form-data">
            Select sql file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Submit to Database" name="submit">
        </form>
    </div>
</div>