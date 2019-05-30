<?php
       
    include 'db_connection.php';       
    $conn = OpenCon();


    if(isset($_POST["Import"]))
    {
        
        $filename = $_FILES["file"]["tmp_name"]; 

        if($_FILES["file"]["size"] > 0)
        {

            $file = fopen($filename, "r");
            $flag = true;

            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                if($flag) { $flag = false; continue; }
                $sql = "INSERT into bookstore_v1.tb_livro (pk_livro,isbn,title,type_book,price,authors) 
                values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."')";
                
                $result = mysqli_query($conn, $sql);
                
                if(!isset($result))
                {
                    echo "<script type=\"text/javascript\">
                        alert(\"Invalid File:Please Upload CSV File.\");
                        window.location = \"index.php\"
                        </script>";    
                }
                else 
                {
                    echo "<script type=\"text/javascript\">
                    alert(\"CSV File has been successfully Imported.\");
                    window.location = \"index.php\"
                    </script>";
                }

            }
        
            fclose($file); 
            CloseCon($conn);

        }

    } 
    
     
    function get_all_records($conn)
    {
        global $total;
        global $total_geral;
        global $total_arredondado;
        $Sql = "SELECT * FROM bookstore_v1.tb_livro";
        $result = mysqli_query($conn, $Sql);  
        
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

        return $total_geral;

    }

    if(isset($_POST["Export"]))
    {

        header('Content-type: text/plain');
        header('Content-Disposition: attachment; filename=agostassi.txt');
         
        $output = fopen("php://output", "w") or die ("Can´t open this file");  
        
        fputcsv( $output, array('ID', 'ISBN', 'TITLE', 'TYPE', 'PRICE', 'AUTHORS') ); echo "\r\n"; 
        $query = "SELECT * from bookstore_v1.tb_livro ORDER BY pk_livro ASC";  
        $result = mysqli_query($conn, $query);  

        while($row = mysqli_fetch_assoc($result))  
        {  
           
            fputcsv($output, $row ); 
            echo "\r\n";

        }  

        fclose($output);  
        CloseCon($conn);

    }  

?>