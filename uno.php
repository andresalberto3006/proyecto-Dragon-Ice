<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <? php
session_start();
$nombre=$_POST['nonmbre' ];
$celular=$_POST['celular' ];
echo $nombre;
echo $celular;
if($nombre == "Lucas"&& $celular == "123"){
$_SESSION['nombre' ]="Andre Aramayo Torrez";
$_SESSION['edad' ]="13";
header("Location:dos.php");
}else{
header("Location:01.inicio.php");
}
?>
</body>
</html>