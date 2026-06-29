<?php
if($conn->connect_error){
    echo "<div class='mensaje error'>error al conectar a la base de datos</div>";
}
else{
    $CI = $_GET['CI']??null;

    if(!$CI){
        $sql = "SELECT * FROM productos WHERE CI='$CI'";
         if(conn->query($sql)===TRUE){
            echo "<div class='mensaje success'>Producto eliminado con exito</div>";
            else{
                echo "<div class='mensaje error'>error al eliminar:".$conn->error."</div>";
            }
            else{
                echo "<div class='mensaje error'>CI no especificado: " . $conn->error . "</div>";
            }
            }
    }
}
$conn->close();
?>