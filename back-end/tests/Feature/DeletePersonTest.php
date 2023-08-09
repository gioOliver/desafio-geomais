<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DeletePersonTest extends TestCase
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
     public function test_aplication_can_delete_a_person($response):int
    {
        $response_json = json_decode($response, true);
        $person = Arr::get($response_json, 'data');
        $response = $this->delete('/person/'.Arr::get($person, 'id'), $person, $this->headers());
        $response->assertStatus(200);
        return Arr::get($person, 'id');
    }

    /**
     * @depends test_aplication_can_delete_a_person
     */
    public function test_aplication_cant_delete_an_nonexistent_person($person_id):void
    {
        $response = $this->delete('/person/'.$person_id, [], $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('Pessoa n\u00e3o encontrada');
    }

}
