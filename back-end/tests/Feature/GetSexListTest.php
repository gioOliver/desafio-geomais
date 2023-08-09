<?php

use Tests\TestCase;

class GetSexListTest extends TestCase
{
    public function test_the_application_returns_a_list_of_sex()
    {
        $response = $this->get('/sex');

        $response->assertStatus(200);

        return $response;
    }

    /**
     * @depends test_the_application_returns_a_list_of_sex
     */
    public function test_the_list_of_sex_has_the_expected_static_values($response):void
    {
        $response->assertJsonFragment(["id"=> 1,"name"=>"Masculino"]);

        $response->assertJsonFragment(["id"=> 2,"name"=>"Feminino"]);
    }
}
