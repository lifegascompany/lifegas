<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    public function generaPdfCartaGarantia($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($vehiculo->created_at) ? new DateTime($vehiculo->created_at) : $vehiculo->created_at;
        $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

        $data = [
            "vehiculo" => $vehiculo,
            'fecha' => $fechaForma,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.vehiculo', $data);
        // Mostrar el PDF en el navegador
        return $pdf->stream('vehiculo' . $id . '.pdf');
    }

    public function generaPdfManual($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($vehiculo->created_at) ? new DateTime($vehiculo->created_at) : $vehiculo->created_at;
        $fechaForma = $fechaCert->format('d') . ' de ' . $meses[$fechaCert->format('m') - 1] . ' del ' . $fechaCert->format('Y');

        $data = [
            "vehiculo" => $vehiculo,
            'fecha' => $fechaForma,
        ];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdfs.manual', $data);
        // Mostrar el PDF en el navegador
        return $pdf->stream('manual' . $id . '.pdf');
    }
}
