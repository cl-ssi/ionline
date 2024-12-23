"""
Script de procesamiento de registros de asistencia desde dispositivos biométricos.

Descripción:
Este script interactúa con dispositivos biométricos conectados en red para obtener registros de asistencia, 
procesarlos y enviarlos al sistema IOnline (modelo `AttendanceRecords`) mediante una API REST. 
Se ejecuta de forma automatizada a través de cron jobs en el servidor `10.66.142.123` (Red MINSAL).

Funcionalidades:
- Conexión a dispositivos biométricos mediante sus direcciones IP configuradas.
- Obtención de datos de asistencia y detalles del dispositivo.
- Procesamiento y envío de los registros al sistema IOnline.
- Registro de logs informativos y de errores en el sistema para monitoreo y diagnóstico.

Configuración:
- La configuración, incluyendo IPs, credenciales y URLs de las APIs, se almacena en un archivo `configuration.txt`.

Cron Jobs:
- Ejecuta el script diariamente y mensualmente en el servidor:
  - `0 13 * * * python3 /root/scripts/marcas.py > /dev/null 2>&1`  (Diario a las 13:00 horas)
  - `0 0 * * * python3 /root/scripts/marcas.py > /dev/null 2>&1`   (Diario a las 00:00 horas)
  - `0 0 1 * * python3 /root/scripts/marcas.py > /dev/null 2>&1`   (Mensual el día 1 a las 00:00 horas)

Notas:
- Los logs incluyen detalles de IPs procesadas, errores encontrados, y la cantidad de registros enviados.
- Asegúrese de que las credenciales y URLs en el archivo de configuración sean correctas para evitar fallos en la conexión.
"""


from requests.auth import HTTPBasicAuth
from bs4 import BeautifulSoup
from datetime import datetime
import requests

# Leer configuración desde un archivo
def load_configuration(file_path="configuration.txt"):
    config = {}
    try:
        with open(file_path, 'r') as f:
            lines = f.readlines()
            for line in lines:
                line = line.strip()
                if line.startswith("#") or not line:
                    continue
                key, value = line.split("=", 1)
                config[key.strip()] = value.strip()
    except Exception as e:
        print(f"Error al leer el archivo de configuración: {e}")
    return config

# Cargar configuración
config = load_configuration()

# Extraer datos de la configuración
ip_list = config.get("ips", "").split(",")
user = config.get("user")
password = config.get("password")
api_url = f"https://{config.get('api_url')}/api/rrhh/save-attendance-records"
log_error_api_url = f"https://{config.get('log_error_api_url')}/api/rrhh/log-error"

# Datos de inicio de sesión
login_payload = {
    "username": config.get("username", ""),  # Usuario del sistema del reloj
    "userpwd": config.get("userpwd", ""),    # Contraseña del sistema del reloj
}

from datetime import datetime
import requests
from requests.auth import HTTPBasicAuth

def log_python_message(ip, message, log_type="error"):
    """
    Registra un mensaje de log en el sistema.

    Args:
        ip (str): Dirección IP relacionada con el log.
        message (str): Mensaje a registrar.
        log_type (str): Tipo de log (error o info). Default: "error".
    """
    try:
        # Validar el tipo de log
        if log_type not in ["error", "info"]:
            raise ValueError("El tipo de log debe ser 'error' o 'info'.")

        # Crear payload
        payload = {
            "ip": ip,
            "type": log_type,
            "message": message,
            "timestamp": datetime.now().isoformat()
        }
        headers = {'Content-Type': 'application/json'}

        # Enviar solicitud
        response = requests.post(
            log_error_api_url, 
            json=payload, 
            headers=headers, 
            auth=HTTPBasicAuth(user, password)
        )
        
        # Verificar respuesta
        if response.status_code == 200:
            print(f"Log '{log_type}' registrado exitosamente para IP {ip}.")
        else:
            print(f"Error al registrar log para IP {ip}: {response.status_code} - {response.text}")

    except Exception as e:
        print(f"Error al intentar registrar el log: {str(e)}")

# Inicializar estadísticas
processed_ips = []
errored_ips = []
total_records_inserted = 0

