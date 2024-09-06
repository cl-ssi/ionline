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

[X] Estudiar el modulo de firmas actual, para ver si creamos una registro en la tabla numeration por cada documento que ya fue firmado en "Solicitud de firma"
    esto porque el modelo "Numeration" es nuevo, y se encargará de asociar el numero del documento, con su creador y su codigo de veificacion,
    información que en el modulo de firmas actual está dentro de signatureFile

## Desarrollo
[X] Index DTE, en la opción editar, permitir asociar una DTE de tipo facturas/boletas a una o más actas.
[X] Modificar bandeja de Revisión para que caigan ahí, las que tienen "completed" == true
[ ] Ponerle en alguna parte de las bandejas de pago los archivos legacy
[X] Permitir subir archivo cenabast en reception

[X] Modulo de recepcion, poder agregar un rechazo de mercaderia asociado a una OC
[ ] En index dte, al asociar un dte a un rechazo, completar los campos rejected y observation de fin_dte
[ ] En create reception, marcar aquellas dtes que tengan un acta de rechazo ya.
[X] Actas de recepción, poder subir un archivo, ej: Escaneo de la factura con el timbre.
[X] Editar una recepción
[X] En crear recepcion, dejar por defecto el estableciento de quien está logeado
[X] En recepciones, poner un indicador de "loading" cuando la OC se esté buscando en MP
[X] Validar obligatoriedad de radio de parcial o completa
[-] Al presionar crear se demora, poner spinner o indicador de "loading"
[X] Agregar columnas a Receptions guia_id y dte_id (y relationes $dte->receptions $reception->guia $reception->dte)
## Numerar
[X] No permitir numerar documentos que aún no están aprobados en su totalidad
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


## Estadísica

[ ] Armar la glosa, archivo glosa, tabla prestaciones
[ ] Copiar tabla establecimientos, rems, secciones a un año mas



## Partes
[ ] Copiar(crear) columnas organizational_unit_id, user_id desde parte_events hacia partes
[ ] eliminar model parte_events con su tabla
[ ] crear signatures_file_id en partes y migrar desde la tabla parte_files, todos los files que tengan un signature_file_id (el nombre es distinto) distinto de null, entonces el parte quedaría con la relacion $parte->signatureFile
[ ] Por cada ParteFile crear un File (generico) y crear la relacion polimorfica File en modelo Parte
[ ] Borrar modelo ParteFile

## Inventario


Calculo de valor del bien, NETO * IVA (primer intento)
Ejemplo de Juego de Living, 3 sillones, que son un solo item en la OC, se inventarean en 3 y se calcula su valor en base a valor de mercado.

Fusionar, estudiar como es

No pasar GD a pago
17316  gd 15919

bandeja mes
a todas las licitaciones se les pide boleta de garantía.

Numero, Licitación


11813, DTE no se le ve FR



Esconder modificar fecha de recepción

Hacer un buscador de FR para OC 


1272565-750-AG23 quien hizo el acta, mostrar en el acta



Todas las actas, deben llegar a abastecimiento una vez numeradas



Al rechazar, notificar a abastecimiento y crear una bandeja de rechazos
Notificar al comprador, del FR



Notificar a contabilidad que el acta fue modidicada y que contabilidad pueda notificar al creador un error en el acta.




Inventario
- Ubicación, incorporar en el filtro el id o el codigo de arquitectura.

- Cargar un bien sin ubicación

- Acta de devolución 

- Acta traspado id 3187 ver actas de traspado

- No se ingresó a bodega 1057448-587-CM23
 

y en el excel esté la columa de clasificiación también.

Ultimos ingresos de bodega, cambiar ultimas recepciones.

- No sea obligatorio vida util ni depreciación ni cuenta contable.
- Nuevo traslado, ubicación restringir los lugares al establecimiento del inventario.
- Index de Inventario. Si tiene un traslado pendiente, Completar los datos con rojo, indicando pendiente, ubicacion, lugar, respon y usuario
- Perfil inventario del usuario: En el index, mostrar las mismas columnnas que tiene inventario: NºInventario, Producto, Estado, Ubicacion, Lugar, Resp, Usuario
- Hoja "Completar traspaso": Tres columnas: Quien entrega, Quien recepciona / Responsable, El usuario
- En hoja "Mi inventario", Ordenar columnas: NºInventario, Producto, Estado, Ubicacion/Lugar, Resp, Usuario
- Corregir error en Generar traspaso, al incoporar nueva linea, la anterior queda en blanco, no proboca nada grave, sólo no se ve.
- Ver ubicación a la que se está haciendo traspaso.
- Hoja: Registrar inventario (inventario nuevo) Ubicación, que sea del establecimiento seleccionado. (Pendiente opción para busqueda de ubicación global)


- Descargar la base de datos. (me niego)



[ Responsable ] [ Usuario ] [ Place ]   [ Btn Traspasar ]

Movement::create([......]);





## Experto HETG 
Integración ... Experto.
Igresar lote manual


Reunión con Eric.
El stock crítico lo tiene experto
Tiene lote y vencimiento
No ingresan el lote
Porque el volumen de información es mucho


Perifericas no deberían existir
Omnicel
15 bodegas.

Urgencia y Pabellon deberían existir



- Próxima Reunión tecnica 11 diciembre
- Presentación avances 15 diciembre


- Estudiar Código de Barra para cargar Lote/Vencimiento den las perifericas (GS1) 
- Perifericas hacen solicitudes a sistema experto. Experto valida que esté programado, si no está programado es una solicitud extra validada por jefe de RRFF.
- Integración: Experto envía información de despacho, Nuestro sistema lo carga
- Integración: Ficha clínica, Rebajar por paciente
- Rebajar por pabellon/piso (otro tipo de rebaja)

