<!DOCTYPE html>
<html>

<head>
    <title>FICHA TÉCNICA DEL VEHÍCULO</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm 1.5cm;
            font-family: sans-serif;
        }

        p {
            font-size: 12px;
            margin: 0;
        }

        .section-title {
            background-color: #d1d5db;
            padding: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            font-size: 10px;
            padding: 4px 8px 4px 0;
            white-space: nowrap;
            vertical-align: bottom;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 100px;
            width: 100%;
        }

        .separator-line {
            border-top: 1px solid #000;
            margin-top: 2cm;
            padding-top: 10px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <main>
        <div class="section-title">DATOS DEL CLIENTE Y VEHÍCULO</div>

        <table>
            <tr>
                <td colspan="3">Apellidos / Nombres o Razón Social: <span class="line"></span></td>
            </tr>
            <tr>
                <td style="width: 35%;">DNI / CE / RUC: <span class="line"></span></td>
                <td colspan="2">Dirección: <span class="line"></span></td>
            </tr>
            <tr>
                <td style="width: 30%;">Distrito: <span class="line"></span></td>
                <td style="width: 30%;">Provincia: <span class="line"></span></td>
                <td>Departamento: <span class="line"></span></td>
            </tr>
            <tr>
                <td colspan="3">Marca / Modelo / Año del vehículo: <span class="line"></span></td>
            </tr>
            <tr>
                <td style="width: 60%;">Cilindrada: <span class="line"></span></td>
                <td colspan="2">Placa: <span class="line"></span></td>
            </tr>
            <tr>
                <td colspan="3">Alimentación: Dual Gasolina - <span class="line"></span></td>
            </tr>
            <tr>
                <td colspan="3">Tanque: (GLP O GNV) <span class="line"></span></td>
            </tr>
        </table>

        <div class="separator-line">
            <p>Sello y firma del taller</p>
        </div>
    </main>
</body>

</html>
