<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nomor', 
    'companies_id', 'categories_id', 'date', 'price', 'templates_id', 'user_id','documentfinal'];


    public function template()
    {
        return $this->belongsTo('App\Template');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
    
    public function categories()
    {
        return $this->belongsTo('App\Category');
    }
    
    
    
    
}
