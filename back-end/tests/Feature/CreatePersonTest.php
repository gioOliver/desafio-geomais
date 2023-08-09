<?php


// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CreatePersonTest extends TestCase
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

    public function test_the_name_field_is_required()
    {
        $person = $this->newPerson();
        Arr::set($person, 'name', null);
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo Nome \u00e9 obrigat\u00f3rio');
    }

    public function test_the_name_must_have_less_than_100_characters()
    {
        $person = $this->newPerson();
        Arr::set($person, 'name', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in ante hendrerit, scelerisque nulla eu, semper justo. Suspendisse et placerat mauris, quis elementum ex. Fusce lobortis dolor non neque dictum, sit amet tincidunt odio scelerisque. In at pharetra odio.');
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo Nome excede o limite de 100 caracteres');
    }

    public function test_the_name_field_must_be_a_string()
    {
        $person = $this->newPerson();
        Arr::set($person, 'name', 12345789);
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('Formato inv\u00e1lido para o campo Nome');
    }

    /**
     * @depends test_application_store_new_person
     */
    public function test_aplication_cant_save_same_cpf($response):void
    {
        $data = json_decode($response, true);
        $person = $this->newPerson();
        Arr::set($person, 'cpf', Arr::get($data, 'data.cpf') );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('CPF j\u00e1 cadastrado no sistema');

    }

    public function test_the_cpf_field_is_required():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'cpf', null );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo CPF \u00e9 obrigat\u00f3rio');
    }

    public function test_the_cpf_field_must_be_valid():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'cpf', '123458' );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('CPF inv\u00e1lido');
    }

    /**
     * @depends test_application_store_new_person
     */
    public function test_aplication_cant_save_same_rg($response):void
    {
        $data = json_decode($response, true);
        $person = $this->newPerson();
        Arr::set($person, 'rg', Arr::get($data, 'data.rg') );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('RG j\u00e1 cadastrado no sistema');
    }

    public function test_the_rg_must_have_less_than_14_characters():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'rg', '123456789123456789' );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo RG excede o limite de 14 caracteres');
    }

    public function test_the_rg_field_is_required():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'rg', null );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo RG \u00e9 obrigat\u00f3rio');
    }

    public function test_birth_date_must_be_before_today():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'birth_date', Carbon::today()->addWeeks(2)->format('Y-m-d') );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('A data de nascimento n\u00e3o pode ser posterior a hoje');
    }

    public function test_birth_date_must_be_in_correct_format():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'birth_date', Carbon::tomorrow()->format('d/m/Y') );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('Formato de data inv\u00e1lido');
    }

    public function test_sex_id_is_required():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'sex_id', null );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('O campo Sexo \u00e9 obrigat\u00f3rio');
    }

    public function test_sex_id_must_exist_in_database():void
    {
        $person = $this->newPerson();
        Arr::set($person, 'sex_id',4 );
        $response = $this->post('/person', $person, $this->headers());
        $response->assertStatus(400);
        $response->assertSeeText('Valor enviado em sexo inv\u00e1lido');
    }
}
