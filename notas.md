# Apuntes de desarrollo
# Indice
- [DTE](#dte)
    - [Database](#database)
    - [Comando](#comando)
- [Partes](#partes)
- [Convenios](#convenios)
- [Estadistica](#estadistica)
- [Inventario](#inventario)
- [Contabilidad](#contabilidad)
- [AMIPASS](#amipass)
- [Calificaciones](#calificaciones)
- [Honorarios Firma Digital](#honorarios-firma-digital)

--
# DTE
## Database
- [X] Marcar como CNB las OC, y eliminar la columna "cenabast" de fin_dte, usando el criterio de OC 621 (no recuerdo el numero)
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

---
# Estadísica

[ ] Armar la glosa, archivo glosa, tabla prestaciones
[ ] Copiar tabla establecimientos, rems, secciones a un año mas


---
# Partes
[ ] Copiar(crear) columnas organizational_unit_id, user_id desde parte_events hacia partes
[ ] eliminar model parte_events con su tabla
[ ] crear signatures_file_id en partes y migrar desde la tabla parte_files, todos los files que tengan un signature_file_id (el nombre es distinto) distinto de null, entonces el parte quedaría con la relacion $parte->signatureFile
[ ] Por cada ParteFile crear un File (generico) y crear la relacion polimorfica File en modelo Parte
[ ] Borrar modelo ParteFile

---
# Inventario
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

Calculo de valor del bien, NETO * IVA (primer intento)
Ejemplo de Juego de Living, 3 sillones, que son un solo item en la OC, se inventarean en 3 y se calcula su valor en base a valor de mercado.

Fusionar, estudiar como es

### Nuevos requerimientos
[ ] Ubicación, incorporar en el filtro el id o el codigo de arquitectura.
[ ] Cargar un bien sin ubicación
[ ] Acta de devolución 
[ ] Acta traspado id 3187 ver actas de traspado
[ ] No se ingresó a bodega 1057448-587-CM23 y en el excel esté la columa de clasificiación también.
[ ] Ultimos ingresos de bodega, cambiar ultimas recepciones.

[ ] No sea obligatorio vida util ni depreciación ni cuenta contable.
[ ] Nuevo traslado, ubicación restringir los lugares al establecimiento del inventario.
[ ] Index de Inventario. Si tiene un traslado pendiente, Completar los datos con rojo, indicando pendiente, ubicacion, lugar, respon y usuario
[ ] Perfil inventario del usuario: En el index, mostrar las mismas columnnas que tiene inventario: NºInventario, Producto, Estado, Ubicacion, Lugar, Resp, Usuario
[ ] Hoja "Completar traspaso": Tres columnas: Quien entrega, Quien recepciona / Responsable, El usuario
[ ] En hoja "Mi inventario", Ordenar columnas: NºInventario, Producto, Estado, Ubicacion/Lugar, Resp, Usuario
[ ] Corregir error en Generar traspaso, al incoporar nueva linea, la anterior queda en blanco, no proboca nada grave, sólo no se ve.
[ ] Ver ubicación a la que se está haciendo traspaso.
[ ] Hoja: Registrar inventario (inventario nuevo) Ubicación, que sea del establecimiento seleccionado. (Pendiente opción para busqueda de ubicación global)
[ ] Descargar la base de datos. (me niego)

[ Responsable ] [ Usuario ] [ Place ]   [ Btn Traspasar ]

Movement::create([......]);

# Contabilidad
[ ] No pasar GD a pago
[ ] 17316  gd 15919

[ ] bandeja mes
- a todas las licitaciones se les pide boleta de garantía.

Numero, Licitación
11813, DTE no se le ve FR
Esconder modificar fecha de recepción

[ ] Hacer un buscador de FR para OC 

-1272565-750-AG23 quien hizo el acta, mostrar en el acta

Todas las actas, deben llegar a abastecimiento una vez numeradas

Al rechazar, notificar a abastecimiento y crear una bandeja de rechazos
Notificar al comprador, del FR

Notificar a contabilidad que el acta fue modidicada y que contabilidad pueda notificar al creador un error en el acta.


Finanzas:
fin_extra_sistema
(Compra extra sistema)
Fondo a rendir
Fondo fijo
Reembolso
Viáticos



# Experto HETG 
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

### Compromisos:
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




---
# AMIPASS
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




---
# Calificaciones
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



---
# Convenios
// Asignar el rol Convenios: Usuario a todos los referentes
User::whereHas('programs.referers')->get()->each(function ($user) { if (!$user->hasRole('Convenios: Usuario')) { $user->assignRole('Convenios: Usuario'); }});

TODO:

Presentación: 23-01-2025
- [X] Plantilla agrandar texto de la plantilla en doc_templates (content)
- [X] Aumentar tamaño del total_amount y ver si a las cuotas también necesitan agrandar el tamaño del en la BD. 
- [X] Monto total (total_amount) que sea obligatorio
- [X] Incoporar fecha del proceso document_date.
- [X] Boolean en tipo de proceso, si va o no a la comuna, caso prorroga, debajo de bilateral crear booleans revision_commune sign_commune.
- [*] Revisión de juridico debería reinciar si se vuelve a editar el documento.
- [X] En certificados: quitar boton agregar visacion (del repeater, addeable(false))
- [ ] Calculo de cuotas (decimales)


- [X] Permitir enviar varias veces el envio del proceso a la comuna, varias veces enviar el email con el pdf.
- [X] Solicitar firma directora en las que no son reso, debería firmar el archivo subido y no el que se firma en la reso.
- [ ] Usuario presionó dos veces el confirmar al crear un Procesos Dependientes y se duplicaron (está complejo controlar eso, si el usuario presiona dos veces).

Correo: 22-01-2025
- [ ] Implementar seguimiento. Reporte Proceso (En desarrollo)

Presentación: 20-01-2025
- [X] En aprobacion, que esten los dos documentos.
- [X] En certificados - Filtrar programas de los referentes.
- [ ] Ver como cambiar los vistos al cambiar de director, también para los alcaldes y la fecha del documento (en desarrollo).
- [X] Auto actualizar al crear visaciones.
- [X] Montos separar las miles y millones.
- [X] Notificar al referente y administradores al terminar la visación de un proceso.
- [X] Listado de certificados, filtar por los del referente.
- [X] Previsualizar Certificado.
- [X] Boton guardar el proceso al eliminar una visación.
- [X] Ver que juridico no pueda aprobar dos veces, o que no notifique dos veces.


Correo de Natalia
- [ ] Interfaz de comuna, al subir el archivo firmado por el alcalde, notificar a referente y admin del módulo (external process resource).
- [X] Habilitar filtros por tipo de proceso, programa, periodo, comuna, año (procesos)


Revisión 16-01-2025
- [X] Corregir error en generación de siguiente proceso
- [X] Revisar plantilla porque no aparecen las cuotas.
- [X] En la distribución poner los correos de las comunas y referente automáticamente.
- [X] Adjuntar archivos en los procesos.
- [X] La notificacion de aprobacion de juridico debe llegarle al referente del programa.
- [X] En municipalidades, en alcaldes, agregar en la tabla el decreto
- [X] Editar tipo de proceso: quitar boton borrar
- [X] Envio de correo automatico a la comuna.
- [ ] Revisar que hacer con las cuotas en los convenios de 12 cuotas (SAPU)
- [X] Implementar en Editar un Proceso el boton "agregar visación"
- [X] Diferencias circuito de apobación de resoluciones vs convenios
- [X] En la sección firma director, implementar botón descargar (pra descargar convenio firmado)
- [X] Se debe refrescar el content una vez se guarde o modifique el proceso.
- [X] Implementar switch "Activo" en el Tipo de Proceso
- [X] Notificar cuando el convenio fue firmado por la directora a referente y admins


lunes 10am reunión (corrovorar a referentes comunales).-

- [X] Una visaciónes de CDP del Referente Tecnico y firma es de el Departamento de Gestión Financiera
- [X] Notificar: cuando esté finalizado a los admin del modulo

- [X] Certificados, una vez firmados, poner boton de descarga.
- [+] Revisar que pasó con el caso de huara.
- [X] Mostrar los establecimientos en el documento.

- [X] Notificar cuando referente terminó de hacer el convenio
- [X] Cuando se fue a la comuna, ya no se puede editar
- [X] Mostrar si se reinició el proceso de firma, en comentario
- [X] Aprobación o comentarios por comuna.
- [X] Botón siguiente proceso en el index
- [X] Firma de directora con su propio circulo en el index
- [X] Indentificar que procesos van a la comuna para firma, para mostrar o no el cuadro
- [+] Poder cargar documento numerado de OF Partes, donde corresponda
- [X] Distribución queda al final (solo para reso)
- [X] Visaciones debajo de la distribución
- [X] En programa: Adjuntar archivos para ambas reso (Aprobatoria y Distribución de recursos)
- [X] En aprobaciones que se vean los adjuntos
- [X] Auto aprobar la visacion del referente
- [X] Certificado De no fraccionamiento y de rendiciones, se crea por convenio
- [X] Escoger no enviar a la comuna (caso observaciones de contraloría, ya que visto bueno de comuna es técnico y no jurídico)

- [X] Desbloquear listado de programas, filtrado por boolean is_program
- [X] Poblar tabla alcaldes (mayors)
- [X] En crear proceso filtrar por los que se puede empezar
- [X] En crear proceso filtrar por los programas del periodo seleccionado en el campo anterior
- [X] Correr la migracion de process
- [X] Estado, desabilitar los botones, buscar otro lugar para poner el estado
- [X] Crear Proceso - Crear documento del proceso en la misma ventana
- [X] Crear Proceso - Solicitar visado
- [X] Crear Proceso - Eliminar visado
- [X] Action crear siguiente proceso
- [X] Mostrar las aprobaciones (etapa en la que va)
- [X] Una vez estado es "enviado a visación bloquear los campos o mostrar un view"
- [X] Traducir boton en relation manager de crear componentes
- [X] Crear vista del process para poder mostrar el documento y para las aprobaciones
- [X] Crear Proceso - Auto calcular las cuotas
- [X] Crear Proceso - Comentarios dejar fijos los que ya se ingresaron
- [X] Mostrar vinculo al siguiente proceso
- [X] Poblar approval flow
- [X] Agregar archivo adjunto, resolución firmada por alcalde
- [ ] Mostrar una sección con datos del programa como sus resoluciones, componentes y referentes (mejora que podría ser útil)
- [X] Parametrizar abogado // Permiso Legally
- [*] Permitir edición abogado // cambiado a no permitir, solo dejar comentarios
- [X] Agregar otros archivos adjunto
- [X] Eliminar document_id
- [X] Approvals permitir poner vizaciones
- [X] Auto solicitar firma de directora despues de la visación (no hacer porque depende del flujo)
- [X] Agregar descargar documento firmado por directora
- [X] Comentario marcar como del sistema
- [X] Eliminar boton para borrar en masa


- [X] Corregir busqueda por nombre en asociar un referente
- [X] Poblar programas 2025


## Tareas al finalizar
[ ] Eliminar tabla munipalities
[ ] Eliminar tabla components de agreements


- Previsualizar plantilla
- Mostrar el CDP
- CDP por establecimiento y subtitulo

- ¿Los componentes de programas tienen los subtitulos?
- ¿la distribucion de presupuesto es una por cdp o una por programa?
- programa de anticipo de aporte estatal, cuotas diferentes a los demás? 20.919 id:1148


Visadores de convenios y addendum 
1. Referente
2. Jurídica
3. Directora APS
4. Subdirector gestión asistencial 
5. Departamento de gestión financiera 


Para visaciones de Resolución son:
1. Referente
2. Jefe directo de Referente (aun no lo dejan claro, naty debe decidir)
3. Jurídica 
4. Directora APS 
5. Subdirector de gestión asistencial 
6. Subdirectora de administrativo


El sistema no hará:
- Paginas horizontales y verticales

Tablas

Dependencia:
- cfg_programs
- cfg_program_components
- cfg_municipalities
- cfg_alcaldes


Modulo
- agr_signers
- agr_process_types
- agr_process

- Mantener - agr_signers
- NPI      - agr_stages
- Evaluar  - agr_programs

- agr_amounts             -> agr_amounts2
- agr_quotas2             -> agr_quotas2

- agr_addendums              -> agr_processes
- agr_agreements             -> agr_processes
- agr_continuity_resolutions -> agr_processes 
- agr_program_resolutions    -> agr_processes

- Eliminar - agr_budget_availability
- Eliminar - agr_accountabilities
- Eliminar - agr_accountabiltiy_dtails
- Migrar y Eliminar - agr_program_components


Procesos de convenios, son 5
 Convenio nuevo
   - modificación
   - prorrogas
   - resoluciones de continuidad

Formatos:
 1. Convenio de ejecución
 2. Reso Aprobatoria de Convenio de ejecución
 3. Convenio de ejecución afecto
 4. Reso Aprobatoria de Convenio Afecta
 5. Reso de Primera Prórroga (Continuidad)
 6. Reso de Segunda Prórroga (Doble continuidad)
 7. Reso Sub 21
 8. Reso Sub 22
 9. Adendum
10. Reso Adendum
11. Reso modificatorias (de cualquier reso)
12. Reso modificatoria de Prórroga


Reunión Lupa:
- No aparece nuevo addendum si no está terminado la resolución del convenio
- Ley 20.919 es diferente en la cuotas
- Dejar de trabajar con word
- Caso hoja horizontal
- Municipalidad y sus subrogantes y alcaldes


Dificultades actuales:
- Descargas en Word
- Formato con el editor de documentos
- Dificultades en dos áreas
  - Cambios de formato Jurídicos
  - 

### Requerimientos 1ra Reunión:
====================================================

La plataforma si permite hacer la 21 y 22. 
Se puede generar una resolución de los convenios en otra opción. (Natalia)

- Resolución y convenios en una misma pantalla.
- Plataforma que sea interacción con las comunas.
- Subir documentos, descargar documentos.
- Trabajar en el visto bueno de la comuna. (como hacer para dos cambios al mismo tiempo, comuna y sst)
- Seguimiento del proceso del convenio. (ej 3 meses)
- No tanta pestaña
- No reutilizar el sistema anterior
- Flexibilidad en los formatos, poder incorporar nuevos formatos

Primer hito (adjuntar) con fecha de anexamiento 
- Resolución aprobatoria del programa
- Resolución de distribución de recursos del programa

Articulado 
Subtitulo 24 presupuesto de las municipalidades (casi todo tiene el 24)

### Certificados. Solo para convenios nuevos (todo lo que vaya a contraloría)
- CDP (Finanzas)
- Certificado de rendiciones (Finanzas) Requiere ingreso de información
- Certificado de no fraccionamiento (Finanzas) Tenemos los datos

(40 días corridos COMGES)

Convenios con comunas y sub 21 y 22.
- Convenio nuevo (Sub 24 tranf a terceros)
- Resolución de prorroga de convenio
- Reso sub 21 (programas -> nueva resolución) (no pasa por la comuna)
- Reso sub 22 (No pasa por la comuna)

Resolución modificatoria

- Monto por componente
- Calculo automático de valor de las cuotas
- Previsualizar el convenio.
- Modificar y terminarlo y referente indicar que está listo para revisón de la comuna (marca de tiempo)
- Comuna, debería ingresar y realizar el visto bueno u observaciones, rechazado, etc. Aquí viene un pinponeo entre ellos. 
- Mandar a visar el convenio. (mostrar firmas)
- Firma alcalde
- Firma directora (doc digital)

- Avanzar con la resolución.
- Toda se gestiona a través de DocDigital.

- Oficina de partes, numeración resolución (descartado, lo hará por DocDigital y no por el módulo de convenios).
- Resolución Final se va a la dipres. (ingresar fecha de carga a dipres)
- Un mismo programa tiene distribuido los montos por item, podría salir un convenio y resoluciones de 21 y 22
- en el seguimiento puede ser comuna o establecimiento, con eso se sabe si es sub 21 o 22 para el caso de establecimiento.


### Prorrogas
- (Resolución de prorroga) No lleva firma del alcalde
- Cargar los dos primeros hitos.
- Base en el ultimo convenio.

- ¿Qué pasa cuando supera las 5.000 UTM para las prorrogas?
- Resolución modificatoria para resolución de prorroga
- Modificación de convenio, adendum.
- Adendum tiene el mismo flujo de un convenio
- Descargar Excel de seguimiento.
- Informe de las platas (Ej, cuanto plata se le entregó a Pica por programa)
- Finanzas incorporar transferencias realizadas.

- Fecha de partida: Enero 2025.

Perfiles. (Comuna, Referente, Admin de convenios (eliminar))
Alertas de que necesitan realizar una acción

Distribución local
------------
Planear distribución local que es igual al CDP.
La distribución local debe ser ingresada en algún lugar, y que luego
Revisión de Natalia respecto de la distribución.
Justificación técnica si es monto de ejecución es menor.





---
# Honorarios Firma digital
- Funcionario tiene que logearse
- Sus contratos y presiona aceptar (timestamp, status = firmado) Include firma clave única

   -> Approval COPIA del PDF
   -> Bloquear para no edición y mostrar que ya fue firmado por el funcionario


- Firma directora (Firma Avanzada)
   -> $approval->callback 
	-> Envíar el pdf al funcionario


- Subir la reso 


¿La directora va a firmar digitalmente los contratos?

- Visaciones
- Enviar firma del funcionario (se fija el documento)
- 