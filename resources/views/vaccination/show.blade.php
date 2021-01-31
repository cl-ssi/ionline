@extends('layouts.app')

@section('title', 'Horario de vacuna')

@section('content')
<h5 class="mb-3">Horario Vacunación</h5>

@if(empty($vaccination))

<h2>No está registrado en la nómina de vacunación, por favor contactar a su jefe directo.</h2>

@else
    <p>Hola {{ $vaccination->fullName() }} la primera dósis de la
    <strong>VACUNA CORONAVAC LABORATORIO SINOVAC LIFE SCIENCE®</strong> contra
    <strong>CONTRA SARS-COV-2</strong> te toca el día
    <strong>{{ $vaccination->first_dose }}</strong>
</p>


<ul>
    <li>EL lugar de vacunación es el domo en el estacionamiento atrás del HETG</li>
    <li>Debes considerar que posterior a la vacunación debes quedarte 30 minutos en el lugar para observación post vacunación.</li>
    <li>De presentar  una reacción post vacunación leve a moderada, preséntate en el lugar de vacunación con el Enfermera de Salud del trabajador para tu notificación al ISP y seguimiento por parte de la unidad de salud del trabajador.  Si es algo importante dirigente a un sistema de urgencia.</li>
    <li>Si el día y hora asignado te traen dificultades toma contacto con tu
        jefatura o supervisor/a de servicio</li>
</ul>


@endif
<hr>

<h4>I. CARACTERÍSTICAS DE LA VACUNA:</h4>
<h5>1. Descripción de la vacuna</h5>
<p>
CoronaVac es una vacuna de virus inactivado, derivada de la cepa CZ02 de coronavirus. Este virus es
cultivado en células renales de mono verde africano (Células Vero), posteriormente cosechado, inactivado
para evitar su replicación, concentrado, purificado y adsorbido con hidróxido de aluminio que actúa como
un agente adyuvante, el cual estimula la respuesta inmune. (1)
</p>

<h5>2. Ensayos clínicos (2)</h5>
<p>
CoronaVac es una vacuna candidata inactivada contra COVID-19 que ha demostrado una buena
inmunogenicidad en ratones, ratas y primates no humanos con anticuerpos neutralizantes inducidos por la
vacuna contra el SARS-CoV-2, que podrían neutralizar diez cepas representativas de SARS-CoV-2.
</p>
<p>
Además, los resultados indicaron que CoronaVac proporcionó protección parcial o completa en macacos de
la neumonía intersticial grave después de una exposición al SARS-CoV-2, sin un aumento de la infección
dependiente de anticuerpos observable, lo que respalda la progresión a ensayos clínicos en humanos.
</p>
<p>
En el ensayo clínico de fase 1/2, de un solo centro, doble ciego, aleatorizado, controlado con placebo, se
reclutó a participantes de la comunidad para evaluar dos regímenes de dos dosis de CoronaVac. El ensayo
de fase 1 fue un estudio de aumento de dosis. En la fase 1, los participantes fueron reclutados y asignados
secuencialmente (1: 1), sin asignación al azar específica, a uno de dos esquemas de vacunación, con un
intervalo de 14 días (cohorte de vacunación 0 y 14) o un intervalo de 28 días. (Cohorte de vacunación
0 y 28) entre dosis. Dentro de cada cohorte, los primeros 36 participantes (bloque 1) fueron asignados
aleatoriamente a la vacuna de dosis baja o al placebo, y después de 7 días de seguimiento por seguridad
de la primera dosis otros 36 (bloque 2) fueron asignados aleatoriamente a vacunas de dosis alta o placebo.
La fase 2 se inició después de que todos los participantes de la fase 1 hubieran terminado un período de
observación de seguridad de 7 días después de la primera dosis. Como en la fase 1, los participantes fueron
reclutados y asignados (1:1) sin asignación al azar específica a una de las dos cohortes del programa de
vacunación, y luego asignados al azar dentro de cada cohorte a vacuna de dosis baja, vacuna de dosis alta
o placebo.
</p>
<p>
Los participantes eran elegibles si estaban sanos y tenían entre 18 y 59 años. Los criterios de exclusión clave
fueron antecedentes epidemiológicos de alto riesgo dentro de los 14 días anteriores a la inscripción (p. Ej.,
Antecedentes de viajes o residencia en la ciudad de Wuhan y áreas circundantes u otras comunidades con
informes de casos; historial de contacto con alguien infectado con SARS-CoV-2); IgG o IgM específicas de
SARS-CoV-2 positivas en suero; prueba de PCR positiva para el SARS-CoV-2 de una muestra de frotis anal
o faríngea; temperatura axilar superior a 37,0 ° C; y alergia conocida a cualquier componente de la vacuna.
</p>

<h5>3. Indicación</h5>
<p>
La vacuna está indicada para la prevención de la enfermedad causada por el virus SARS-CoV-2 en personas
desde los 18 años.
</p>

<h5>4. Composición</h5>
Cada dosis de 0,5 mL contiene 600 SU de virus SARS-CoV-2 inactivado como antígeno
<ul>
    <li>-Principio activo:</li>
    <ul>
        <li>* Virus SARS-CoV-2 inactivado.</li>
    </ul>

    <li>- Excipientes:</li>
    <ul>
        <li>* Hidróxido de aluminio</li>
        <li>* Hidrogenofosfato de disodio</li>
        <li>* Dihidrogenofosfato de sodio</li>
        <li>* Cloruro de sodio</li>
        <li>* Este producto no contiene conservantes</li>
    </ul>
</ul>

<h5>5. Forma farmacéutica</h5>
<p>
Vial monodosis
</p>

