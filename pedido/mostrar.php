<?php
$nombreArchivo="P-".$fila["codigo"];
$directorio = "media/";
//lista de todas las extenciones posibles
$extensiones =["jpg", "jpeg", "png", "gif"];
//bandera para verificar todo tipo de archivo
$archivoEncontrado = null;
//verificar si el archivo se creo en alguna extension conocida
foreach ($extensiones as $ext) {
//nombre del archivo con cada extension
$ruta = $directorio . $nombreArchivo .".". $ext;
//verifica
if (file_exists($ruta)) {
$archivoEncontrado = $ruta;
//detenemos la búsqueda en cuanto lo encuentra
break;
}
}
//verifica si encontró algun archivo con el nombre
if ($archivoEncontrado) {
$extension = strtolower(pathinfo($archivoEncontrado, PATHINFO_EXTENSION));
// Mostrar según el tipo
echo "<td><img src='".$archivoEncontrado."' width=250></td>";
}else{
echo "<td>No imagen</td>";
}
?>