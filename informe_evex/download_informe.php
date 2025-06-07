<?php
require_once __DIR__ . '/../fpdf/fpdf.php';
include_once __DIR__ . '/../config.php';

// Consulta de datos
$query = "SELECT 
    e.id_evento,
    e.nombre_evento,
    e.descripcion_evento,
    ex.id_exhibicion,
    ex.lugar_exhibicion,
    ex.descripcion_exhibicion
FROM eventos e
JOIN exhibicion_evento ee ON e.id_evento = ee.id_evento
JOIN exhibiciones ex ON ee.id_exhibicion = ex.id_exhibicion";

$res = $conn->query($query);

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('Informe: Eventos con Exhibiciones'), 0, 1, 'C');
        $this->Ln(5);
    }

    function FancyTable($header, $data)
    {
        // Ajusta estos valores para aprovechar mejor el ancho de página
        $w = array(18, 35, 45, 22, 30, 55);
        $this->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 9);
        foreach ($data as $row) {
            // Calcula el alto máximo de la fila
            $nb1 = $this->NbLines($w[2], utf8_decode($row['descripcion_evento']));
            $nb2 = $this->NbLines($w[5], utf8_decode($row['descripcion_exhibicion']));
            $maxLines = max($nb1, $nb2, 1);
            $rowHeight = 5 * $maxLines;

            $this->Cell($w[0], $rowHeight, $row['id_evento'], 1);
            $this->Cell($w[1], $rowHeight, utf8_decode($row['nombre_evento']), 1);

            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell($w[2], 5, utf8_decode($row['descripcion_evento']), 1);
            $this->SetXY($x + $w[2], $y);

            $this->Cell($w[3], $rowHeight, $row['id_exhibicion'], 1);
            $this->Cell($w[4], $rowHeight, utf8_decode($row['lugar_exhibicion']), 1);

            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell($w[5], 5, utf8_decode($row['descripcion_exhibicion']), 1);
            $this->SetXY(10, $y + $rowHeight);
        }
    }

    // Agrega este método auxiliar a tu clase PDF (fuera de FancyTable)
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

$pdf = new PDF();
$pdf->AddPage();

$header = array('ID Evento', 'Nombre Evento', 'Descripcion Evento', 'ID Exhibicion', 'Lugar Exhibicion', 'Descripcion Exhibicion');
$data = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data[] = array(
        'id_evento' => '',
        'nombre_evento' => '',
        'descripcion_evento' => 'No hay eventos con exhibiciones.',
        'id_exhibicion' => '',
        'lugar_exhibicion' => '',
        'descripcion_exhibicion' => ''
    );
}

$pdf->FancyTable($header, $data);

$pdf->Output('D', 'informe_eventos_exhibiciones.pdf');
exit;
?>