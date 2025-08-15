<!DOCTYPE html>
<html>

<head>
    <title>CARTA DE GARANTIA</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: sans-serif;
        }

        body {
            margin: 1cm 2cm 2cm;
            display: block;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3.5cm;
            color: black;
            font-weight: bold;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        p {
            font-size: 12px;
            text-align: justify;
        }

        image {
            margin-left: 2cm;
        }

        h3 {
            margin-top: 3cm;
            font-size: 25px;
            color: black;
            text-align: center;
        }

        h4 {
            font-size: 14px;
            text-align: center;
        }

        h5 {
            text-align: right;
        }

        h6 {
            margin-bottom: -10px;
        }

        table,
        th,
        td {
            font-size: 10px;
            /*border: 1px solid;*/
            border-collapse: collapse;
        }

        table {
            width: 100%;
            border: none;
        }

        ol {
            list-style-type: lower-latin;
            font-size: 10px;
        }

        ul {
            font-size: 10px;
        }
    </style>
</head>

<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1cm 2cm 0 2cm;">
            <div style="display: flex; align-items: center;">
                <img src="{{ public_path('/images/header2.png') }}" alt="Lifegas Logo" style="width: 700px; height: auto;" />
                {{--
                <div style="margin-left: 20px;">
                    <p style="text-align: left; font-size: 16px; margin: 0; font-weight: bold;">Lifegas Company</p>
                </div>
                --}}
            </div>
            {{--
            <div style="text-align: right;">
                <p style="font-size: 16px; margin: 0;">Ruc: 20610295321</p>
                <p style="font-size: 16px; margin: 0;">R.D: N° 0224-2025-MTC/17.03</p>
            </div>
            --}}
        </div>
    </header>
    <main>
        <div style="text-align: right; margin-top: 4cm;">
            <p>Lima, 01 de AGOSTO de 2025</p>
        </div>

        <h3 style="margin-top: 2cm;">CARTA DE GARANTIA</h3>

        <h4 style="text-align: left; margin-bottom: 0;">SEÑOR:</h4>

        <p style="margin-top: 1.5cm;">POR MEDIO DE LA PRESENTE ME DIRIJO A USTED PARA HACERLE LLEGAR LA CARTA DE GARANTÍA DE 02 AÑOS DE LA INSTALACION DEL EQUIPO DE GNV A SU AUTO, PLACA ARA-316 EQUIPO DE LA MARCA IGT MOTORS, DE 5TA GENERACION, EN EL CUAL EL AUTO HA SALIDO EN PERFECTAS CONDICIONES.</p>

        <p>SE LE MENCIONA QUE DOS REVISIONES ANUALES GNV PUEDE REALIZARLA EN EL TALLER LIFE GAS COMPANY SIN NINGUN COSTO REALIZADO.</p>

        <p>LA GARANTIA SE HARA EFECTIVA SI EL CLIENTE CUMPLE CON SU MANTENIMIENTO PREVENTIVO CORRECTIVO, A LOS 7 MESES TENIENDO COSTO DE S/.0.00 Dos mantenimientos de gas pasando los 15000 km de recorrido sin costo adicional. SI NO SE REALIZARA EL MANTENIMIENTO INDICADO EL EQUIPO SE DETERIORA DE UNA MANERA RAPIDA Y LA EMPRESA NO SE HARA RESPONSABLE, POR ELLO SE LE RECOMIENDA CUMPLIR CON LO INDICADO PARA UN MEJOR CUIDADO DEL MOTOR DE LA UNIDAD.</p>

        <p style="margin-top: 2cm;">SIN OTRO PARTICULAR, ME DESPIDO.</p>
        
        <div style="text-align: center; margin-top: 4cm;">
            <img src="{{ public_path('/images/firma.png') }}" alt="Firma" style="width: 200px; height: auto;" />
        </div>
    </main>
    <footer>
        <div style="text-align: center; font-size: 10px; margin-top: 1cm; padding: 0 2cm; display: flex; justify-content: space-between; align-items: center;">
            <p style="margin: 0;">DIRECCION: AV. CANTO BELLO - CALLE LAS LIMAS 220 SAN JUAN DE LURIGANCHO</p>
            <p style="margin: 0;">CELULAR: 926921961 / 98334389</p>
        </div>
        <p style="text-align: center; font-size: 10px; margin-top: 0.5cm;">CORREO: lifegascompany@gmail.com</p>
    </footer>
</body>
</html>
