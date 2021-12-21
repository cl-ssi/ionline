<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\BudgetItem;

class BudgetItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BudgetItem::Create(['code'=>'2201','name'=>'Alimentos y Bebidas']);
        BudgetItem::Create(['code'=>'2201001','name'=>'Para Personas']);
        BudgetItem::Create(['code'=>'2201001001','name'=>'Pacientes']);
        BudgetItem::Create(['code'=>'2201001002','name'=>'Funcionarios']);
        BudgetItem::Create(['code'=>'2201001003','name'=>'Capacitación']);
        BudgetItem::Create(['code'=>'2202','name'=>'Textiles, Vestuario y Calzado']);
        BudgetItem::Create(['code'=>'2202001','name'=>'Textiles y Acabados Textiles']);
        BudgetItem::Create(['code'=>'2202002','name'=>'Vestuario, Accesorios y Prendas Diversas']);
        BudgetItem::Create(['code'=>'2202002001','name'=>'Vest Y Acces P Diversas Para El Personal']);
        BudgetItem::Create(['code'=>'2202002002','name'=>'Otros Textiles Act Hospitalaria']);
        BudgetItem::Create(['code'=>'2202003','name'=>'Calzado']);
        BudgetItem::Create(['code'=>'2203','name'=>'Combustibles y Lubricantes']);
        BudgetItem::Create(['code'=>'2203001','name'=>'Para Vehículos']);
        BudgetItem::Create(['code'=>'2203002','name'=>'Para Maquinarias, Equipos de Producción, Tracción y Elevación']);
        BudgetItem::Create(['code'=>'2203003','name'=>'Para Calefacción']);
        BudgetItem::Create(['code'=>'2203999','name'=>'Para Otros']);
        BudgetItem::Create(['code'=>'2204','name'=>'Materiales de Uso o Consumo']);
        BudgetItem::Create(['code'=>'2204001','name'=>'Materiales de Oficina']);
        BudgetItem::Create(['code'=>'2204002','name'=>'Textos y Otros Materiales de Enseñanza']);
        BudgetItem::Create(['code'=>'2204003','name'=>'Productos Químicos']);
        BudgetItem::Create(['code'=>'2204003001','name'=>'Oxigeno Y Gases Clínicos']);
        BudgetItem::Create(['code'=>'2204003002','name'=>'Otros Químicos']);
        BudgetItem::Create(['code'=>'2204004','name'=>'Productos Farmacéuticos']);
        BudgetItem::Create(['code'=>'2204004001','name'=>'Farmacia']);
        BudgetItem::Create(['code'=>'220400400101','name'=>'Farmacia - Compras Intermediadas']);
        BudgetItem::Create(['code'=>'220400400102','name'=>'Farmacia - Compras Extra Sistema']);
        BudgetItem::Create(['code'=>'2204004002','name'=>'Prod Para Cirugia Dental ']);
        BudgetItem::Create(['code'=>'2204004003','name'=>'Materiales De Curación']);
        BudgetItem::Create(['code'=>'2204004004','name'=>'Prótesis']);
        BudgetItem::Create(['code'=>'2204004005','name'=>'Productos Para Mecánica Dental']);
        BudgetItem::Create(['code'=>'2204004006','name'=>'Ayudas Tecnicas - Ortesis ']);
        BudgetItem::Create(['code'=>'2204005','name'=>'Materiales y Útiles Quirúrgicos']);
        BudgetItem::Create(['code'=>'2204005001','name'=>'Instrumental Quirúrgico']);
        BudgetItem::Create(['code'=>'2204005002','name'=>'Material de Laboratorio']);

                    // 2204005003 Otros Insumos clínicos
                    // 2204006 Fertilizantes, Insecticidas, Fungicidas y Otros
                    // 2204007 Materiales y Útiles de Aseo
                    // 2204007001 Lavanderia
                    // 2204007002 Otros Materiales Y Utiles De Aseo
                    // 2204008 Menaje para Oficina, Casino y Otros
                    // 2204009 Insumos, Repuestos y Accesorios Computacionales
                    // 2204010 Materiales para Mantenimiento y Reparaciones de Inmuebles
                    // 2204011 Repuestos y Accesorios para Mantenimiento y Reparaciones de Vehiculos
                    // 2204012 Otros Materiales, Repuestos y Útiles Diversos para Mantenimiento y Reparaciones
                    // 2204013 Equipos Menores
                    // 2204014 Productos Elaborados de Cuero, Caucho y Plásticos
                    // 2204015 Productos Agropecuarios y Forestales
                    // 2204999 Otros
                    // 2205 Servicios Básicos
                    // 2205001 Electricidad
                    // 2205002 Agua
                    // 2205003 Gas
                    // 2205004 Correo
                    // 2205005 Telefonía Fija
                    // 2205006 Telefonía Celular
                    // 2205007 Acceso a Internet
                    // 2205008 Enlaces de Telecomunicaciones
                    // 2205999 Otros
                    // 2206 Mantenimiento y Reparaciones
                    // 2206001 Mantenimiento y Reparación de Edificaciones
                    // 2206002 Mantenimiento y Reparación de Vehículos
                    // 2206003 Mantenimiento y Reparación de Mobiliarios y Otros
                    // 2206004 Mantenimiento y Reparación de Máquinas y Equipos de Oficina
                    // 2206005 Mantenimiento y Reparaciones de Maquinarias y Equipos de Producción
                    // 2206006 Mantenimiento y Reparación de Otras Maquinarias y Equipos
                    // 2206006001 Mantenimiento Y Reparación Maquina Y Equipo Preventivo
                    // 2206006002 Mantenimiento Y Reparación Maquina Y Equipo Correctivo
                    // 2206007 Mantenimiento y Reparación de Equipos Informáticos
                    // 2206999 Otros
                    // 2207 Publicidad y Difusión
                    // 2207001 Servicios de Publicidad
                    // 2207002 Servicios de Impresión
                    // 2207003 Servicios de Encuadernación y Empaste
                    // 2207999 Otros
                    // 2208 Servicios Generales
                    // 2208001 Servicios de Aseo
                    // 2208002 Servicios de Vigilancia
                    // 2208003 Servicios de Mantención de Jardines
                    // 2208007 Pasajes, Fletes y Bodegajes
                    // 2208008 Salas Cunas y/o Jardines Infantiles
                    // 2208009 Servicios de Pago y Cobranza
                    // 2208010 Servicios de Suscripción y Similares
                    // 2208999 Otros
                    // 2209 Arriendos
                    // 2209001 Arriendo de Terrenos
                    // 2209002 Arriendo de Edificios
                    // 2209003 Arriendo de Vehículos
                    // 2209004 Arriendo de Mobiliario y Otros
                    // 2209005 Arriendo de Máquinas y Equipos
                    // 2209005001 Arriendo de Máquinas y Equipos no Médicos
                    // 2209005002 Arriendo de Máquinas y Equipos Clínico
                    // 2209006 Arriendo de Equipos Informáticos
                    // 2209999 Otros
                    // 2210 Servicios Financieros y de Seguros
                    // 2210001 Gastos Financieros por Compra y Venta de Títulos y Valores
                    // 2210002 Primas y Gastos de Seguros
                    // 2210003 Servicios de Giros y Remesas
                    // 2210004 Gastos Bancarios
                    // 2210999 Otros
                    // 2211 Servicios Técnicos y Profesionales
                    // 2211001 Estudios e Investigaciones
                    // 2211002 Cursos de Capacitación
                    // 2211002001 Cursos Contratados Con Terceros
                    // 221100200101 Ley 18575 Cursos Cont Con Terceros
                    // 221100200102 Ley 19664 Cursos Contratados Con Terceros
                    // 221100200103 Programa Iniciativa Ministerial PIM CURSOS.C.TERC.
                    // 2211002002 Postitulos Contratados con Terceros
                    // 221100200201 Postitulos Contratados con Terceros Ley No.18.575
                    // 221100200202 Postitulos Contratados con Terceros Ley No.19.664
                    // 221100200203 Programa Iniciativa Ministerial PIM POSTI.C.TERC.
                    // 2211002003 Pagos A Profesores Y Monitores
                    // 221100200301 Ley 18575 Pagos A Prof Y Monitores
                    // 221100200302 Ley 19664 Pagos A Prof Y Monitores
                    // 221100200303 Programa Iniciativa Ministerial PIM PROFESORES Y MONIT.
                    // 2211002004 Cursos Contratados con Universidades
                    // 221100200401 Cursos Contratados con Universidades Ley No.18.575
                    // 221100200402 Cursos Contratados con Universidades Ley No.19.664
                    // 221100200403 Programa Iniciativa Ministerial PIM CURSOS.C.UNIV.
                    // 2211002005 Postitulos Contratados con Universidades
                    // 221100200501 Postitulos Contratados con Universidades Ley No.18.575
                    // 221100200502 Postitulos Contratados con Universidades Ley No.19.664
                    // 221100200503 Programa Iniciativa Ministerial PIM POSTI.C.UNIV. 21522,
                    // 2211002006 Convenios Con Universidades
                    // 221100200601 Convenios Con Universidades Ley 18834
                    // 221100200602 Convenios Con Universidades Ley 19664
                    // 2211003 Servicios Informáticos
                    // 2211999 Otros
                    // 2212 Otros Gastos en Bienes y Servicios de Consumo
                    // 2212002 Gastos Menores
                    // 2212003 Gastos de Representación, Protocolo y Ceremonial
                    // 2212004 Intereses, Multas y Recargos
                    // 2212005 Derechos y Tasas
                    // 2212006 Contribuciones
                    // 2212999 Otros
                    // 2212999001 Compra De Servicios Medicos De Diálisis
                    // 2212999002 Compra de Examenes y de Procedimientos
                    // 221299900201 Compras de Examenes
                    // 221299900202 Compra de Procedimientos
                    // 2212999003 Compra Intervenciones Quirúrgicas
                    // 221299900301 Compra Intervenciones Quirúrgicas Intrahospitalarias Con Personal Interno
                    // 221299900302 Compra Intervenciones Quirúrgicas Intrahospitalarias Con Personal Externo
                    // 221299900303 Compra Intervenciones Quirúrgicas Clínicas
                    // 2212999004 Compra De Atención De Urgencia
                    // 2212999005 Pago Rebases Ley de Urgencia
                    // 2212999006 Colocación
                    // 221299900601 Colocación Familiar de Menores y Extra Hospitalaria
                    // 221299900602 Colocación Embarazadas de Alto Riesgo
                    // 221299900603 Colocación Adulto Mayor Riesgo
                    // 2212999009 Convenios Dfl 36
                    // 221299900901 Convenios Dfl 36 Centralizados
                    // 221299900902 Convenios Dfl 36 Descentralizados
                    // 221299900903 Convenios DFL 36 Atencion Primaria Salud (APS)
                    // 2212999010 Pasaje Y Traslados De Pacientes
                    // 2212999011 Otros - Imprevistos
                    // 2212999014 Otras Compras De Servicios Y Convenios
                    // 221299901401 Compra De Camas Al Extra Sistema Camas Criíticas
                    // 221299901402 Compra De Camas Al Extra Sistema Camas No Críticas
                    // 2212999015 Gastos Pueblos Indígenas
                    // 2212999016 Compra De Consultas
                    // 221299901601 Medicas
                    // 221299901602 No Medicas ( Otros Profesionales De Salud )
                    // 2212999017 Pago Mutualidades De Empleadores Art. 77 Bis
                    // 2212999018 Otros
                    // 2212999019 Servicio de Intermediacion CENABAST
                    // 2212999020 Programa Adulto Mayor Canastas Dentales
                    // 2212999021 Servicios de Radioterapia
                    // 2212999022 Colocación Pacientes con Enfermedades Mentales
                    //
                    // 24 TRANSFERENCIAS CORRIENTES
                    // 2401 Al Sector Privado
                    // 2401395 Programa Especial de Salud de los Pueblos Indígenas
                    // 2401461 Centros De Prevención De Alcoholismo Y Salud Mental
                    // 2402 Al Gobierno Central
                    // 2403 A Otras Entidades Públicas
                    // 2403298 Atención Primaria Ley N° 19.378
                    // 2403298001 Per- Cápita
                    // 2403298002 Reforzamiento Municipal
                    // 2403298003 Reforzamiento Servicio A. P. S
                    // 2403298004 Capacitación Atención Primaria
                    //
                    // 29 ADQUISICION DE ACTIVOS NO FINANCIEROS
                    // 2901 Terrenos
                    // 2901001 Terrenos Inversion de Operación
                    // 2901002 Terrenos Iniciativa Sectorial
                    // 2901003 Terrenos Programa Gobierno
                    // 2902 Edificios
                    // 2902001 Edificios Inversion de Operación
                    // 2902002 Edificios Iniciativa Sectorial
                    // 2902003 Edificios Programa Gobierno
                    // 2903 Vehículos
                    // 2903001 Vehículos Terrestres
                    // 2903001001 Vehículos Terrestres Inversion de Operación
                    // 2903001002 Vehículos Terrestres Iniciativa Sectorial
                    // 2903001003 Vehículos Terrestres Programa Gobierno
                    // 2903002 Vehículos Aréos
                    // 2903002001 Vehículos Aréos Inversion de Operación
                    // 2903002002 Vehículos Aréos Iniciativa Sectorial
                    // 2903002003 Vehículos Aréos Programa Gobierno
                    // 2903003 Vehículos Marítimos
                    // 2903003001 Vehículos Marítimos Inversion de Operación
                    // 2903003002 Vehículos Marítimos Iniciativa Sectorial
                    // 2903003003 Vehículos Marítimos Programa Gobierno
                    // 2904 Mobiliario y Otros
                    // 2904001 Mobiliario y Otros Inversion de Operación
                    // 2904002 Mobiliario y Otros Iniciativa Sectorial
                    // 2904003 Mobiliario y Otros Programa Gobierno
                    // 2905 Máquinas y Equipos
                    // 2905001 Máquinas y Equipos de Oficina
                    // 2905001001 Máquinas y Equipos de Oficina Inversion de Operación
                    // 2905001002 Máquinas y Equipos de Oficina Iniciativa Sectorial
                    // 2905001003 Máquinas y Equipos de Oficina Programa Gobierno
                    // 2905002 Maquinarias y Equipos para la Producción
                    // 2905002001 Maquinarias y Equipos para la Producción Inversion de Operación
                    // 2905002002 Maquinarias y Equipos para la Producción Iniciativa Sectorial
                    // 2905002003 Maquinarias y Equipos para la Producción Programa Gobierno
                    // 2905999 Otras
                    // 2905999001 Otras Inversion de Operación
                    // 2905999002 Otras Iniciativa Sectorial
                    // 2905999003 Otras Programa Gobierno
                    // 2906 Equipos Informáticos
                    // 2906001 Equipos Computacionales y Periféricos
                    // 2906001001 Equipos Computacionales y Periféricos Inversion de Operación
                    // 2906001002 Equipos Computacionales y Periféricos Iniciativa Sectorial
                    // 2906001003 Equipos Computacionales y Periféricos Programa Gobierno
                    // 2906002 Equipos de Comunicaciones para Redes Informáticas
                    // 2906002001 Equipos de Comunicaciones para Redes Informáticas Inversion de Operación
                    // 2906002002 Equipos de Comunicaciones para Redes Informáticas Iniciativa Sectorial
                    // 2906002003 Equipos de Comunicaciones para Redes Informáticas Programa Gobierno
                    // 2907 Programas Informáticos
                    // 2907001 Programas Computacionales
                    // 2907001001 Programas Computacionales Inversion de Operación
                    // 2907001002 Programas Computacionales Iniciativa Sectorial
                    // 2907001003 Programas Computacionales Programa Gobierno
                    // 2907002 Sistemas de Información
                    // 2907002001 Sistemas de Información Inversion de Operación
                    // 2907002002 Sistemas de Información Iniciativa Sectorial
                    // 2907002003 Sistemas de Información Programa Gobierno
                    //
                    // 3101 Estudios Básicos
                    // 3101001 Gastos Administrativos
                    // 3101002 Consultorías
                    // 3102 Proyectos
                    // 3102001 Gastos Administrativos
                    // 3102002 Consultorías
                    // 3102003 Terrenos
                    // 3102004 Obras Civiles
                    // 3102005 Equipamiento
                    // 3102006 Equipos
                    // 3102007 Vehículos
                    // 3102999 Otros Gastos
    }
}
