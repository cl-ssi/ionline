import requests
from xml.etree.ElementTree import Element, SubElement, tostring

def send_attendance_soap(pin, date, time, tipo):
    """
    Envía un registro de asistencia al Web Service utilizando SOAP de forma directa.

    Args:
        pin (str): Identificador del usuario en el reloj.
        date (str): Fecha de la marca en formato dd/mm/yyyy.
        time (str): Hora de la marca en formato hhmm.
        tipo (str): Tipo de marca ('E' para entrada, 'S' para salida).

    Returns:
        dict: Resultado del envío con código y mensaje.
    """
    # Configuración del servicio
    ws_url = "http://10.6.53.29/ws_marcas_reloj/WSCargaMarcas.asmx"
    headers = {
        "Content-Type": "text/xml; charset=utf-8",
        "SOAPAction": "http://tempuri.org/Carga_marcas"
    }

    # Validar y extraer el periodo
    try:
        periodo = f"{date[-4:]}{date[3:5]}"
        print(f"Periodo generado: {periodo}")  # Registro para verificar el formato
    except Exception as e:
        return {"codigo": "8", "mensaje": f"Error al generar periodo: {str(e)}"}
    
    # Crear el cuerpo del SOAP
    soap_body = f"""
    <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <Carga_marcas xmlns="http://tempuri.org/">
                <XMLCarga>
                    <![CDATA[
                    <reloj>
                        <usuario>ionline</usuario>
                        <pasword>noubu</pasword>
                        <periodo>{periodo}</periodo>
                        <tipo_reloj>1</tipo_reloj>
                        <marca>
                            <pin>{pin}</pin>
                            <fecha>{date}</fecha>
                            <hora>{time}</hora>
                            <tipo>{tipo}</tipo>
                        </marca>
                        <marca>
                            <pin>{pin}</pin>
                            <fecha>24/11/2024</fecha>
                            <hora>{time}</hora>
                            <tipo>{tipo}</tipo>
                        </marca>
                    </reloj>
                    ]]>
                </XMLCarga>
            </Carga_marcas>
        </soap:Body>
    </soap:Envelope>
    """

    print(soap_body)

    try:
        # Realizar solicitud POST al Web Service
        response = requests.post(ws_url, data=soap_body, headers=headers)

        # Procesar respuesta
        if response.status_code == 200:
            return {"codigo": "9", "mensaje": "Proceso correcto", "respuesta": response.text}
        else:
            return {"codigo": "8", "mensaje": f"Error: {response.status_code}", "respuesta": response.text}
    except Exception as e:
        return {"codigo": "8", "mensaje": f"Excepción: {str(e)}"}

# Ejemplo de uso
result = send_attendance_soap(
    pin="8050436",
    date="25/11/2024",
    time="1200",
    tipo="E"
)

print(result)
