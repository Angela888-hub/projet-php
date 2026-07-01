<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Envoyer extends Model
{
    protected $table = 'envoyer';
    protected $primaryKey = 'idenvoi';
    public $timestamps = false;
    protected $fillable = [     
                                'idvoit',
                                'idenvoi',
                                'colis',
                                'nomEnvoyeur',
                                'emailEnvoyeur',
                                'date_envoi',
                                'frais',
                                'nomRecepteur',
                                'contactRecepteur'
    ];
     public function voiture()
    {
        return $this->belongsTo(Voiture::class, 'idvoit');
    }
    public function reception()
{
    return $this->hasOne(Recevoir::class, 'idenvoi');
}
  
}       