# Misión Final Finanzas:
## Database:
[X] Marcar como CNB las OC, y eliminar la columna "cenabast" de fin_dte, usando el criterio de OC 621 (no recuerdo el numero)
[X] Agregar columna "all_receptions" default (false) sin nullable a fin_dte (esta columna indica que la Factura tiene todas sus actas asociadas)
[X] Setear all_receptions en true, con todas las dtes que tenga confirmation_status true
[X] Setear rejected (default 0) en true con todos los confirmation_status false
[X] Copiar todos los datos de columna "confirmation_observation" a "reason_rejected"
[X] Eliminar columna "confirmation_observation"
[X] Renombrar confirmation_user_id all_receptions_user_id
[X] Renombrar confirmation_ou_id a all_receptions_ou_id
[X] Renombrar confirmation_at a all_receptions_at
[X] Renombrar fin_status que es un varchar a boolean payment_ready = true
[ ] Eliminar columnas (depués) cenabast_reception_file, cenabast_signed_*, block_singature //depende del 16

## Comando
[X] Acta de recepción, crear actas retroactivas solo con el archivo "cenabast_reception_file" archivos de recepción //depende del 13
[ ] Asociar a acta de recepción $reception->files[] = [confirmation_signature_file, cenabast_reception_file]

[ ] Estudiar el modulo de firmas actual, para ver si creamos una registro en la tabla numeration por cada documento que ya fue firmado en "Solicitud de firma"
    esto porque el modelo "Numeration" es nuevo, y se encargará de asociar el numero del documento, con su creador y su codigo de veificacion,
    información que en el modulo de firmas actual está dentro de signatureFile

## Desarrollo
[X] Index DTE, en la opción editar, permitir asociar una DTE de tipo facturas/boletas a una o más actas.
[X] Modificar bandeja de Revisión para que caigan ahí, las que tienen "completed" == true
[ ] Ponerle en alguna parte de las bandejas de pago los archivos legacy
[ ] Permitir subir archivo cenabast en reception

[X] Modulo de recepcion, poder agregar un rechazo de mercaderia asociado a una OC
[ ] En index dte, al asociar un dte a un rechazo, completar los campos rejected y observation de fin_dte
[ ] En create reception, marcar aquellas dtes que tengan un acta de rechazo ya.
[X] Actas de recepción, poder subir un archivo, ej: Escaneo de la factura con el timbre.
[ ] Editar una recepción
[X] En crear recepcion, dejar por defecto el estableciento de quien está logeado
[X] En recepciones, poner un indicador de "loading" cuando la OC se esté buscando en MP
[X] Validar obligatoriedad de radio de parcial o completa
[-] Al presionar crear se demora, poner spinner o indicador de "loading"
[X] Agregar columnas a Receptions guia_id y dte_id (y relationes $dte->receptions $reception->guia $reception->dte)
## Numerar
[ ] No permitir numerar documentos que aún no están aprobados en su totalidad
[-] Al numerar, setear el número en Reception.
[X] Al numerar, no están saliendo los mensajes de error de firma electrónica, por ejemplo, que Vanessa no tiene firma desatendida
[X] Notificar a oficina de partes que tiene que numerar


[ ] Desde bodega, al generar un ingreso crear una acta de recepción del modelo Reception o precargar el acta para luego crearlo
[ ] Bodega, no debe permitir firmar ni generar actas de recepcion. (ya no lo están usando)

[ ] En cargar boleta manual no mostrar el input de PDF para el caso de boleta electrónica
[ ] Agregar fecha de emisión de boleta al agregar una DTE manual


## Inventario

[ ] Ubicación (en las opciones de traspado), incorporar en el filtro el id o el codigo de arquitectura.
[ ] No permitir crear un bien sin ubicación y con responsable, tiene que tener ubicacion y responsables para crear el registro de movimiento en el excel
[ ] Mi inventario. Mostrar bienes que estén en traslado.
[ ] Mi inventario: Separar código nuevo de antiguo. y en Modulo de admin de Inventario también
[ ] Filtrar por código antiguo.
[ ] Descarga de excel de la base de datos.
[ ] No se ingresó a bodega 1057448-587-CM23
[ ] Filtro por clasificación 
[ ] En el excel agregar la columa de clasificiación también.
[ ] Ultimos ingresos de bodega, cambiar ultimas recepciones.

[ ] Acta traspado id 3187 ver actas de traspado (esto ya no va)