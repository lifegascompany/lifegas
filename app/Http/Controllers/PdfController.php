<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use App\Models\Expediente;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{
    // Genera carta de garantía para una conversión específica
    public function generaPdfCartaGarantia($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fechaCert = is_string($vehiculo->expediente->created_at) ? new DateTime($vehiculo->expediente->created_at) : $vehiculo->expediente->created_at;
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

    // Genera manual y mantenimiento de un vehículo específico
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

    // Genera una orden de trabajo con el detalle de repuestos y accesorios de una conversión
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

    // Genera y descarga el PDF de la ficha de evaluación de un expediente.
    public function generaPdfEvaluacion($id)
    {
        // Buscamos el expediente con sus relaciones necesarias
        $expediente = Expediente::with(['cliente', 'vehiculo', 'cita.asesor', 'evaluaciones.detalles'])->find($id);

        // Verificamos si el expediente y la evaluación existen
        if (!$expediente) {
            return redirect()->back()->with('error', 'No se encontró el expediente.');
        }

        // Obtenemos la primera evaluación de la colección.
        $evaluacion = $expediente->evaluaciones->first();

        // Verificamos si se encontró la evaluación y sus detalles
        if (!$evaluacion || !$evaluacion->detalles) {
            return redirect()->back()->with('error', 'No se encontró la evaluación o sus detalles para este expediente.');
        }

        // Asignamos la variable para los detalles
        $detalles = $evaluacion->detalles;

        // Preprocesamos los datos para la vista
        $data = [
            'expediente_id' => $expediente->id,
            'fechaIngreso' => $evaluacion->fecha_evaluacion->format('d/m/Y'),
            'fechaSalida' => $expediente->cita->fecha_salida ?? 'Pendiente',
            'nombreCliente' => $expediente->cliente->nombre . ' ' . $expediente->cliente->apellido,
            'dniCliente' => $expediente->cliente->documento,
            'telefonoCliente' => $expediente->cliente->telefono,
            'placaVehiculo' => $expediente->vehiculo->placa,
            'placaAnteriorVehiculo' => $expediente->vehiculo->placa_anterior ?? 'NE',
            'marcaVehiculo' => $expediente->vehiculo->marca,
            'modeloVehiculo' => $expediente->vehiculo->modelo,
            'motorVehiculo' => $expediente->vehiculo->serie,
            'colorVehiculo' => $expediente->vehiculo->color,
            'anioVehiculo' => $expediente->vehiculo->anio,
            'combustibleVehiculo' => $expediente->vehiculo->combustible,
            'kilometrajeVehiculo' => $expediente->vehiculo->kilometraje ?? 'NE',
            'observaciones' => $evaluacion->observaciones ?? null,
            'detallesEvaluacion' => $detalles,
            'tarjeta_propiedad' => $detalles->tarjeta_propiedad,
            'soat' => $detalles->soat,
            'llave_contacto' => $detalles->llave_contacto,
            'espejos' => $detalles->espejos,
            'antena' => $detalles->antena,
            'plumillas' => $detalles->plumillas,
            'vasos' => $detalles->vasos,
            'emblemas' => $detalles->emblemas,
            'tapa_combustible' => $detalles->tapa_combustible,
            'bateria' => $detalles->bateria,
            'seguro_bateria' => $detalles->seguro_bateria,
            'claxon' => $detalles->claxon,
            'tapa_aceite' => $detalles->tapa_aceite,
            'tapa_radiador' => $detalles->tapa_radiador,
            'barita_capot' => $detalles->barita_capot,
            'espejo_anterior' => $detalles->espejo_anterior,
            'tapasoles' => $detalles->tapasoles,
            'radio' => $detalles->radio,
            'reproductor_cd' => $detalles->reproductor_cd,
            'parlantes' => $detalles->parlantes,
            'cenicero' => $detalles->cenicero,
            'encendedor' => $detalles->encendedor,
            'pisos' => $detalles->pisos,
            'fundas_forros' => $detalles->fundas_forros,
            'cinturones' => $detalles->cinturones,
            'llanta_repuesto' => $detalles->llanta_repuesto,
            'gata_palanca' => $detalles->gata_palanca,
            'llave_ruedas' => $detalles->llave_ruedas,
            'triangulo' => $detalles->triangulo,
            'extintor' => $detalles->extintor,
            'linterna' => $detalles->linterna,
            'herramientas' => $detalles->herramientas,
            'botiquin' => $detalles->botiquin,
        ];

        // Cargamos la vista y le pasamos los datos
        //$pdf = PDF::loadView('pdfs.ficha-evaluacion', compact('expediente'));
        $pdf = PDF::loadView('pdfs.ficha-evaluacion', $data);
        // Devolvemos el PDF para visualizar en el navegado
        return $pdf->stream('evaluacion-expediente-' . $expediente->id . '.pdf');
    }
}
