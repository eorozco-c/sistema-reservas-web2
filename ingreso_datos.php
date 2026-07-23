<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Agencia de Viajes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #333;
        }

        form {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            background: #fafafa;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 15px;
            padding: 10px 15px;
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
        }

        .msg {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
    <script>
        // Validaciones JavaScript
        function validarVuelo() {
            let origen = document.getElementById('origen').value;
            let destino = document.getElementById('destino').value;
            if (origen.trim() === '' || destino.trim() === '') {
                alert("El origen y destino no pueden estar vacíos.");
                return false;
            }
            return true;
        }

        function validarHotel() {
            let nombre = document.getElementById('nombre_hotel').value;
            let ubicacion = document.getElementById('ubicacion').value;
            if (nombre.trim() === '' || ubicacion.trim() === '') {
                alert("El nombre del hotel y la ubicación son obligatorios.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Administración de Servicios Turísticos</h1>

        <?php
        // Procesamiento del formulario de VUELOS (prepared statement — previene SQL Injection)
        if (isset($_POST['btn_vuelo'])) {
            $origen  = trim($_POST['origen']);
            $destino = trim($_POST['destino']);
            $fecha   = $_POST['fecha'];
            $plazas  = (int) $_POST['plazas'];
            $precio  = (float) $_POST['precio'];

            $stmt = $conn->prepare(
                "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('sssid', $origen, $destino, $fecha, $plazas, $precio);
            if ($stmt->execute()) {
                echo "<div class='msg success'>Vuelo registrado con éxito.</div>";
            } else {
                echo "<div class='msg error'>Error al registrar vuelo: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        }

        // Procesamiento del formulario de HOTELES (prepared statement — previene SQL Injection)
        if (isset($_POST['btn_hotel'])) {
            $nombre       = trim($_POST['nombre_hotel']);
            $ubicacion    = trim($_POST['ubicacion']);
            $habitaciones = (int) $_POST['habitaciones'];
            $tarifa       = (float) $_POST['tarifa'];

            $stmt = $conn->prepare(
                "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param('ssid', $nombre, $ubicacion, $habitaciones, $tarifa);
            if ($stmt->execute()) {
                echo "<div class='msg success'>Hotel registrado con éxito.</div>";
            } else {
                echo "<div class='msg error'>Error al registrar hotel: " . htmlspecialchars($stmt->error) . "</div>";
            }
            $stmt->close();
        }

        // ── Búsqueda de vuelos ──────────────────────────────────────────────────
        $busqueda_realizada = false;
        $res_busqueda       = null;
        if (isset($_POST['btn_buscar'])) {
            $busqueda_realizada = true;
            $b_origen  = '%' . trim($_POST['b_origen'])  . '%';
            $b_destino = '%' . trim($_POST['b_destino']) . '%';
            $b_fecha   = $_POST['b_fecha'];   // puede estar vacío

            if ($b_fecha !== '') {
                $stmt = $conn->prepare(
                    "SELECT * FROM VUELO
                     WHERE origen  LIKE ?
                       AND destino LIKE ?
                       AND fecha   = ?
                     ORDER BY fecha ASC"
                );
                $stmt->bind_param('sss', $b_origen, $b_destino, $b_fecha);
            } else {
                $stmt = $conn->prepare(
                    "SELECT * FROM VUELO
                     WHERE origen  LIKE ?
                       AND destino LIKE ?
                     ORDER BY fecha ASC"
                );
                $stmt->bind_param('ss', $b_origen, $b_destino);
            }
            $stmt->execute();
            $res_busqueda = $stmt->get_result();
            $stmt->close();
        }
        ?>

        <h2>Registrar Vuelo</h2>
        <form action="ingreso_datos.php" method="POST" onsubmit="return validarVuelo();">
            <label>Origen:</label> <input type="text" id="origen" name="origen" required>
            <label>Destino:</label> <input type="text" id="destino" name="destino" required>
            <label>Fecha:</label> <input type="date" name="fecha" required>
            <label>Plazas Disponibles:</label> <input type="number" name="plazas" required min="1">
            <label>Precio ($):</label> <input type="number" step="0.01" name="precio" required min="1">
            <button type="submit" name="btn_vuelo">Guardar Vuelo</button>
        </form>

        <h2>Registrar Hotel</h2>
        <form action="ingreso_datos.php" method="POST" onsubmit="return validarHotel();">
            <label>Nombre del Hotel:</label> <input type="text" id="nombre_hotel" name="nombre_hotel" required>
            <label>Ubicación:</label> <input type="text" id="ubicacion" name="ubicacion" required>
            <label>Habitaciones Disponibles:</label> <input type="number" name="habitaciones" required min="1">
            <label>Tarifa por Noche ($):</label> <input type="number" step="0.01" name="tarifa" required min="1">
            <button type="submit" name="btn_hotel">Guardar Hotel</button>
        </form>

        <hr>
        <h2>Buscar Vuelos</h2>
        <form action="ingreso_datos.php" method="POST">
            <label>Origen:</label>
            <input type="text" name="b_origen" placeholder="Ej: Santiago"
                value="<?= isset($_POST['b_origen']) ? htmlspecialchars($_POST['b_origen']) : '' ?>">
            <label>Destino:</label>
            <input type="text" name="b_destino" placeholder="Ej: Lima"
                value="<?= isset($_POST['b_destino']) ? htmlspecialchars($_POST['b_destino']) : '' ?>">
            <label>Fecha (opcional):</label>
            <input type="date" name="b_fecha"
                value="<?= isset($_POST['b_fecha']) ? htmlspecialchars($_POST['b_fecha']) : '' ?>">
            <button type="submit" name="btn_buscar" style="background:#17a2b8;">Buscar Vuelos</button>
        </form>

        <?php if ($busqueda_realizada): ?>
            <h3>Resultados de búsqueda</h3>
            <?php if ($res_busqueda && $res_busqueda->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th>Plazas</th>
                        <th>Precio</th>
                    </tr>
                    <?php while ($row = $res_busqueda->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_vuelo'] ?></td>
                            <td><?= htmlspecialchars($row['origen']) ?></td>
                            <td><?= htmlspecialchars($row['destino']) ?></td>
                            <td><?= $row['fecha'] ?></td>
                            <td><?= $row['plazas_disponibles'] ?></td>
                            <td>$<?= number_format($row['precio'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <div class="msg error">No se encontraron vuelos con los criterios ingresados.</div>
            <?php endif; ?>
        <?php endif; ?>

        <hr>
        <h2>Consultas Simples: Datos Registrados</h2>

        <h3>Vuelos Disponibles</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Plazas</th>
                <th>Precio</th>
            </tr>
            <?php
            $res_vuelos = $conn->query("SELECT * FROM VUELO");
            while ($row = $res_vuelos->fetch_assoc()) {
                echo "<tr><td>{$row['id_vuelo']}</td><td>{$row['origen']}</td><td>{$row['destino']}</td><td>{$row['fecha']}</td><td>{$row['plazas_disponibles']}</td><td>\${$row['precio']}</td></tr>";
            }
            ?>
        </table>

        <h3>Hoteles Disponibles</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Habitaciones</th>
                <th>Tarifa</th>
            </tr>
            <?php
            $res_hoteles = $conn->query("SELECT * FROM HOTEL");
            while ($row = $res_hoteles->fetch_assoc()) {
                echo "<tr><td>{$row['id_hotel']}</td><td>{$row['nombre']}</td><td>{$row['ubicacion']}</td><td>{$row['habitaciones_disponibles']}</td><td>\${$row['tarifa_noche']}</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>