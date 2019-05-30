<?php include "functions.php";?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
         
    </head>

    <body>

        <div id="wrap">

            <div class="container">

                <div class="row">

                    <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                        
                        <fieldset>
                            
                            <!-- Form Name -->
                            <legend style="margin-top:2em;">BOOK_STORE</legend>
                       

                            <!-- Button For Search -->
                            <form class="form-horizontal" action="busca.php" method="post" name="Search" enctype="multipart/form-data">
                    
                                <div>

                                    <input type="button" value="Search" class="Redirect" id="btnSearch" 
                                        onClick="document.location.href='../import_csv/busca.php'" />

                                </div>

                            </form>


                            <!-- File Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="filebutton">Select File</label>
                                <div class="col-md-4">
                                    <input type="file" name="file" id="file" class="input-large">
                                </div>
                            </div>


                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                                <div class="col-md-4">
                                    <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import CSV</button>
                                </div>
                            </div>

                        </fieldset>

                    </form>

                </div>

                <!-- Results -->
                <?php
                    
                    get_all_records( $conn );

                ?>
              
            </div>

        </div>


        <div>

            <form class="form-horizontal" action="functions.php" method="post" name="upload_excel"   
                        enctype="multipart/form-data">
                    
                <div class="form-group">

                    <div class="col-md-4 col-md-offset-4">

                        <input type="submit" name="Export" class="btn btn-success" value="Export To Txt"/>
                        
                    </div>

                </div>      

            </form>   

        </div>

    </body>

</html>

