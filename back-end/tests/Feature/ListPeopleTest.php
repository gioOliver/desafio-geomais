<?php

use Faker\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ListPeopleTest extends TestCase
{

    private function newPerson(): array
    {
        $faker = \Faker\Factory::create('pt_BR');
        return [
            'name'          => 'test list',
            'rg'            => $faker->rg,
            'cpf'           => $faker->cpf,
            'birth_date'    => $faker->date,
            'sex_id'        => 2
        ];
    }
    private function headers(): array
    {
        return ['Content-Type' => 'Application/Json'];
    }

    public function test_application_store_new_person()
    {
        $response = $this->post('/person', $this->newPerson(), $this->headers());
        $response->assertStatus(200);
        return $response->content();
    }

    public function test_application_can_list_people()
    {
        $response = $this->get('/person');
        $response->assertStatus(200);
    }

    /**
     * @depends test_application_store_new_person
     */
    public function test_application_can_search_by_name($response)
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        $response = $this->get('/person?name='.Arr::get($person,'name'));
        $response->assertStatus(200);
        $response->assertSeeText('test list');
    }
    /**
     * @depends test_application_store_new_person
     */
    public function test_application_can_search_by_cpf($response)
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        $response = $this->get('/person?cpf='.Arr::get($person,'cpf'));
        $response->assertStatus(200);
        $response->assertSeeText(Arr::get($person,'cpf'));
    }
    /**
     * @depends test_application_store_new_person
     */
    public function test_application_can_search_by_rg($response)
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        $response = $this->get('/person?rg='.Arr::get($person,'rg'));
        $response->assertStatus(200);
        $response->assertSeeText(Arr::get($person,'rg'));
    }
    /**
     * @depends test_application_store_new_person
     */
    public function test_application_can_search_by_sex($response)
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        $response = $this->get('/person?sex_id='.Arr::get($person,'sex_id'));
        $response->assertStatus(200);
        $response->assertSeeText(Arr::get($person,'sex_id'));
    }
}
