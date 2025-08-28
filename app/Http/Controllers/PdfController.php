<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
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

    //Genera una orden de trabajo con el detalle de repuestos y accesorios de una conversión
    public function generaPdfOrdenRepuestos($id)
    {
        // 1. Cargar la conversión y sus relaciones (expediente, vehiculo, cliente, detalles)
        $conversion = Conversion::with(['expediente.vehiculo', 'expediente.cliente', 'conversionDetalles.repuesto'])->find($id);

        // Si no se encuentra la conversión, podemos redirigir o mostrar un error
        if (!$conversion) {
            abort(404, 'Conversión no encontrada.');
        }

        // Obtener la fecha actual para el documento
        $fechaActual = now()->format('d/m/Y');

        // 2. Cargar la vista de Blade y pasarle los datos de la conversión
        $pdf = Pdf::loadView('pdfs.orden_repuestos', compact('conversion', 'fechaActual'));

        // 3. Devolver el PDF para descarga o visualización en el navegador
        // Usar 'stream' para abrirlo en el navegador
        return $pdf->stream('orden_repuestos_' . $conversion->expediente->id . '.pdf');
    }
}
