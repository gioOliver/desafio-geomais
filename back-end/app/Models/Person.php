<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'name',
        'cpf',
        'rg',
        'birth_date',
        'sex_id'
    ];

    public function sex(): HasOne
    {
        return $this->hasOne(Sex::class, 'id', 'sex_id');
    }

    public function getValidationRules($id = null) :array
    {
        $rules = [
            'name'          => 'required|max:100|string',
            'cpf'           => 'required|cpf|unique:person,cpf',
            'rg'            => 'required|max:14|unique:person,rg',
            'birth_date'    => 'required|date_format:Y-m-d|before_or_equal:today',
            'sex_id'        => 'required|exists:sex,id',
        ];

        if($id)
        {
            Arr::set($rules, 'cpf', ['required', 'cpf', Rule::unique('person')->ignore($id)]);
            Arr::set($rules, 'rg', ['required', 'max:14', Rule::unique('person')->ignore($id)]);
        }

        return $rules;
    }
}
