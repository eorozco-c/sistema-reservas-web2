# Agencia de Viajes — Aplicación Web PHP + MySQL

Aplicación web desarrollada en PHP con base de datos MySQL para gestionar vuelos, hoteles y reservas de una agencia de viajes. Permite ingresar datos desde formularios web y realizar consultas avanzadas con JOIN y agregaciones.

---

## Estructura del proyecto

```
agencia_viajes/
├── conexion.php             # Configuración de conexión a MySQL
├── crear_bd.sql             # Script DDL: crea la base de datos y las tablas
├── insertar_reservas.sql    # Script DML: datos de ejemplo (reservas)
├── ingreso_datos.php        # Formulario web para ingresar vuelos, hoteles y reservas
└── consultas_avanzadas.php  # Página con listados y consultas avanzadas (JOIN, GROUP BY)
```

---

## Base de datos

**Nombre:** `AGENCIA`

| Tabla     | Descripción                                              |
|-----------|----------------------------------------------------------|
| `VUELO`   | Vuelos disponibles: origen, destino, fecha, precio, plazas |
| `HOTEL`   | Hoteles: nombre, ubicación, habitaciones, tarifa por noche |
| `RESERVA` | Reservas de clientes vinculadas a vuelos y/o hoteles     |

---

## Requisitos

- **PHP** 7.4 o superior (extensión `mysqli` habilitada)
- **MySQL** 5.7 o superior (o MariaDB equivalente)
- **Servidor Apache** (recomendado: [XAMPP](https://www.apachefriends.org/) o [WAMP](https://www.wampserver.com/))

---

## Instalación y ejecución local

### 1. Crear la base de datos

Importa el script SQL en **phpMyAdmin** o ejecuta en consola MySQL:

```sql
SOURCE /ruta/al/proyecto/crear_bd.sql;
SOURCE /ruta/al/proyecto/insertar_reservas.sql;
```

O bien desde phpMyAdmin: `Importar` → seleccionar `crear_bd.sql` → Ejecutar, luego repetir con `insertar_reservas.sql`.

### 2. Configurar la conexión

Abre `conexion.php` y ajusta las credenciales si es necesario:

```php
$servidor = "localhost";
$usuario  = "root";   // Cambia si usas otro usuario
$password = "";       // Cambia si tienes contraseña configurada
$basedatos = "AGENCIA";
```

### 3. Copiar el proyecto al servidor web

Copia la carpeta `agencia_viajes/` dentro del directorio raíz de tu servidor:

- **XAMPP:** `C:\xampp\htdocs\agencia_viajes\`
- **WAMP:** `C:\wamp64\www\agencia_viajes\`

### 4. Abrir en el navegador

| Página                  | URL                                              |
|-------------------------|--------------------------------------------------|
| Ingreso de datos        | `http://localhost/agencia_viajes/ingreso_datos.php` |
| Consultas y reportes    | `http://localhost/agencia_viajes/consultas_avanzadas.php` |

---

## Funcionalidades

- **Ingreso de vuelos:** formulario para registrar nuevos vuelos con origen, destino, fecha, precio y plazas.
- **Ingreso de hoteles:** formulario para registrar hoteles con nombre, ubicación, tarifa y habitaciones disponibles.
- **Registro de reservas:** asocia un cliente a un vuelo y/o un hotel con fecha de reserva.
- **Consultas avanzadas:** listado general de reservas, disponibilidad de vuelos y hoteles, y reportes con `JOIN` y `GROUP BY`.

---

## Tecnologías utilizadas

- **PHP** (backend, conexión MySQLi)
- **MySQL / MariaDB** (base de datos relacional)
- **HTML5 + CSS3** (interfaz web, sin frameworks externos)
- **Apache** (servidor HTTP local)
