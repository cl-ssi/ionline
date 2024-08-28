<?php

namespace App\Console\Commands;

use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Console\Command;

class SirhOus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sirh:ous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $unidades = [
            ['cod' => 1251000, 'name' => 'DIRECCIÓN DE SERVICIO'],
            ['cod' => 1251001, 'name' => 'UNIDAD SECRETARÍA Y OFICINA DE PARTES'],
            ['cod' => 1251002, 'name' => 'U. DE RELACIÓN ASISTENCIAL DOCENTE R.A.D'],
            ['cod' => 1251003, 'name' => 'CONSEJOS CONSULTIVOS'],
            ['cod' => 1251004, 'name' => 'U. GEST. DEL RIESGO EN EMERG. Y DESASTRE'],
            ['cod' => 1251005, 'name' => 'OFICINA DE PARTES'],
            ['cod' => 1251006, 'name' => 'GENERO'],
            ['cod' => 1251010, 'name' => 'DEPARTAMENTO RELACIONES INSTITUCIONALES'],
            ['cod' => 1251100, 'name' => 'DEPARTAMENTO AUDITORIA INTERNA'],
            ['cod' => 1251200, 'name' => 'DEPTO. ASESORIA JURIDICA'],
            ['cod' => 1251210, 'name' => 'UNIDAD DE DROGAS'],
            ['cod' => 1251300, 'name' => 'COMUNICACIONES'],
            ['cod' => 1251400, 'name' => 'DEPTO. PLANIF. Y CONTROL DE GESTIÓN'],
            ['cod' => 1251500, 'name' => 'DPTO. DE ESTADÍSTICA Y GESTIÓN DE LA INF'],
            ['cod' => 1251600, 'name' => 'DEPTO DE TEC.DE LA INFO.Y COMUNICACIONES'],
            ['cod' => 1251601, 'name' => 'HOSPITAL ALTO HOSPICIO'],
            ['cod' => 1251700, 'name' => 'DEPTO. P. SOCIAL G. AL USUARIO Y GOB.'],
            ['cod' => 1251701, 'name' => 'UNIDAD DE GESTION AL USUARIO'],
            ['cod' => 1251702, 'name' => 'UNIDAD DE PARTICIPACION SOCIAL'],
            ['cod' => 1251703, 'name' => 'OFICINA DE INFO RECLAMOS Y SUG O.I.R.S'],
            ['cod' => 1251800, 'name' => 'UNIDAD SECRETARIA Y OFICINA DE PARTES'],
            ['cod' => 1251900, 'name' => 'DEPARTAMENTO DE GABINETE'],
            ['cod' => 1252000, 'name' => 'SUBDIRECCION DE GESTION Y D. DE PERSONAS'],
            ['cod' => 1252010, 'name' => 'SECRETARIA SDGDP'],
            ['cod' => 1252020, 'name' => 'PLANIFICACION Y CTROL DE GESTION DE RRHH'],
            ['cod' => 1252100, 'name' => 'SECRETARIA SUBDIRECCIÓN RRHH'],
            ['cod' => 1252110, 'name' => 'UNIDAD PERSONAL Y CICLO DE VIDA LABORAL'],
            ['cod' => 1252120, 'name' => 'UNIDAD DE CAPACITACION Y FORMACION'],
            ['cod' => 1252210, 'name' => 'UNIDAD DE BIENESTAR'],
            ['cod' => 1252211, 'name' => 'SERVICIO DE BIENESTAR'],
            ['cod' => 1252220, 'name' => 'UNIDAD DE APOYO SOCIAL DEL PERSONAL'],
            ['cod' => 1252230, 'name' => 'UNIDAD DE CLIMA LABORAL'],
            ['cod' => 1252240, 'name' => 'UNIDAD DE SALUD DEL TRABAJADOR'],
            ['cod' => 1252300, 'name' => 'DEPTO. GESTIÓN DE RECURSOS HUMANOS'],
            ['cod' => 1252310, 'name' => 'U. RECLUTAMIENTO Y SELECCIÓN DE PERSONAS'],
            ['cod' => 1252311, 'name' => 'UNIDAD DE IDONEIDAD'],
            ['cod' => 1252320, 'name' => 'UNIDAD DE GESTIÓN DE PERSONAL Y CICLO DE'],
            ['cod' => 1252330, 'name' => 'UNIDAD DE REMUNERACIONES'],
            ['cod' => 1252400, 'name' => 'DEPTO. DESARROLLO Y GESTION DEL TALENTO'],
            ['cod' => 1252410, 'name' => 'UNIDAD DE FORMACION'],
            ['cod' => 1252500, 'name' => 'DEPTO. DE CALIDAD DE VIDA LABORAL'],
            ['cod' => 1252520, 'name' => 'RELACIONADOR LABORAL'],
            ['cod' => 1252530, 'name' => 'UNIDAD DE APOYO PSICOSOCIAL'],
            ['cod' => 1252540, 'name' => 'UNIDAD DE CUIDADOS INFANTILES'],
            ['cod' => 1252600, 'name' => 'DEPTO. SALUD OCUPACIONAL'],
            ['cod' => 1252601, 'name' => 'DEPTO DE SEGURIDAD SALUD OCUPACIONAL Y G'],
            ['cod' => 1252610, 'name' => 'UNIDAD DE PREVENCIÓN DE RIESGOS'],
            ['cod' => 1252620, 'name' => 'UNIDAD SALUD OCUPACIONAL'],
            ['cod' => 1252621, 'name' => 'U. DE SALUD OCUPACIONAL Y SALUDABLEMENTE'],
            ['cod' => 1252630, 'name' => 'UNIDAD DE GESTION AMBIENTAL'],
            ['cod' => 1252631, 'name' => 'UNIDAD DE PREVENCION DE RIESGOS Y G. AMB'],
            ['cod' => 1252640, 'name' => 'FISCALIA'],
            ['cod' => 1253000, 'name' => 'SUBDIRECCION GESTION ASISTENCIAL'],
            ['cod' => 1253001, 'name' => 'SECRETARIA S. GESTIÓN ASISTENCIAL'],
            ['cod' => 1253002, 'name' => 'UNIDAD DE PUESTA EN MARCHA EN HOSPITALES'],
            ['cod' => 1253010, 'name' => 'SECRETARIA'],
            ['cod' => 1253020, 'name' => 'P.R.A.I.S.'],
            ['cod' => 1253100, 'name' => 'C.G.U. DR.HÉCTOR REYNO GUTIÉRREZ'],
            ['cod' => 1253101, 'name' => 'GESTIÓN ADMINISTRATIVA'],
            ['cod' => 1253110, 'name' => 'GEST. DE ESTABLECIMIENTOS Y DISPOSITIVOS'],
            ['cod' => 1253120, 'name' => 'UNIDAD GESTION ADM Y ORGANIZACIONAL'],
            ['cod' => 1253130, 'name' => 'UNIDAD GESTION PROCESOS CLINICOS INTEGRA'],
            ['cod' => 1253200, 'name' => 'DEPARTAMENTO DE REDES HOSPITALARIAS'],
            ['cod' => 1253201, 'name' => 'GESTION SERVICIO APOYO CLINICO Y LOGIST.'],
            ['cod' => 1253202, 'name' => 'UNIDAD DE GESTION DE DEMANDA'],
            ['cod' => 1253203, 'name' => 'GESTION DE PROCESOS CLINICOS INTEGRADOS'],
            ['cod' => 1253204, 'name' => 'UNIDAD DE GEST DE SERV CLINICOS DE APOYO'],
            ['cod' => 1253205, 'name' => 'UNIDAD DE PROCESOS CLINICOS INTEGRADOS'],
            ['cod' => 1253210, 'name' => 'LABORATORIO'],
            ['cod' => 1253217, 'name' => 'ASESOR MEDICO'],
            ['cod' => 1253218, 'name' => 'DEPARTAMENTO DE GESTION ODONTOLOGICA'],
            ['cod' => 1253219, 'name' => 'UNIDAD DE CALIDAD Y SEGURIDAD DEL PACIEN'],
            ['cod' => 1253220, 'name' => 'DEPARTAMENTO DE GESTION FARMACEUTICA'],
            ['cod' => 1253221, 'name' => 'DROGUERIA'],
            ['cod' => 1253222, 'name' => 'FARMACIA ASISTENCIAL'],
            ['cod' => 1253223, 'name' => 'IAAS'],
            ['cod' => 1253224, 'name' => 'CALIDAD'],
            ['cod' => 1253225, 'name' => 'DEPARTAMENTO DE INTEGRACION DIGITAL'],
            ['cod' => 1253226, 'name' => 'DEPARTAMENTO DE COODINACION TERRITORIAL'],
            ['cod' => 1253227, 'name' => 'DEPARTAMENTO DE ODONTOLOGIA'],
            ['cod' => 1253228, 'name' => 'UNIDAD DE SALUD DIGITAL'],
            ['cod' => 1253229, 'name' => 'DEPTO. CALIDAD Y SEGURIDAD DEL PACIENTE'],
            ['cod' => 1253230, 'name' => 'DEPTO. DISPOSITIVO RESIDENCIALES SALUD'],
            ['cod' => 1253231, 'name' => 'UNIDAD DE DISPOSITIVOS RESIDENC DE SALUD'],
            ['cod' => 1253240, 'name' => 'DEPARTAMENTO RED DE URGENCIAS'],
            ['cod' => 1253250, 'name' => 'GESTION HOSPITALARIA (PPV-PPI-LE-GES)'],
            ['cod' => 1253300, 'name' => 'DEPTO. DE GESTIÓN CLÍNICA'],
            ['cod' => 1253301, 'name' => 'SECRETARIA'],
            ['cod' => 1253310, 'name' => 'SERVICIO DE ATENCIÓN MÉDICO DE URGENCIA'],
            ['cod' => 1253320, 'name' => 'UNIDAD CICLO VITAL ADULTO Y SUBPROGRAMAS'],
            ['cod' => 1253330, 'name' => 'UNIDAD CICLO VITAL ADOLESCENTES'],
            ['cod' => 1253340, 'name' => 'UNIDAD CICLO VITAL DE LA MUJER Y SUBPROG'],
            ['cod' => 1253350, 'name' => 'UNIDAD CICLO VITAL DEL ADULTO MAYOR Y SU'],
            ['cod' => 1253360, 'name' => 'PROGRAMA REHABILITACION Y RESPIRATORIO'],
            ['cod' => 1253370, 'name' => 'PROGRAMA SALUD ORAL'],
            ['cod' => 1253380, 'name' => 'PROGRAMA SALUD RURAL'],
            ['cod' => 1253390, 'name' => 'PROGRAMA SALUD PUEBLOS INDIGENAS'],
            ['cod' => 1253400, 'name' => 'DEPTO. TIC E INFORMACIÓN EN SALUD'],
            ['cod' => 1253401, 'name' => 'SECRETARIA'],
            ['cod' => 1253410, 'name' => 'UNIDAD INFORMÁTICA Y TECNOLOGÍA'],
            ['cod' => 1253411, 'name' => 'INGENIERIA Y REDES'],
            ['cod' => 1253412, 'name' => 'SOPORTE'],
            ['cod' => 1253420, 'name' => 'UNIDAD GESTIÓN DE INFORMACIÓN EN SALUD'],
            ['cod' => 1253421, 'name' => 'PRODUCCION SIGGES'],
            ['cod' => 1253422, 'name' => 'DPTO. DE ESTADÍSTICA Y GESTIÓN DE LA INF'],
            ['cod' => 1253500, 'name' => 'DEPARTAMENTO DE RED DE SALUD MENTAL'],
            ['cod' => 1253501, 'name' => 'SECRETARIA DEPTO DE RED DE SALUD MENTAL'],
            ['cod' => 1253507, 'name' => 'CENTRO DIURNO CASA CLUB'],
            ['cod' => 1253508, 'name' => 'UNIDAD DE CENTROS Y DISPOSITIVOS'],
            ['cod' => 1253509, 'name' => 'U. GEST. MODELO ATENCION Y PROC CLINICOS'],
            ['cod' => 1253510, 'name' => 'G. DE ESTABLECIMIENTOS Y DISPOSITIVOS'],
            ['cod' => 1253520, 'name' => 'DEPARTAMENTO DE EPIDEMOLOGIA'],
            ['cod' => 1253530, 'name' => 'HOSPITAL DIURNO ADOLESCENTE'],
            ['cod' => 1253531, 'name' => 'HOSPITAL DIA INFANTO ADOLESCENTE'],
            ['cod' => 1253540, 'name' => 'UNIDAD DE GESTION Y CONTROL'],
            ['cod' => 1253550, 'name' => 'U.H.C.I.P.MP'],
            ['cod' => 1253551, 'name' => 'U.H.C.I.P. I.A'],
            ['cod' => 1253552, 'name' => 'U.H.C.I.P ADULTO HOSPITAL'],
            ['cod' => 1253560, 'name' => 'COSAM DR. SALVADOR ALLENDE'],
            ['cod' => 1253570, 'name' => 'COSAM DR. ENRIQUE PARIS'],
            ['cod' => 1253580, 'name' => 'COSAM DR. JORGE SEGUEL CACERES'],
            ['cod' => 1253600, 'name' => 'ASESORÍAS DE EMERGENCIAS Y DESASTRES'],
            ['cod' => 1253601, 'name' => 'SECRETARIA'],
            ['cod' => 1253602, 'name' => 'OF. INFORMACION, RECLAMOS Y SUGERENCIAS'],
            ['cod' => 1253610, 'name' => 'UNIDAD DE GESTION ADMIN Y ORGANIZACIONAL'],
            ['cod' => 1253620, 'name' => 'MODELO DE SALUD FAMILIAR'],
            ['cod' => 1253621, 'name' => 'DEPARTAMENTO MODELO DE SALUD FAMILIAR'],
            ['cod' => 1253630, 'name' => 'GESTION ADMINISTRATIVA Y FINANCIERA'],
            ['cod' => 1253631, 'name' => 'UNIDAD DE COORDINACION EN RED'],
            ['cod' => 1253700, 'name' => 'DEPARTAMENTO DE A.P.S.'],
            ['cod' => 1253701, 'name' => 'CESFAM GUZMAN'],
            ['cod' => 1253702, 'name' => 'CESFAM AGUIRRE'],
            ['cod' => 1253703, 'name' => 'CESFAM VIDELA'],
            ['cod' => 1253704, 'name' => 'CESFAM SUR'],
            ['cod' => 1253705, 'name' => 'CESFAM DR. PEDRO PULGAR'],
            ['cod' => 1253706, 'name' => 'CESFAM PICA'],
            ['cod' => 1253707, 'name' => 'CESFAM POZO ALMONTE'],
            ['cod' => 1253708, 'name' => 'CGR CAMIÑA-COLCHANE-HUARA'],
            ['cod' => 1253709, 'name' => 'PSR CHANAVAYITA-MOQUELLA'],
            ['cod' => 1253711, 'name' => 'DEPARTAMENTO ATENCION PRIMARIA Y REDES'],
            ['cod' => 1253712, 'name' => 'CESFAM DR. YANDRY AÑAZCO MONTERO'],
            ['cod' => 1253720, 'name' => 'UNIDAD DE PLANES Y PROGRAMAS'],
            ['cod' => 1253800, 'name' => 'P.E.S.P.I.'],
            ['cod' => 1253801, 'name' => 'P.E.S.P.I APS'],
            ['cod' => 1253900, 'name' => 'P.R.A.I.S.'],
            ['cod' => 1254000, 'name' => 'SUBDIRECCION DE RRFF Y FINANCIEROS'],
            ['cod' => 1254010, 'name' => 'SECRETARIA'],
            ['cod' => 1254020, 'name' => 'ENCARGADA GESTION DE PROYECTOS'],
            ['cod' => 1254100, 'name' => 'DEPTO GESTION FINANCIERA'],
            ['cod' => 1254109, 'name' => 'U PLANIF A. CTROL FINANCIERA Y PRESUPUES'],
            ['cod' => 1254110, 'name' => 'PLANIFICACION,  ANALISIS Y CTROL EQUIPOS'],
            ['cod' => 1254120, 'name' => 'S PLANIF ANALISIS Y CTROL INFRAESTRUCTUR'],
            ['cod' => 1254121, 'name' => 'UNIDAD DE PLANIF ANALISIS Y CTROL INFRAE'],
            ['cod' => 1254130, 'name' => 'S. GESTION Y CTROL DE PROCESOS ADMINISTR'],
            ['cod' => 1254131, 'name' => 'UNIDAD DE GESTION Y CTROL DE PROC ADMIN'],
            ['cod' => 1254140, 'name' => 'S. CONTROL DE MAQNTENIMIENTO DE LA RED'],
            ['cod' => 1254141, 'name' => 'UNIDAD DE CTROL DE MANTENIMIENTO DE LA R'],
            ['cod' => 1254200, 'name' => 'DEPARTAMENTO GESTIÓN DE PROYECTOS'],
            ['cod' => 1254210, 'name' => 'S. PLANIF. EJEC. Y CTROL. ABASTECIMIENTO'],
            ['cod' => 1254220, 'name' => 'SECCION DE SERVICIOS GENERALES'],
            ['cod' => 1254300, 'name' => 'DEPTO. FINANZAS Y CONTABILIDAD'],
            ['cod' => 1254310, 'name' => 'DEPTO. DE G. DE RRFF Y INVER. EN LA RED'],
            ['cod' => 1254320, 'name' => 'UNIDAD GESTIÓN DE COMPRAS'],
            ['cod' => 1254330, 'name' => 'UNIDAD GESTIÓN DE PRODUCCIÓN'],
            ['cod' => 1254340, 'name' => 'UNIDAD COBRANZA'],
            ['cod' => 1254350, 'name' => 'UNIDAD CONTABILIDAD'],
            ['cod' => 1254400, 'name' => 'DEPTO DE GESTIÓN ABAST. Y LOGÍSTICA'],
            ['cod' => 1254401, 'name' => 'DEPARTAMENTO DE ABASTECIMIENTO Y LOGISTI'],
            ['cod' => 1254408, 'name' => 'UNIDAD DE PLANIF DE EJEC Y CTROL DE ABAS'],
            ['cod' => 1254409, 'name' => 'U. EJECUCION Y CTROL ABASTEC OBRAS EQUIP'],
            ['cod' => 1254410, 'name' => 'UNIDAD DE SERVICIOS GENERALES'],
            ['cod' => 1254420, 'name' => 'UNIDAD DE ALMACENAMIENTO'],
            ['cod' => 1254430, 'name' => 'UNIDAD DE MOVILIZACION'],
            ['cod' => 1254500, 'name' => 'DEPTO. DE INVERSIONES Y PROYECTOS'],
            ['cod' => 1254510, 'name' => 'UNIDAD DE CONTROL DE GESTION'],
            ['cod' => 1254520, 'name' => 'UNIDAD DE INFRAESTRUCTURA'],
            ['cod' => 1254530, 'name' => 'UNIDAD DE EQUIPOS Y EQUIPAMIENTO'],
            ['cod' => 1254531, 'name' => 'UNIDAD DE PLANIF ANALISIS Y CTROL EQUIPO'],
            ['cod' => 1255000, 'name' => 'DIRECCION DE ATENCION PRIMARIA DE SALUD'],
            ['cod' => 1255001, 'name' => 'SECRETARIA DIRECCION APS'],
            ['cod' => 1255100, 'name' => 'GESTION CLINICA EN EL CURSO DE LA VIDA'],
            ['cod' => 1255101, 'name' => 'UNIDAD BODEGA APS'],
            ['cod' => 1255200, 'name' => 'DEPARTAMENTO DE GESTION ADMIN EN APS'],
            ['cod' => 1255201, 'name' => 'URGENCIA Y GESTION DE EMERGENCIAS Y DESA'],
            ['cod' => 1255300, 'name' => 'D. CALIDAD ACREDITACION Y PROYECTOS APS'],

            ['cod' => 1252200, 'name' => 'NO EXISTE LA UNIDAD'],
            ['cod' => 1253710, 'name' => 'NO EXISTE LA UNIDAD']
        ];

        $unidadesProcesadas = $this->procesarUnidades($unidades);
        // OrganizationalUnit::create($unidadesProcesadas);
        print_r($unidadesProcesadas);
        return Command::SUCCESS;
    }

    function procesarUnidades($unidades)
    {
        // Ordenar el arreglo por el campo 'cod'
        usort($unidades, function ($a, $b) {
            return $a['cod'] <=> $b['cod'];
        });

        // array solo con los codigos
        $codigos = array_column($unidades, 'cod');

        // Crear un índice por código para facilitar la búsqueda
        $indexPorCodigo = [];
        foreach ( $unidades as $unidad ) {
            $indexPorCodigo[$unidad['cod']] = $unidad['name'];
        }

        $unidadesProcesadas = [];

        foreach ( $unidades as $unidad ) {
            $cod = strval($unidad['cod']);  // Convertimos el código a string para manejarlo más fácilmente

            // Determinar el nivel y el código padre
            $nivel       = 0;
            $codigoPadre = null;
            $nombrePadre = "No existe";  // Valor por defecto si el padre no se encuentra

            if ( $cod[6] != '0' ) {
                $nivel       = 4;
                $codigoPadre = substr($cod, 0, 6) . '0';
            } elseif ( $cod[5] != '0' ) {
                $nivel       = 3;
                $codigoPadre = substr($cod, 0, 5) . '00';
            } elseif ( $cod[4] != '0' ) {
                $nivel       = 2;
                $codigoPadre = substr($cod, 0, 4) . '000';
            } elseif ( $cod[3] != '0' ) {
                $nivel       = 1;
                $codigoPadre = substr($cod, 0, 3) . '0000';
            } else {
                $nivel       = 0;
                $codigoPadre = null; // No tiene padre, es una unidad de nivel superior
            }

            // Verificar si el código padre existe en el arreglo original
            if ( $codigoPadre && !isset($indexPorCodigo[$codigoPadre]) ) {
                // Agregar al arreglo si el padre no existe
                $unidadesProcesadas[] = [
                    'cod'          => $codigoPadre,
                    'name'         => $nombrePadre,
                    'nivel'        => $nivel - 1,
                    'codigo_padre' => null
                ];
                // Actualizar el índice para incluir este nuevo "padre"
                $indexPorCodigo[$codigoPadre] = $nombrePadre;
            } elseif ( $codigoPadre ) {
                $nombrePadre = $indexPorCodigo[$codigoPadre];
            }

            if ( !in_array($codigoPadre, $codigos) ) {
                // $this->createOusInexistentes($codigoPadre, $codigos);
                // OrganizationalUnit::create([
                //     'id'           => $codigoPadre,
                //     'name'         => 'No existe',
                //     'nivel'        => $nivel-1,
                //     'organizational_unit_id' => $codigoPadre
                // ]);
            }
            OrganizationalUnit::updateOrCreate(
                ['id' => $unidad['cod']],
                [
                    'id'                     => $unidad['cod'],
                    'name'                   => $unidad['name'],
                    'level'                  => $nivel,
                    'organizational_unit_id' => $codigoPadre,
                    'establishment_id'       => 39,
                    'sirh_ou_id'             => $unidad['cod'],
                ]
            );
        }

        return $unidadesProcesadas;
    }

    public function createOusInexistentes($cod, $codigos)
    {
        $cod = strval($cod);
        if ( $cod[6] != '0' ) {
            $nivel       = 4;
            $codigoPadre = substr($cod, 0, 6) . '0';
        } elseif ( $cod[5] != '0' ) {
            $nivel       = 3;
            $codigoPadre = substr($cod, 0, 5) . '00';
        } elseif ( $cod[4] != '0' ) {
            $nivel       = 2;
            $codigoPadre = substr($cod, 0, 4) . '000';
        } elseif ( $cod[3] != '0' ) {
            $nivel       = 1;
            $codigoPadre = substr($cod, 0, 3) . '0000';
        } else {
            $nivel       = 0;
            $codigoPadre = null; // No tiene padre, es una unidad de nivel superior
        }

        if ( !in_array($codigoPadre, $codigos) ) {

            return $this->createOusInexistentes($codigoPadre, $codigos);

        } else {
            OrganizationalUnit::create([
                'id'           => $cod,
                'name'         => 'No existe',
                'cod'          => $cod,
                'nivel'        => $nivel,
                'codigo_padre' => $codigoPadre
            ]);
        }
    }

}
