import requests
from xml.etree.ElementTree import Element, SubElement, tostring

def send_attendance_soap(pin, date, time, tipo):
    ws_url = "http://10.6.53.29/ws_marcas_reloj/WSCargaMarcas.asmx"
    headers = {
        "Content-Type": "text/xml; charset=utf-8",
        "SOAPAction": "http://tempuri.org/Carga_marcas"
    }

    try:
        periodo = f"{date[-4:]}{date[3:5]}"
    except Exception as e:
        return {"codigo": "8", "mensaje": f"Error al generar periodo: {str(e)}"}
    
    soap_body = f"""<?xml version="1.0" encoding="utf-8"?>
                    <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                    <soap:Body>
                        <Carga_marcas xmlns="http://tempuri.org/">
                        <xml><![CDATA[<reloj>
                            <usuario>IONLINE</usuario>
                            <pasword>NOUBU</pasword>
                            <periodo>{periodo}</periodo>
                            <tipo_reloj>1</tipo_reloj>
                            <marca>
                            <pin>{pin}</pin>
                            <fecha>{date}</fecha>
                            <hora>{time}</hora>
                            <tipo>{tipo}</tipo>
                            </marca>
                        </reloj>]]></xml>
                        </Carga_marcas>
                    </soap:Body>
                    </soap:Envelope>"""

    try:
        response = requests.post(ws_url, data=soap_body, headers=headers)
        if response.status_code == 200:
            return {"codigo": "9", "mensaje": "Proceso correcto", "respuesta": response.text}
        return {"codigo": "8", "mensaje": f"Error: {response.status_code}", "respuesta": response.text}
    except Exception as e:
        return {"codigo": "8", "mensaje": f"Excepción: {str(e)}"}

hacer pruebas con:

73 alejandra torres
7478 pamela 


# Ejemplo de uso
result = send_attendance_soap(
    pin="8050436",
    date="25/11/2024",
    time="1200",
    tipo="E"
)

print(result)
