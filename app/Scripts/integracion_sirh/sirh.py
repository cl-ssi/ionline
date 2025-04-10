import cx_Oracle
import json
import os
import requests
import traceback
from datetime import datetime
from requests.auth import HTTPBasicAuth

# Definir la ruta del archivo de registro
log_file_path = os.path.join(os.path.dirname(os.path.realpath(__file__)), "log.txt")

# Función para escribir en el archivo de registro y mostrar en la consola
def write_to_log(message):
    timestamp = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    log_message = f"{timestamp}: {message}"
    with open(log_file_path, "a") as log_file:
        log_file.write(log_message + "\n")
    print(log_message)

# Función para imprimir el título bonito
def print_title():
    title = """
*******************************************
*        SERVICIO DE SALUD TARAPACÁ       *
*******************************************
"""
    print(title)

# Leer los datos del archivo cfg.json
current_directory = os.path.dirname(os.path.realpath(__file__))
cfg_file_path = "cfg.json"

with open(cfg_file_path) as cfg_file:
    cfg_data = json.load(cfg_file)

# Obtener los datos de conexión a la base de datos
jdbcURL = "10.6.53.29:1521/SIRHIQUI"  # Solo el host y el puerto, sin prefijo jdbc:oracle:thin
bdUser = "UCONSULTA"
bdPassword = "123456"

# Datos del servicio web de salida
wsURL = cfg_data["endpoint"]
wsUser = "sistemas.ssi@redsalud.gob.cl"  # Si el campo wsUser no está presente, usar una cadena vacía por defecto
wsPassword = "12345678"  # Si el campo wsPassword no está presente, usar una cadena vacía por defecto

# Obtener los conjuntos de datos del archivo cfg.json
data_sets = cfg_data.get("data_sets", [])

# Imprimir el título bonito una vez
print_title()

# Función para conectar y ejecutar la consulta
def ejecutar_consulta(jdbcURL, bdUser, bdPassword, consultaSQL, model_route, column_mapping, primary_keys):
    try:
        # Conectar a la base de datos
        connection = cx_Oracle.connect(bdUser, bdPassword, jdbcURL)

        # Crear un cursor
        cursor = connection.cursor()

        # Ejecutar la consulta SQL
        cursor.execute(consultaSQL)

        # Obtener los resultados
        resultados = cursor.fetchall()

        # Obtener los nombres de las columnas
        column_names = [desc[0] for desc in cursor.description]

        # Construir la lista de datos en formato JSON
        model_data = []
        for row in resultados:
            row_data = {}
            for i, column_name in enumerate(column_names):
                # Convertir los objetos datetime a cadenas de texto
                if isinstance(row[i], datetime):
                    row_data[column_name] = row[i].strftime("%Y-%m-%d")  # Formato YYYY-MM-DD
                else:
                    row_data[column_name] = row[i]
            model_data.append(row_data)
            
        # print(model_route)
        # print(model_data)
        # print(column_mapping)
        # print(primary_keys)
        
        # Crear el JSON con el formato especificado
        json_data = {
            "model_route": model_route,
            "model_data": model_data,
            "column_mapping": column_mapping,
            "primary_keys": primary_keys
        }

        # Imprimir el JSON antes de enviarlo al servicio web
        # print("JSON enviado al servicio web:")
        # print(json.dumps(json_data, indent=4))
        
        # Enviar el JSON al servicio web
        response = requests.post(wsURL, json=json_data, auth=HTTPBasicAuth(wsUser, wsPassword))

        # Imprimir el mensaje devuelto por el servidor con el título bonito
        # print_title()
        print("Mensaje devuelto por el servidor:")
        print(response.text)

        # Registrar en el archivo de registro que la ejecución fue exitosa
        write_to_log("Ejecución exitosa")

    except Exception as e:
        # Escribir el error en el archivo de registro y mostrar en la consola
        error_message = f"Error: {str(e)}\nTraceback: {traceback.format_exc()}"
        write_to_log(error_message)
        print("Ocurrió un error. Detalles en el archivo de registro.")
        print(error_message)

    finally:
        # Cerrar el cursor y la conexión
        if 'cursor' in locals():
            cursor.close()
        if 'connection' in locals() and connection:
            connection.close()

# Llamar a la función para ejecutar las consultas para cada conjunto de datos
for data_set in data_sets:
    consultaSQL = data_set.get("sql_query")
    model_route = data_set.get("model_route")
    column_mapping = data_set.get("column_mapping")
    primary_keys = data_set.get("primary_keys")
    ejecutar_consulta(jdbcURL, bdUser, bdPassword, consultaSQL, model_route, column_mapping, primary_keys)

# Solicitar al usuario que presione Enter antes de salir
input("Presione Enter para salir...")

