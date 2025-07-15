<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Esta linha crucial diz ao Pest para usar a classe TestCase base do Laravel
| para todos os testes na pasta 'Feature'. Isso garante que o ambiente
| completo da aplicação, incluindo o Faker, seja carregado.
|
*/

uses(Tests\TestCase::class)->in('Feature');