### Presentación Experto

- Stock Crítico
- Bodega de consumo inmediato
- Aprobar pedido extra (es como aumento de cupo)
- Solicitudes de pedidos
- CENABAST cargan la info de lo que le va a llegar de un reporte de CENABAST
- Las facturas se ingresan primero, y no las guias, luego se pueden enviar por una nómina a finanzas

- URL Prod: http://10.6.53.30/produccion/interface.php
- URL Test: http://128.1.4.230/produccion/login.php

Compromisos:
========================================================================
SST envía de aquí al viernes 1 de diciembre, lo que necesitamos, productos y recepción:
Array( [codigo, nombre poducto], cantidad, fecha, vencimiento, unida de med....)

(opcional) Enviar documentación/información de como crear solicitud. (Max 7 de próxima semana)

Integración:
HETG, nos envía Codigo, cantidad para rebajar el stock
SST Hará servicio para rebaja desde la ficha clínica.

SST:
Desarrollará: Rebaja a piso. (listado de piso?)

HTEG:
Si podemos parametrizar el concepto de piso


Experto:
Genera la OC en MP
Llega la OC recepción.
Circulo completo ambiente de pruebas.












## AMIPASS
Permisos compensatorios, si te tomas una hora, te lo cuenta como un día


Compensatorio, de 8 horas hacia arriba, se concidera, el resto.


Elimina permiso admin que son de 0.5

Persona con licencia médica, ausentismo de octubre

14158914	Luis Levimil Otárola

Revisar caso tudela, omayra, y cambios de mes


Sofia barros toro


usuarios y sus ous



UHCIP
Jardin
SAMU






## Calificaciones
Formulario de Calfiicacion modulo planta sirh

Informe de desempeño:
- Septiembre a Diciembre
- Enero a Abril

Geenra solo una precalificación, en base a los dos informes de desempeño

Septiembre a Agosto del siguiente año


No pone nota, solo hace una descripción, que se asocia a una nota.

Reglamento de calificaciones 1.229

Modelo Planta


400 funcionarios.



Enero Informe


Septiempre a Diciembre: Primer informe de desempeño, Se hace en enero

Enero a Abril, es el segundo informe primeros días de mayo notificando

Precalificación: agosto es la primera

Calificación: 21 sep a 31 de octubre  máximo

Notificación calificaciones: Noviembre a Diciembre


Etapa de apelación: Post notificación. (5 días para apelar)

Resolución de las apelaciones por parte de la directroa.


Notificación de las apelaciones (

Cierra el proceso.




Anotacion de mérito.

Contrata y Planta, Jefatura hace o superiores

Fecha / Texto / Listado de factores?


Nota del 1 al 7 con decimales



Factor


[ ] Video usuarios y autoridades






## Convenios
- Descargas en Word
- Formato con el editor de documentos
- Dificultades en dos áreas
  - Cambios de formato Jurídicos
  - 

Flexibilidad en los formatos.

Procesos de convenios, son 5
 Convenio nuevo
   - modificación
   - prorrogas
   - resoluciones de continuidad


Articulado 
Subtitulo 24 presupuesto de las municipalidades

La plataforma si permite hacer la 21 y 22. 
Se puede generar una resolución de los convenios en otra opción.
(Natalia)

Resolución y convenios en una misma pantalla.

Plataforma que sea interacción con las comunas.


Subir documentos, descargar documentos.

Trabajar en el visto bueno de la comuna.
(como hacer para dos cambios al mismo tiempo, comuna y sst)


Seguimiento del proceso del convenio. (ej 3 meses)


No tanta pestaña


Requerimientos:
====================================================
Primer hito (adjuntar) con fecha de anexamiento 
- Resolución aprobatoria del programa
- Resolución de distribución de recursos del programa

Planear distribución local que es igual al CDP.
(40 días corridos COMGES)

Revisión de Natalia respecto de la revisión de la distribución.

Justificación técnica si es monto de ejecución es menor.


Convenios con comunas y sub 21 y 22.
- Convenio nuevo (Sub 24 tranf a terceros)
- Resolución de prorroga de convenio
- Reso sub 21 (programas -> nueva resolución) (no pasa por la comuna)
- Reso sub 22 (No pasa por la comuna)



Resolución modificatoria


Monto por componente
Calculo automático de valor de las cuotas
Previsualizar el convenio.
Modificar y terminarlo y referente indicar que está listo para revisón de la comuna (marca de tiempo)

Comuna, debería ingresar y realizar el visto bueno u observaciones, rechazado, etc. Aquí viene un pinponeo entre 


Mandar a visar el convenio. (mostrar firmas)
Firma alcalde
Firma directora (doc digital)


Avanzar con la resolución.
Toda se gestiona a través de DocDigital.

Oficina de partes, numeración resolución.
Resolución Final se va a la dipres. (ingresar fecha de carga a dipres)

Un mismo programa tiene distribuido los montos por item, podría salir un convenio y resoluciones de 21 y 22
en el seguimiento puede ser comuna o establecimiento.
con eso se sabe si es sub 21 o 22 para el caso de establecimiento.


Prorrogas 
(Resolución de prorroga) No lleva firma del alcalde
=========
Cargar los dos primeros hitos.
Base en el ultimo convenio.

¿Qué pasa cuando supera las 5.000 UTM para las prorrogas?

Resolución modificatoria para resolución de prorroga
Modificación de convenio, adendum.

Adendum tiene el mismo flujo de un convenio



Descargar Excel de seguimiento.
Informe de las platas (Ej, cuanto plata se le entregó a Pica por programa)

Finanzas incorporar transferencias realizadas.


Enero 2025.

Word.

Perfiles. (Comuna, Referente, Admin de convenios (eliminar))
Alertas de que necesitan realizar una acción
