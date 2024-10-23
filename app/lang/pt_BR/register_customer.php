<?php

return [

/*
|--------------------------------------------------------------------------
| Type Rooms
|--------------------------------------------------------------------------
*/

    "navigationLabel" => "Matrícula de Alunos",
    "modelLabel" => "matrícula",
    "pluralModelLabel" => "matrículas",
    "navigationGroup" => "Gestão de Vendas",

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    */

    "widget.title.total"=> "Total",
    "widget.description.total"=> "Número de matrículas na plataforma.",
    "widget.title.active"=> "Ativo",
    "widget.description.active"=> "Número de matrículas ativas.",
    "widget.title.inactive"=> "Inativo",
    "widget.description.inactive"=> "Número de matrículas inativas.",

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.id' => 'Código',
    'column.customer' => 'Cliente',
    'column.provider' => 'Professor',
    'column.service' => 'Serviço',
    'column.start_date' => 'Data de Início',
    'column.end_date' => 'Data Final',
    'column.active' => 'Ativo ?',
    'column.created_at' => 'Data Criação',
    'column.updated_at' => 'Data Alteracão',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'section.title.personalData' => 'Dados Principais',
    'section.description.personalData' => 'Entre com os dados da matrícula.',

    'field.id' => 'Código',
    'field.customer' => 'Cliente',
    'field.provider' => 'Professor',
    'field.service' => 'Serviço',
    'field.start_date' => 'Data de Início',
    'field.end_date' => 'Data Final',
    'field.active' => 'Ativo ?',
    'field.created_at' => 'Data Criação',
    'field.updated_at' => 'Data Alteração',

];