<h5>6. Dosificación</h5>
<p>
La vacuna “CoronaVac” se administra por vía intramuscular en un esquema de dos dosis (0,5 mL cada una)
con 4 semanas de diferencia (0, 28 días).
</p>
<p>
No hay datos disponibles sobre la intercambiabilidad de la vacuna “CoronaVac” con otras vacunas COVID-19
para completar el esquema de vacunación.
</p>

<h5>7. Preparación</h5>
<ul>
    <li>- Agite bien antes de usar.</li>
    <li>- No lo use si el frasco de la vacuna está roto, mal rotulado o es ineficaz, o si hay un material extraño
    en el frasco de la vacuna.</li>
    <li>- No combine con otras vacunas en la misma jeringa.</li>
    <li>- No congele este producto.</li>
    <li>- La vacuna debe usarse inmediatamente después de abierta.</li>
</ul>

<h5>8. Apariencia física</h5>
<p>
La vacuna es una suspensión opalescente o blanco lechoso, se puede formar un precipitado estratificado
que se puede dispersar mediante agitación.
</p>

<h5>9. Vía administración</h5>
<p>
Intramuscular. No administrar por vía intravascular.
</p>

<h5>10. Presentación</h5>
<p>
Vial monodosis. Cada envase secundario contiene 40 viales.
</p>

<h5>11. Interacción con otros medicamentos</h5>
<p>
Administración concomitante con otras vacunas: No se han realizado estudios clínicos sobre el efecto (pre,
post o simultaneo) de otras vacunas sobre la inmunogenicidad de Coronavac. No existe información disponible
para evaluar el efecto de la administración simultánea de Coronavac con otras vacunas.
</p>
<p>
Fármacos inmunosupresores: anticuerpos monoclonales, quimioterapia, antimetabolitos, agentes alquilantes,
fármacos citotóxicos, corticoides, etc., pueden reducir la respuesta inmune del organismo a esta vacuna.
</p>
<p>
Pacientes que están recibiendo tratamiento: para aquellos pacientes que están utilizando fármacos, se
recomienda consultar a su médico antes de recibir la vacuna, para evitar posibles interacciones.
</p>

<h5>12. Contraindicaciones</h5>
<p>
No administrar en:
<ul>
    <li>- Personas con antecedentes conocidos de alergia a cualquier componente de esta vacuna.</li>
    <li>- Pacientes febriles que cursen con una enfermedad aguda o que sufran un cuadro agudo producto de
    sus enfermedades crónicas (vacunar al resolver cuadro agudo).</li>
</ul>

</p>

<h5>13. Precauciones</h5>
<p>
Bajo ciertas circunstancias, el uso de esta vacuna debe ser cuidadosamente utilizada:
<ul>
    <li>- La inyección intramuscular de esta vacuna en pacientes con trombocitopenia o trastornos
    hemorrágicos, puede causar hemorragia.</li>
    <li>- La respuesta inmune de la vacuna puede verse reducida en pacientes que han recibido terapia
    inmunosupresora o que tengan inmunodeficiencia. La vacunación debe aplazarse hasta el término
    del tratamiento y se debe asegurar que los pacientes están bien protegidos para minimizar la
    probabilidad de contagio. La vacunación debe recomendarse para pacientes con deficiencia inmune
    crónica, aun cuando su enfermedad de base pueda limitar la respuesta inmunológica.</li>
    <li>- En pacientes con epilepsia no controlada u otros trastornos neurológicos, como Síndrome de
    Guillain-Barre.</li>
</ul>

Ficha vacuna contra SARS-COV-2 vacuna Coronavac laboratorio Sinovac Life Science® 6
Como cualquier vacuna, la inmunización con este producto puede no proteger al 100% de los individuos.
</p>


<h5>14. Reacciones adversas</h5>
<p>
A continuación, se describen los ESAVI que han sido observados durante la comercialización de otras
vacunas de virus inactivados:
<ul>
    <li>- Linfadenopatía local en el sitio de inyección.</li>
    <li>- Reacciones alérgicas causadas por cualquiera de los componentes de la vacuna: ronchas,
    erupciones alérgicas y púrpura, shock anafiláctico.</li>
    <li>- Convulsiones (con o sin fiebre).</li>
</ul>


Aunque las reacciones mencionadas no han sido observadas en estudios pre-comercialización, sigue siendo
necesaria que sean tomadas en cuenta durante el uso de esta vacuna. En caso de cualquier malestar no
mencionado arriba, contacte a su médico inmediatamente.
</p>
<p>
En los ensayos clínicos de fase 2 la incidencia de reacciones adversas fue de un 35% para el esquema 0,14
días y de un 19% en el de 0,28 días. La reacción adversa más común fue dolor en el sitio de punción, con
una incidencia de 26% (esquema 0,14 días) y 11% (esquema 0,28 días).2
</p>
<p>
La mayoría de las reacciones adversas fueron moderadas y los pacientes se recuperaron en 48 horas. No
hubo ninguna reacción adversa grave relacionada a la vacuna después de 28 días desde la administración
de la segunda dosis 2.
</p>

<h5>15. Condiciones de almacenamiento</h5>
<ul>
    <li>Almacenar entre +2°C y +8°C.</li>
    <li>Proteger de la luz.</li>
    <li>No congelar.</li>
</ul>

<h3>II. BIBLIOGRAFÍA</h3>
<ol>
    <li>Folleto al profesional “CoronaVac”. Laboratorio Sinovac Life Sciences.</li>
    <li>Zhang, Y. et al. Safety, tolerability, and immunogenicity of an inactivated SARS-CoV-2 vaccine in healthy
    adults aged 18–59 years: a randomised, double-blind, placebo-controlled, phase 1/2 clinical trial. Lancet
    Infect. Dis. https://doi.org/10.1016/S1473-3099(20)30843-4 (2020).</li>
</ol>


@endsection

@section('custom_js')

@endsection
