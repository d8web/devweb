<?php
    ob_start();
    include($_SERVER["DOCUMENT_ROOT"]."/project/core/views/admin/pages/templatePdf.php");
    $content = ob_get_contents();
    ob_end_clean();

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($content);
    $mpdf->Output();
?>