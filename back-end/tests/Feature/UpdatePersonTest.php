<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UpdatePersonTest extends TestCase
{

   private function newPerson(): array
   {
       $faker = \Faker\Factory::create('pt_BR');
        return [
            'name'          => $faker->name,
            'rg'            => $faker->rg,
            'cpf'           => $faker->cpf,
            'birth_date'    => $faker->date,
            'sex_id'        => rand(1,2)
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

    /**
     * @depends test_application_store_new_person
     */
    public function test_aplication_update_person_without_unique_validation_for_rg_cpf($response):void
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        Arr::set($person, 'name', 'test update' );
        $response = $this->put('/person/'.Arr::get($person, 'id'), $person, $this->headers());
        $response->assertStatus(200);
    }

    public function test_aplication_cant_update_a_nonexistent_person():void
    {
        $response = $this->put('/person/123456', [], $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('Pessoa n\u00e3o encontrada');
    }

}
