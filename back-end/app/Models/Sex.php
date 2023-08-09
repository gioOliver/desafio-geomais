<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sex extends Model
{

    protected $table = 'sex';

    public function person()
    {
        return $this->belongsTo(Person::class, 'id', 'sex_id');
    }

}
