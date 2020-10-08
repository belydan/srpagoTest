<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CargaLayout
 * @package App
 * @property int $id
 * @property string $file_name
 * @property string $upload_date
 * @property int $num_data_inserted
 * @property boolean $loading_status
 */
class CargaLayout extends Model
{
    /** @var string Nombre de tabla */
    protected $table = 'carga_layouts';

    /** @var string[]  */
    protected $fillable = [
        'file_name',
        'upload_date',
        'num_data_inserted',
        'loading_status',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postal_codes(){
        return $this->hasMany(CpSepomex::class);
    }

    /**
     * @return string
     */
    public function pathLayoutSepomex(){
        return storage_path('sepomex'.DIRECTORY_SEPARATOR.'layout'.DIRECTORY_SEPARATOR);
    }
}
