# Misión Final Finanzas:
## Database:
[ ] Marcar como CNB las OC, y eliminar la columna "cenabast" de fin_dte, usando el criterio de OC 620 (no recuerdo el numero)
[ ] Agregar columna "completed" default (false) sin nullable a fin_dte (esta columna indica que la Factura tiene todas sus actas asociadas)
[ ] Setear completed en true, con todas las dtes que tenga confirmation_status true
[ ] Setear rejected (default 0) en true con todos los confirmation_status false
[ ] Copiar todos los datos de columna "confirmation_observation" a "reason_rejected"
[ ] Eliminar columna "confirmation_observation"
[ ] Renombrar confirmation_user_id completed_user_id
[ ] Renombrar confirmation_ou_id a completed_ou_id
[ ] Renombrar confirmation_at a completed_at
[ ] Renombrar fin_status que es un varchar a boolean payment_ready = true
[ ] Eliminar columnas (depués) cenabast_reception_file, cenabast_signed_*, block_singature

## Comando
[ ] Acta de recepción, crear actas retroactivas solo con el archivo "cenabast_reception_file" archivos de recepción
[ ] Asociar a acta de recepción $reception->files[] = [confirmation_signature_file, cenabast_reception_file]

[ ] Estudiar el modulo de firmas actual, para ver si creamos una registro en la tabla numeration por cada documento que ya fue firmado en "Solicitud de firma"
    esto porque el modelo "Numeration" es nuevo, y se encargará de asociar el numero del documento, con su creador y su codigo de veificacion,
    información que en el modulo de firmas actual está dentro de signatureFile

## Desarrollo
[ ] Index DTE, en la opción editar, permitir asociar una DTE de tipo facturas/boletas a una o más actas.
[ ] Modificar bandeja de Revisión para que caigan ahí, las que tienen "completed" == true

[ ] Editar una recepción
[ ] Actas de recepción, poder subir un archivo, ej: Escaneo de la factura con el timbre.
[ ] Modulo de recepcion, poder agregar un rechazo de mercaderia asociado a una OC
[X] En crear recepcion, dejar por defecto el estableciento de quien está logeado
[X] En recepciones, poner un indicador de "loading" cuando la OC se esté buscando en MP
[X] Validar obligatoriedad de radio de parcial o completa
[-] Al presionar crear se demora, poner spinner o indicador de "loading"
[X] Agregar columnas a Receptions guia_id y dte_id (y relationes $dte->receptions $reception->guia $reception->dte)

[X] Al numerar, no están saliendo los mensajes de error de firma electrónica, por ejemplo, que Vanessa no tiene firma desatendida
[ ] Notificar a oficina de partes que tiene que numerar

[ ] Desde bodega, al generar un ingreso crear una acta de recepción del modelo Reception o precargar el acta para luego crearlo
[ ] Bodega, no debe permitir firmar ni generar actas de recepcion. (ya no lo están usando)

[ ] En cargar boleta manual no mostrar el input de PDF para el caso de boleta electrónica
[ ] Agregar fecha de emisión de boleta al agregar una DTE manual