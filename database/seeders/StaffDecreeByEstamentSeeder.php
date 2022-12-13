<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\StaffDecreeByEstament;

class StaffDecreeByEstamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ESTAMENTO: ADMINISTRATIVO
        StaffDecreeByEstament::Create([
            'estament_id'       => 1,
            'start_degree'      => 12,
            'end_degree'        => 15,
            'description'       => 'Licencia de Enseñanza Media o equivalente, y acreditar una experiencia laboral en el área administrativa o en labores equivalentes no inferior a cinco años en el sector público',
            'staff_decree_id'   => 1
        ]);
        StaffDecreeByEstament::Create([
            'estament_id'       => 1,
            'start_degree'      => 16,
            'end_degree'        => 19,
            'description'       => 'Licencia de Enseñanza Media o equivalente, y acreditar una experiencia laboral en el área administrativa o en labores equivalentes no inferior a tres años en el sector público o privado',
            'staff_decree_id'   => 1
        ]);
        StaffDecreeByEstament::Create([
            'estament_id'       => 1,
            'start_degree'      => 20,
            'end_degree'        => 22,
            'description'       => 'Licencia de Enseñanza Media o equivalente',
            'staff_decree_id'   => 1
        ]);

        //ESTAMENTO: AUXILIAR
        StaffDecreeByEstament::Create([
            'estament_id'       => 2,
            'start_degree'      => 16,
            'end_degree'        => 19,
            'description'       => 'Licencia de Enseñanza Media o equivalente, y acreditar una experiencia laboral no inferior a cinco años en el sector público',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 2,
            'start_degree'      => 20,
            'end_degree'        => 22,
            'description'       => 'Alternativamente
i) Licencia de Enseñanza experiencia laboral no inferior a tres años en el sector público o privado; o,
ii) Haber sido encasillado en calidad de titular en la planta de Auxiliares, al 1 de julio de 2008, y acreditar una experiencia laboral no inferior a quince años en el sector público.',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 2,
            'start_degree'      => 23,
            'end_degree'        => 24,
            'description'       => 'Alternativamente	 	 	 
i)	Licencia de Enseñanza Media o equivalente; o,
ii)	Haber sido encasillado en calidad de titular en la planta de Auxiliares, al 1 de julio de 2008',
            'staff_decree_id'   => 1
        ]);

        //ESTAMENTO: PROFESIONAL
        StaffDecreeByEstament::Create([
            'estament_id'       => 3,
            'start_degree'      => 5,
            'end_degree'        => 7,
            'description'       => 'Alternativamente
i)	Título Profesional de una carrera de, a lo menos, diez semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a cinco años, en el sector público o privado; o,
ii)	Título Profesional de una carrera de, a lo menos, ocho semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a seis años, en el sector público o privado',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 3,
            'start_degree'      => 8,
            'end_degree'        => 10,
            'description'       => 'Alternativamente
i)	Título Profesional de una carrera de, a lo menos, diez semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a tres años, en el sector público o privado; o
ii)	Título Profesional de una carrera de, a lo menos, ocho semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a cuatro años, en el sector público o privado',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 3,
            'start_degree'      => 11,
            'end_degree'        => 14,
            'description'       => 'Alternativamente
i)	Título Profesional de una carrera de, a lo menos, diez semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a un año, en el sector público o privado; o,
ii)	Titulo Profesional de una carrera de, a lo menos, ocho semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente y acreditar una experiencia profesional no inferior a dos años, en el sector público o privado',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 3,
            'start_degree'      => 15,
            'end_degree'        => 16,
            'description'       => 'Titulo Profesional de una carrera de, a lo menos, ocho semestres de duración, otorgado por una Universidad o Instituto Profesional del Estado o reconocido por éste o aquellos validados en Chile de acuerdo con la legislación vigente',
            'staff_decree_id'   => 1
        ]);

        //ESTEMENTO: TÉCNICO
        StaffDecreeByEstament::Create([
            'estament_id'       => 4,
            'start_degree'      => 11,
            'end_degree'        => 14,
            'description'       => 'Alternativamente
i) Título de Técnico de Nivel Superior otorgado por un Establecimiento de Educación Superior del Estado o reconocido por éste y acreditar una experiencia como Técnico de Nivel Superior no inferior a diez años, en el sector público; o,
ii) Título de Técnico de Nivel Medio o equivalente, otorgado por el Ministerio de Educación, y acreditar una experiencia como Técnico de Nivel Medio no inferior a veinte años, en los Servicios de Salud a que se refiere el artículo 16, del decreto con fuerza de ley W 1, de 2005, del Ministerio de Salud; o,
iii) Licencia de Enseñanza Media o equivalente y certificado de competencias para ejercer como auxiliar paramédico otorgado por la Autoridad Sanitaria, previa aprobación del curso de 1.500 horas como mínimo, según programa del Ministerio de Salud y además, acreditar una experiencia laboral no inferior a veinte años como auxiliar para médico en los Servicios de Salud a que se refiere el artículo 16, del decreto con fuerza de ley W 1, de 2005, del Ministerio de Salud',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 4,
            'start_degree'      => 15,
            'end_degree'        => 17,
            'description'       => 'Alternativamente
i) Título de Técnico de Nivel Superior otorgado por un Establecimiento de Educación Superior del Estado o reconocido por éste y acreditar una experiencia como Técnico de Nivel Superior no inferior a cinco años, en el sector público; o,
ii) Título de Técnico de Nivel Medio o equivalente, otorgado por el Ministerio de Educación, y acreditar una experiencia como Técnico de Nivel Medio no inferior a diez años, en el sector público; o,
iii) Licencia de Enseñanza Media o equivalente y certificado de competencias para ejercer como auxiliar paramédico otorgado por la Autoridad Sanitaria, previa aprobación del curso de 1.500 horas como mínimo, según programa del Ministerio de Salud y además, acreditar una experiencia laboral no inferior a diez años como auxiliar paramédico en el sector público',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 4,
            'start_degree'      => 18,
            'end_degree'        => 20,
            'description'       => 'Alternativamente
i) Título de Técnico de Nivel Superior otorgado por un Establecimiento de Educación Superior del Estado o reconocido por éste y acreditar una experiencia como Técnico de Nivel Superior no inferior a tres años, en el sector público o privado; o,
ii) Título de Técnico de Nivel Medio o equivalente, otorgado por el Ministerio de Educación, y acreditar una experiencia como Técnico de Nivel Medio no inferior a cinco años, en el sector público o privado; o,
iii) Licencia de Enseñanza Media o equivalente y certificado de competencias para ejercer como auxiliar paramédico otorgado por la Autoridad Sanitaria, previa aprobación del curso de 1.500 horas como mínimo, según programa del Ministerio de Salud y además, acreditar una experiencia laboral no inferior a cinco años como auxiliar paramédico en el sector público o privado',
            'staff_decree_id'   => 1
        ]);

        StaffDecreeByEstament::Create([
            'estament_id'       => 4,
            'start_degree'      => 21,
            'end_degree'        => 22,
            'description'       => 'Alternativamente
i) Título de Técnico de Nivel Superior otorgado por un Establecimiento de Educación Superior del Estado o reconocido por éste; o,
ii) Título de Técnico de Nivel Medio o equivalente otorgado por el Ministerio de Educación; o,
iii) Licencia de Enseñanza Media o equivalente y certificado de competencias para ejercer como auxiliar paramédico otorgado por la Autoridad Sanitaria, previa aprobación del curso de 1.500 horas como mínimo, según programa del Ministerio de Salud',
            'staff_decree_id'   => 1
        ]);
    }
}
