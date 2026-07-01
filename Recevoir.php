<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Recevoir extends Model
    {
        protected $table = 'recevoir';
        protected $primaryKey = 'idrecept';
        public $timestamps = false;
        protected $fillable = ['idrecept','idenvoi','date_recept'];
        public function envoyer()
        {
            return $this->belongsTo(Envoyer::class,'idenvoi');
        }

    }

