<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultas Avanzadas - Agencia de Viajes</title>
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
        }

        h1,
        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #17a2b8;
            color: white;
        }

        .highlight {
            background-color: #e2e3e5;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Gestión de Reservas y Disponibilidad</h1>

        <h2>Listado General de Reservas (Consulta Simple)</h2>
        <table>
            <tr>
                <th>ID Reserva</th>
                <th>ID Cliente</th>
                <th>Fecha Reserva</th>
                <th>ID Vuelo</th>
                <th>ID Hotel</th>
            </tr>
            <?php
            $sql_reservas = "SELECT * FROM RESERVA";
            $resultado_reservas = $conn->query($sql_reservas);

            if ($resultado_reservas->num_rows > 0) {
                while ($row = $resultado_reservas->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id_reserva']}</td>
                        <td>{$row['id_cliente']}</td>
                        <td>{$row['fecha_reserva']}</td>
                        <td>{$row['id_vuelo']}</td>
                        <td>{$row['id_hotel']}</td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay reservas registradas.</td></tr>";
            }
            ?>
        </table>

        <h2>Hoteles con más de 2 reservas (Consulta Avanzada)</h2>
        <p>Cálculo de reservas por hotel mostrando solo aquellos con un alta demanda (> 2 reservas).</p>
        <table>
            <tr>
                <th>Nombre del Hotel</th>
                <th>Total de Reservas</th>
            </tr>
            <?php
            // Consulta avanzada usando JOIN, GROUP BY y HAVING
            $sql_avanzada = "SELECT h.nombre AS nombre_hotel, COUNT(r.id_reserva) AS total_reservas 
                         FROM HOTEL h 
                         INNER JOIN RESERVA r ON h.id_hotel = r.id_hotel 
                         GROUP BY h.id_hotel 
                         HAVING total_reservas > 2 
                         ORDER BY total_reservas DESC";

            $resultado_avanzada = $conn->query($sql_avanzada);

            if ($resultado_avanzada->num_rows > 0) {
                while ($row = $resultado_avanzada->fetch_assoc()) {
                    echo "<tr class='highlight'>
                        <td>{$row['nombre_hotel']}</td>
                        <td>{$row['total_reservas']}</td>
                      </tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Ningún hotel supera las 2 reservas.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>

</html>