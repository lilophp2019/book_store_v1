
#__________
#First_Way
<?php
$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}
?>


#__________
#Second_Way

<?php

    $filename=mktime().'_'.$_FILES['import']['name'];

    $path='common/csv/'.$filename;

    if(move_uploaded_file($_FILES['import']['tmp_name'],$path))
    {

    if(mysql_query("load data local infile '".$path."' INTO TABLE tbl_customer FIELDS TERMINATED BY ',' enclosed by '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES (`location`, `maildropdate`,`contact_number`,`first_name`,`mname`,`lastname`,`suffix`,`address`,`city`,`state`,`zip`)"))
    {
        
        echo "imported successfully";

    }

    echo "<br>"."Uploaded Successfully".$path;

    }

?>