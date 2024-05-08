<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModelSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model-seeder {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un seeder para un modelo específico a partir de los registros existentes en la base de datos.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');
        // Reemplazar barras inclinadas por barras invertidas para soportar subdirectorios
        $modelName = str_replace('/', '\\', $modelName);
        $modelClass = "App\\Models\\{$modelName}";

        // obten el string después del último /
        $model = Str::afterLast($modelClass, '\\');

        if (!class_exists($modelClass)) {
            $this->error("El modelo {$modelName} no existe.");
            return;
        }

        $modelInstances = $modelClass::withTrashed()->get();
        // Generar el nombre de la clase Seeder usando solo el nombre del modelo sin el espacio de nombres
        $className = class_basename($modelName) . "Seeder";
        $seederContent = "<?php\n\nnamespace Database\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse {$modelClass};\n\nclass {$className} extends Seeder\n{\n    public function run()\n    {\n";

        foreach ($modelInstances as $instance) {
            $attributes = $instance->getAttributes();

            // Omitir el ID del array de atributos
            unset($attributes['id']);
            unset($attributes['created_at']);
            unset($attributes['updated_at']);
            // unset($attributes['father_organizational_unit_id']);
            
            $attributesArrayString = var_export($attributes, true);
            $seederContent .= "        {$model}::create(" . var_export($attributes, true) . ");\n";
        }

        $seederContent .= "    }\n}\n";

        File::put(database_path("seeders/{$className}.php"), $seederContent);

        $this->info("Seeder {$className} generado exitosamente.");
    }
}
