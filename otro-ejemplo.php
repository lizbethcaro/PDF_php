<?php
//https://programacion.net/articulo/como_crear_archivos_pdf_con_php_1886
//http://www.fpdf.org/
//include_once("../db_connect.php");
$conn = mysqli_connect( "localhost", "root", "", "bd_traductor" );

//este codigo es para hacer el llamado de una sola palabra.
/*$sql  = "SELECT t1.palabra FROM tb_palabras t1
INNER JOIN tb_palabras_idiomas t2 ON t2.id_palabra = t1.id_palabra
INNER JOIN tb_idiomas t3 ON t3.id_idioma = t2.id_idioma
WHERE t1.id_palabra IN 
(
    SELECT tb_traduccion.palabra_2 FROM tb_traduccion WHERE tb_traduccion.palabra_1 IN 
    (
        SELECT t2.palabra_1 FROM tb_palabras t1
        INNER JOIN tb_traduccion t2 ON t2.palabra_2 = t1.id_palabra
        WHERE t1.palabra = 'perro'
    )
)";*/

//este codigo es para llamar la lista en fila de las palabras del traductor
$sql  = " SELECT palabra_1, palabra ";
        $sql .= " FROM tb_traduccion t1, tb_palabras t2 ";
        $sql .= " WHERE t1.id_palabra = t2.id_palabra ";
//---------------------------------------------------------------

$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
while ($field_info = mysqli_fetch_field($resultset)) {
$pdf->Cell(47,12,$field_info->name,1);
}
while($rows = mysqli_fetch_assoc($resultset)) {
$pdf->SetFont('Arial','',12);
$pdf->Ln();
foreach($rows as $column) {
$pdf->Cell(47,12,$column,1);
}
}
$pdf->Output();
?>