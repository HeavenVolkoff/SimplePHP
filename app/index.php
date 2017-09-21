<?php

/**
 * ############################## index.php ####################################
 *  Arquivo de inicialização, onde todos os recursos são carregados e executados
 *
 * @autor: Vítor Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

/**
 * =============================================================================
 *  include_once: (1)
 *    Inclui e executa arquivo (1) somente uma vez, se ele já tiver sido
 *    incluído a instrução é ignorada.
 * =============================================================================
 *  str_replace: (1, 2, 3)
 *    Substitui a ocorrência de uma substring (1) dentro da string (3) pelo
 *    valor da string (2).
 * =============================================================================
 */

include_once(__DIR__ . '/global.php');
include_once(__DIR__ . '/vendor/Router.php');
include_once(__DIR__ . '/routes.php');

/**
 * Executa a função associada, no Router, ao método HTTP e o caminho do recurso
 * requisitados
 */
Router::getInstance()->_exec(
// Variável interna do PHP que armazena qual método HTTP foi requisitado
  $_SERVER['REQUEST_METHOD'],
  // Computa o caminho, relativo à pasta raiz do projeto, do recurso requisitado
  str_replace(
    ROOT,
    "",
    // Variável interna do PHP que armazena o caminho do recurso requisitado
    (function () {
      $path       = parse_url($_SERVER['REQUEST_URI'])['path'];
      $rootLength = strlen(ROOT);

      return substr($path, 0, $rootLength) == ROOT
        ? substr($path, $rootLength)
        : $path;
    })()
  )
);