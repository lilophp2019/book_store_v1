
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

           

            <div>

                <form class="form-horizontal" action="busca.php" method="post"  class="form-group" enctype="multipart/form-data">
                   
                    <!-- Form Name -->
                    <legend style="margin-top:2em;">BOOK_STORE</legend>

                    <!-- Button For Search -->
                   
            
                    <div>

                        <input type="button" value="Back" class="Redirect" id="btnBack" 
                            onClick="document.location.href='../import_csv/index.php'" />

                    </div>

                    

                    <div class="col-lg-25" style="margin-top:2em;">

                        <label class="col-md-2 control-label" for="type_book">Tipo de Livro: </label>
                        
                        <div class="col-md-4">
                            <input class="form-control" id="type_book" placeholder="Tipo de Livro" name="type_book">
                        </div>

                        <button type="submit" class="btn btn-primary">Buscar</button>

                    </div>

                </form>

            </div>

            <div class="wrap" style="margin-top:2em;">

                <?php

                    include 'db_connection.php';       
                    $conn = OpenCon();

                    global $total;
                    global $total_geral;
                    global $total_arredondado;

                    $type_book = $_POST['type_book'];

                    if($type_book == "")
                    {
                        $type_book = 'Olá';
                        
                    }
                    else
                    {
                  
                        $Sql = "SELECT * FROM bookstore_v1.tb_livro where locate('$type_book',type_book)>0 order by type_book asc";
                        $result = mysqli_query($conn, $Sql) or die(mysqli_error($conn));  
                        
                        // Verifica se o SQL retornou algum registro
                        if (mysqli_num_rows($result) > 0)
                        {
                            
                            echo "<div class='table-responsive'>
                                    <table id='myTable' class='table table-striped table-bordered'>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>ISBN</th>
                                                <th>TITLE</th>
                                                <th>TYPE</th>
                                                <th>PRICE</th>
                                                <th>AUTHORS</th>
                                            </tr>
                                        </thead>
                                    <tbody>";

                            while($row = mysqli_fetch_assoc($result)) 
                            {
                                    
                                echo "<tr>
                                    <td>" . $row['pk_livro']."</td>
                                    <td>" . $row['isbn']."</td>
                                    <td>" . $row['title']."</td>
                                    <td>" . $row['type_book']."</td>
                                    <td> € " .round( $row['price'], 2 ) ."</td>
                                    <td>" . $row['authors']."</td>
                                </tr>"; 

                                $total_geral += $row['price'];

                                switch( $row['type_book'] ){
                                    case 'UsedBook':
                                        $total += $row['price'] - ( $row['price'] * (25/100) ); 
                                        break;
                                    case 'NewBook':
                                        $total += $row['price'] - ( $row['price'] * (10/100) ); 
                                        break;
                                    case 'ExclusiveBook':
                                        $total += $row['price']; 
                                        break;
                                    default:
                                        echo "Não foi possível aplicar o desconto";
                                        break;
                                }
                                //$total += $row['price']; 

                            }
                            
                            $total_arredondado = round($total, 2);

                            echo "<tr> <td></td> <td> </td>

                                    <td> <h4>Total Rounded </h4> </td>
                                    <td><h4> € $total_arredondado <h4> </td>
                                    
                                    <td> <h4> Grand Total </h4> </td>
                                    <td> <h4> € $total_geral</h4> </td>
                                    
                                </tr>";                                            

                            echo "</tbody></table></div>";

                            //echo round($total, 2);

                        } 
                        else 
                        {
                            echo "you have no records";
                        }

                        CloseCon($conn);
                        return $total_geral;

                    }


                ?>
            </div>

        </div>

    </div>
