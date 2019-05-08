<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documentacion';

    protected $primaryKey = 'id_tramite';

    public $timestamps = false;

    protected $guarded = [];
}
