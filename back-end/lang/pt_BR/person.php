<?php

return [

    'validation'                      => [
        'name.required'                 => 'O campo Nome é obrigatório',
        'name.max'                      => 'O campo Nome excede o limite de :max caracteres',
        'name.string'                   => 'Formato inválido para o campo Nome',
        'cpf.required'                  => 'O campo CPF é obrigatório',
        'cpf.cpf'                       => 'CPF inválido',
        'cpf.unique'                    => 'CPF já cadastrado no sistema',
        'rg.required'                   => 'O campo RG é obrigatório',
        'rg.max'                        => 'O campo RG excede o limite de :max caracteres',
        'rg.unique'                     => 'RG já cadastrado no sistema',
        'birth_date.required'           => 'O campo Data de Nascimento é obrigatório',
        'birth_date.date_format'        => 'Formato de data inválido',
        'birth_date.before_or_equal'    => 'A data de nascimento não pode ser posterior a hoje',
        'sex_id.required'               => 'O campo Sexo é obrigatório',
        'sex_id.exists'                 => 'Valor enviado em sexo inválido'
    ],
    'invalid_fields'                =>['code' => 'P001', 'message' => 'Campos inválidos', 'fields' => []],
    'error'                         =>['code' => 'P002', 'message' => 'Não foi possivel cadastrar pessoa'],
    'not_found'                     =>['code' => 'P003', 'message' => 'Pessoa não encontrada'],
    'not_deleted'                   =>['code' => 'P004', 'message' => 'Não foi possivel exluir pessoa'],
    'deleted'                       =>['code' => 'P005', 'message' => 'Pessoa exluida com sucesso']

];
