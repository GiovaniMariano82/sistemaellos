<?php

return [

/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
*/

    "navigationLabel" => "Cliente",
    "modelLabel" => "cliente",
    "pluralModelLabel" => "clientes",

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    */

    "widget.title.total"=> "Total",
    "widget.description.total"=> "Número de pacientes na plataforma.",
    "widget.title.active"=> "Ativo",
    "widget.description.active"=> "Número de pacientes ativos.",
    "widget.title.inactive"=> "Inativo",
    "widget.description.inactive"=> "Número de pacientes inativos.",

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.id' => 'Código',
    'column.fullName' => 'Nome Completo',
    'column.socialName' => 'Nome Social',
    'column.type_document' => 'Tipo Documento',
    'column.documentNumber' => 'Número Documento',
    'column.status' => 'Estado',

    /*
    |--------------------------------------------------------------------------
    | Table Filters
    |--------------------------------------------------------------------------
    */

    'filter.show_active'=> 'Exibir ativos',
    'filter.show_inactive'=> 'Exibir inativos',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'section.title.personalData' => 'Dados Pessoais',
    'section.description.personalData' => 'Entre com os dados pessoais do paciente.',
    'section.title.addressData' => 'Dados de Endereço',
    'section.description.addressData' => 'Entre com os dados de endereço do paciente.',
    'section.title.extraData' => 'Dados Extras',
    'section.description.extraData' => 'Entre com os dados extras do paciente.',
    'section.title.contactDetail' => 'Dados de Contato',
    'section.description.contactDetail' => 'Entre com os detalhes de contato do paciente.',

    'field.id' => 'Código',
    'field.fullName' => 'Nome Completo',
    'field.socialName' => 'Nome Social',
    'field.typeDocument' => 'Tipo Documento',
    'field.documentNumber' => 'Número Documento',
    'field.birthDate' => 'Data Nascimento',
    'field.status' => 'Status do Pasciente',
    'field.createdAt' => 'Data Criação',
    'field.updatedAt' => 'Data Alteração',
    'field.origin' => 'Origem',
    'field.typeGender' => 'Gênero',
    'field.postalCode' => 'Cep',
    'field.address' => 'Endereço',
    'field.addressNumber' => 'Número',
    'field.complement' => 'Complemento',
    'field.neighborhood' => 'Bairro',
    'field.city' => 'Cidade',
    'field.state' => 'Estado (UF)',
    'field.observation' => 'Observação',
    'field.customer_age' => 'Idade',

    'helperText.documentNumber' => 'Digite somente números.',

    /*
    |--------------------------------------------------------------------------
    | Contacts Relation Manager
    |--------------------------------------------------------------------------
    */

    'relation.contacts.title'=> 'Contatos',
    'relation.contacts.modelLabel'=> 'contato',
    'relation.contacts.pluralModelLabel'=> 'contatos',
    'relation.contacts.description'=> 'Lista de contatos do paciente',
    'relation.contacts.table.type_contact'=> 'Tipo Contato',
    'relation.contacts.table.contact'=> 'Contato',
    'relation.contacts.table.contact_name'=> 'Nome para Contato',

];
