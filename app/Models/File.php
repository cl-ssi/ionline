<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    /**
     * Get the file model.
     */
    // public function file(): MorphOne
    // {
    //     return $this->morphOne(File::class, 'fileable');
    // }

    /**
     * Get all of the files of a model.
     */
    // public function files(): MorphMany
    // {
    //     return $this->morphMany(File::class, 'fileable');
    // }

    // $modelo->file()->create([
    //     'storage_path' => 'ionline/documents/23234.pdf',
    //     'stored' => true,
    //     'name' => 'Mi documento.pdf',
    //     'input_title' => 'Archivo pulento',
    //     'input_name' => 'reception',
    //     'required' => false,
    //     'valid_types' => json_encode(["pdf", "xls"]),
    //     'max_file_size' => 10,
    //     'stored_by_id' => 1,
    // ]);

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'storage_path', // 'ionline/reception/file.pdf'
        'stored',       // false => muestro input, true = meustro el link al archivo

        'name',
        'type',    // Documento, Anexo, Acta

        'input_title',  // <label<{{ $input_title }}</label>
        'input_name',   // <input type="file" name="{{ $input_name }}>
        'required',
        'valid_types',  // pdf, xls
        'max_file_size', // 20mb

        'stored_by_id', // user

        'fileable_type',
        'fileable_id',
    ];

    /**
     * Get the polymorphic  parent fileable model:
     * - Reception
     * -
     * -
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
