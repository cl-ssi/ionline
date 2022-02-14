<?php

use Illuminate\Database\Seeder;
use App\Documents\Document;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */

    public function run()
    {

        //DB::table('rrhh_authorities')->insert([
        Document::create([
            'number' => '1',
            'date' => carbon::now()->toDateString(),
            'type' => 'Memo',
            'antecedent' => 'ORD.: A22 / N° 3489',
            'subject' => 'Otorga informe favorable para efectos que indica.',
            'from' => 'PATRICIA QUINTARD ROJAS / DIRECTORA SERVICIO DE SALUD IQUIQUE (S)',
            'for' => 'DR. ALBERTO DOUGNAC LABATUT SUBSECRETARIO DE REDES ASISTENCIALES / MINISTERIO DE SALUD',
            'greater_hierarchy' => 'from',
            'content' => '<p style="text-align: justify;">En conformidad a lo dispuesto en el art&iacute;culo 8&deg; letra c) del DFL N&deg;1, del 2005, del Ministerio de Salud, que fija el texto refundido, coordinado y sistematizado del Decreto Ley N&deg; 2.763/79 y de las Leyes N&deg;s 18.933 y 18.496, y en el marco de la contrataci&oacute;n de servicios "Red de Comunicaciones MINSAL", la Directora(S) infrascrita otorga informe favorable al Sr. Subsecretario de Redes Asistenciales, para contratar los servicios de la Red de Comunicaciones MINSAL, mandatando al mismo tiempo para realizar y suscribir los actos jur&iacute;dicos y administrativos necesarios para tal cometido.</p>
            <p style="text-align: justify;">Sin otro particular, saluda atentamente a Usted,</p>',
            'user_id' => '15287582',
            'organizational_unit_id' => '222',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

    }
}