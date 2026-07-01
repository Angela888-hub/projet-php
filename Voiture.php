<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Voiture extends Model
{
    protected $table = 'voiture';
    protected $primaryKey = 'idvoit';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['idvoit', 'design', 'codeit', 'frais'];
    public function itineraire() {
                    return $this->belongsTo(Itineraire::class, 'codeit');
    }
     public function envois()
    {
        return $this->hasMany(Envoyer::class, 'idvoit');
    }
}    