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
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    # allow certain file formats
    if($fileType != "sql") {
        echo "Sorry, only SQL files allowed.";
        $uploadOk = 0;
    }

    # check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    # if everything is ok, try to upload file
    } else {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            # this next segment of code removes comments and semicolons in the users .sql file and 
            # runs the sql file against the database.

            echo basename( $_FILES["fileToUpload"]["name"]);
            
            $q = 'USE _22';
 
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
                    mysqli_query($dbc,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
                    # reset temp variable to empty
                    $templine = '';
                }
            }

            echo "Tables imported successfully";

            #finally, delete the file
            $r = unlink($target_file);
            if($r){
                echo 'file deleted successfully';
            }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            Select sql file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Submit to Database" name="submit">
        </form>
    </div>
</div>