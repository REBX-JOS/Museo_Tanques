<?php
require_once __DIR__ . '/../fpdf/fpdf.php';
include_once __DIR__ . '/../config.php';

// Consulta de datos de mantenimientos correctivos
$query = "SELECT 
    m.id_mantenimiento,
    m.tipo_mantenimiento,
    m.notas,
    p.nombre_personal AS personal,
    t.nombre_tanque AS tanque
FROM mantenimientos m
JOIN mantenimiento_personal mp ON m.id_mantenimiento = mp.id_mantenimiento
JOIN personal p ON mp.id_personal = p.id_personal
JOIN tanques t ON m.id_tanque = t.id_tanque
WHERE m.tipo_mantenimiento = 'Correctivo'";

$res = $conn->query($query);

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('Informe: Mantenimientos Correctivos'), 0, 1, 'C');
        $this->Ln(5);
    }

    function FancyTable($header, $data)
    {
        // Ajusta estos valores para aprovechar mejor el ancho de página
        $w = array(20, 30, 75, 35, 30);
        $this->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 9);
        foreach ($data as $row) {
            // Calcula el alto máximo de la fila (para notas largas)
            $nbNotas = $this->NbLines($w[2], utf8_decode($row['notas']));
            $maxLines = max($nbNotas, 1);
            $rowHeight = 5 * $maxLines;

            $this->Cell($w[0], $rowHeight, $row['id_mantenimiento'], 1);
            $this->Cell($w[1], $rowHeight, utf8_decode($row['tipo_mantenimiento']), 1);

            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell($w[2], 5, utf8_decode($row['notas']), 1);
            $this->SetXY($x + $w[2], $y);

            $this->Cell($w[3], $rowHeight, utf8_decode($row['personal']), 1);
            $this->Cell($w[4], $rowHeight, utf8_decode($row['tanque']), 1);

            $this->SetXY(10, $y + $rowHeight);
        }
    }

    // Función auxiliar para calcular líneas de MultiCell
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

$header = array('ID', 'Tipo', 'Notas', 'Personal', 'Tanque');
$data = [];
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data[] = array(
        'id_mantenimiento' => '',
        'tipo_mantenimiento' => '',
        'notas' => 'No hay mantenimientos correctivos.',
        'personal' => '',
        'tanque' => ''
    );
}

$pdf->FancyTable($header, $data);

$pdf->Output('D', 'informe_mantenimientos_correctivos.pdf');
exit;
?>