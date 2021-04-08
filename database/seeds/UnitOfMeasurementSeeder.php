<?php
//namespace Database\Seeds;

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Hash;
use app\Models\Parameters\UnitOfMeasurement;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      UnitOfMeasurement::Create(['name'=>'Carga', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Carrete', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cartón', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Centímetros Cúbicos', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cientos', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cilindro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Comprimido', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Comprimido Vaginal', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Centímetro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cajón', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cono', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cartucho', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Bloque', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'pallets', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Día', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Docena', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Dosis', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tambor', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Disco', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Unidad', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Unidad no Definida', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Galón', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Ampolla', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Frasco Ampolla', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Año', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Atado', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Balón', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Bandeja', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Barra', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Bidón', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Bolsa', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cubeta', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Balde', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Block', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Botella', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Caja', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pieza', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Lata', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cajetilla', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cápsula', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Mililitro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Milímetro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Mes', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Metro Cuadrado', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Metro Cúbico', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Metro Lineal', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Lámina', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Onza', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Ovillo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Ovulo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pack', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pan', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Papelillo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Placa', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pliego', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Paquete', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Plancha', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pomo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pote', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Par', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Quincena', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Rack', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Resma', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Rollo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Saco', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Sachet', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Juego', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Sobre', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tira', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Supositorio', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Talonario', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tineta', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tonelada', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tubo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Unidad Internacional', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Frasco', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Semana', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Mes/Hombre', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pie', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Global', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Gramo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Gragea', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Guesa', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Hoja', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Hora', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Día/Hombre', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Pulgada', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Tarro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Cuñete', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Kilogramo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Kit', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Hora/Hombre', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Libra', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Litro', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Matraz', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Microgramo', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Miles', 'prefix'=>'']);
      UnitOfMeasurement::Create(['name'=>'Milígramo', 'prefix'=>'']);
    }
}