# Iterar sobre cada IP
for ip in ip_list:
    print(f"Procesando IP: {ip}")
    base_url = f"http://{ip}"
    login_url = f"{base_url}/csl/check"
    desktop_url = f"{base_url}/csl/desktop"
    user_url = f"{base_url}/csl/user?first=0&last=1000"
    query_url = f"{base_url}/csl/query?action=run"

    try:
        # Crear sesión
        session = requests.Session()
        response = session.get(base_url)
        if response.status_code != 200:
            print(f"Error al acceder al sitio: {response.status_code}")
            errored_ips.append(ip)
            continue

        # Enviar login
        response = session.post(login_url, data=login_payload)
        if "login" in response.url.lower() or response.status_code != 200:
            print(f"Error: Fallo el inicio de sesión para IP {ip}")
            continue
        print("Inicio de sesión exitoso!")

        # Acceder a datos del dispositivo
        desktop_response = session.get(desktop_url)
        if desktop_response.status_code != 200:
            print(f"Error al acceder al escritorio de IP {ip}: {desktop_response.status_code}")
            errored_ips.append(ip)
            continue

        # Parsear datos del dispositivo
        soup = BeautifulSoup(desktop_response.text, "html.parser")
        rows = soup.select("table.TableText1 tr")
        device_data = {row.find_all("td")[0].text.strip(): row.find_all("td")[1].text.strip() for row in rows if len(row.find_all("td")) >= 2}
        serial_number = device_data.get("Serial Number", "No disponible")
        ip_address = device_data.get("IP Address", ip)

        # Obtener lista de usuarios
        user_response = session.get(user_url)
        if user_response.status_code != 200:
            print(f"Error al acceder a usuarios de IP {ip}: {user_response.status_code}")
            errored_ips.append(ip)
            continue

        soup = BeautifulSoup(user_response.text, "html.parser")
        rows = soup.select("table tr")
        users = [row.find_all("td")[0].find("input")["value"] for row in rows[1:] if len(row.find_all("td")) >= 7 and row.find_all("td")[0].find("input")]

        # Configurar fechas
        sdate = datetime.now().strftime("%Y-%m-%d")
        edate = datetime.now().strftime("%Y-%m-%d")
        # Configurar fechas
        # sdate = "2024-11-01"
        # edate = "2024-11-25"
        query_payload = {
            "sdate": sdate,
            "edate": edate,
            "uid": users,
            "period": "0",
        }

        # Realizar consulta de registros de asistencia
        query_response = session.post(query_url, data=query_payload)
        if query_response.status_code != 200:
            print(f"Error en la consulta de registros de IP {ip}: {query_response.status_code}")
            errored_ips.append(ip)
            continue

        soup = BeautifulSoup(query_response.text, "html.parser")
        rows = soup.select("table tr")
        attendance_records = [
            {
                "date": row.find_all("td")[0].text.strip(),
                "id_number": row.find_all("td")[1].text.strip(),
                "name": row.find_all("td")[2].text.strip(),
                "time": row.find_all("td")[3].text.strip(),
                "status": row.find_all("td")[4].text.strip(),
                "verification": row.find_all("td")[5].text.strip(),
            }
            for row in rows[1:]
            if len(row.find_all("td")) >= 6
        ]

        # Crear payload para la API
        payload = {
            "attendance_records": attendance_records,
            "device_info": {
                "ip_address": ip_address,
                "serial_number": serial_number,
            },
        }

        # Enviar datos al API
        headers = {'Content-Type': 'application/json'}
        response = requests.post(api_url, json=payload, headers=headers, auth=HTTPBasicAuth(user, password))
        if response.status_code == 200:
            print(f"Datos enviados exitosamente para IP {ip}")
            processed_ips.append(ip)
            total_records_inserted += len(attendance_records)
        else:
            print(f"Error al enviar datos de IP {ip}: {response.status_code}")
            print("Detalle del error:", response.text)
            errored_ips.append(ip)

    except Exception as e:
        print(f"Error procesando IP {ip}: {str(e)}")
        error_message = f"Error procesando IP {ip}: {str(e)}"
        log_python_message(ip, error_message, log_type="error")
        errored_ips.append(ip)


print("Procesamiento completo.")
summary_message = (
    f"Procesamiento finalizado. "
    f"Total de IPs procesadas: {len(ip_list)}; "
    f"IPs procesadas correctamente: {len(processed_ips)}; "
    f"IPs con errores: {len(errored_ips)} ({', '.join(errored_ips) if errored_ips else 'Ninguna'}); "
    f"Total de registros procesados: {total_records_inserted}"
)
log_python_message("N/A", summary_message, log_type="info")