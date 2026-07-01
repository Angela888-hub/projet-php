<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Itineraire extends Model
{
    
    protected $table = 'itineraire';
    protected $primaryKey = 'codeit';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['codeit', 'villedep', 'villearr'];
    public function voiture(){
        return $this->hasMany(Voiture::class, 'codeit');

    }
}