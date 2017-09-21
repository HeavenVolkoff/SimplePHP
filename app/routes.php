<?php

/**
 * ############################# Router.php ####################################
 *  Arquivo de definição das funções associadas às rotas
 *
 *  ATENÇÃO: Esse arquivo deve ser customizado para cada projeto
 *
 * @autor: Vítor Augusto da Silva Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

include_once(__DIR__ . '/global.php');
include_once(__DIR__ . '/vendor/Router.php');

/**
 * Associa à cada método HTTP e caminho as funções que devem retornar seus
 * respectivos recursos
 */
Router::getInstance()
  // Index
  ->get('/hello',
    function () {
      json(NULL, 'Hello World!');
    }
  )

  // Testes
  ->get('/teste/500',
    function () {
      serverError("Teste Erro");
    }
  )
  ->get('/teste/404',
    function () {
      notFound("Teste página não encontrada");
    }
  )
;
