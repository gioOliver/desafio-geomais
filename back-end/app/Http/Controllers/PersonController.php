<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Models\Person;
use App\Models\Sex;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Help;

class PersonController extends Controller
{
    public function store(Request $request)
    {
        $data = Helpers::unmaskRequest($request->all());
        $person = new Person();

        $validation = Validator::make($data, $person->getValidationRules(), __('person.validation'));

        if($validation->fails())
        {
            return Helpers::response(null, Helpers::getAttributeErrors($validation->errors()->toArray(), 'person'), 400);
        }

        $person->fill($data);

        if( !$person->save() )
            return Helpers::response(null, __('person.error'), 400);

        return Helpers::response($person);
    }

    public function update(Request $request, int $id)
    {
        $data = Helpers::unmaskRequest($request->all());

        if(!$person = Person::find($id))
        {
            return Helpers::response(null, __('person.not_found'), 400);
        }

        $validation = Validator::make($data, $person->getValidationRules($id), __('person.validation'));

        if($validation->fails())
        {
            return Helpers::response(null, Helpers::getAttributeErrors($validation->errors()->toArray(), 'person'), 400);
        }

        $person->fill($data);

        if( !$person->save() )
        {
            return Helpers::response(null, __('person.error'), 400);
        }

        return Helpers::response($person);
    }

    public function list(Request $request)
    {
        $data = Helpers::unmaskRequest($request->all());

        $list = Person::orderBy('id','desc')
            ->with('sex');

        if ($name = Arr::get($data, 'name', null))
        {
            $list->where('name', 'ilike', "%$name%");
        }

        if ($rg = Arr::get($data, 'rg', null))
        {
            $list->where('rg', 'like', $rg);
        }

        if ($cpf = Arr::get($data, 'cpf', null))
        {
            $list->where('cpf', 'like', $cpf);
        }

        if ($sex_id = Arr::get($data, 'sex_id', null))
        {
            $list->where('sex_id', $sex_id);
        }

        return Helpers::response($list->paginate(Arr::get($data, 'per_page', 5)));

    }

    public function get( $id )
    {
        $person = Person::find($id)
            ->with('sex')->first();

        return Helpers::response($person);
    }

    public function delete($id)
    {
        if(!$person = Person::find($id))
            return Helpers::response(null, __('person.not_found'), 400);

        if(!$person->delete())
            return Helpers::response(null, __('person.not_deleted'), 400);

        return Helpers::response(__('person.deleted'));
    }
}
