<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CpSepomex
 * @package App
 * @property int $id
 * @property int $d_codigo
 * @property string $d_asenta
 * @property string $d_tipo_asenta
 * @property string $d_mnpio
 * @property string $d_estado
 * @property string $d_ciudad
 * @property string $cp
 * @property string $c_estado
 * @property string $c_cp
 * @property string $c_tipo_asenta
 * @property string $c_mnpio
 * @property string $id_asenta_cpcons
 * @property string $d_zona
 * @property string $c_cve_ciudad
 * @property int $carga_layout_id
 */
class CpSepomex extends Model
{
    protected $table = 'cp_sepomex';
    /** @var string[]  */
    protected $fillable = [
        'd_codigo',
        'd_asenta',
        'd_tipo_asenta',
        'd_mnpio',
        'd_estado',
        'd_ciudad',
        'cp',
        'c_estado',
        'c_cp',
        'c_tipo_asenta',
        'c_mnpio',
        'id_asenta_cpcons',
        'd_zona',
        'c_cve_ciudad',
        'carga_layout_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toFile(){
        return $this->belongsTo(CargaLayout::class);
    }

    /**
     * @param $query
     * @param $rfc
     * @return mixed
     */
    public function scopeOfEstado($query, $estado)
    {
        return $query->where('d_estado', $estado);
    }

    public function scopeOfMunicipio($query, $municipio)
    {
        return $query->where('d_mnpio', $municipio);
    }
}
