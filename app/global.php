<?php

/**
 * ############################## global.php ###################################
 *  Arquivo que define constante globais que devem estar disponíveis em todos os
 *  arquivos durante a execução do PHP.
 *
 * @autor: Vítor Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

/**
 * =============================================================================
 *  http_response_code: (1)
 *    Atribuí o valor (1) ao header do código de resposta HTTP
 * =============================================================================
 *  exit: (1)
 *    Finaliza a execução da aplicação enviando (1) como resposta à requisição.
 *    Se (1) for uma `string` ele será incluído no corpo da resposta, se for um
 *    número será usado como Código HTTP da resposta
 * =============================================================================
 */

include_once(__DIR__ . '/env.php');

/**
 * Define uma constante com o valor do caminho, relativo ao diretório raiz do
 * servidor (e.x: htdocs), do diretório desse projeto
 */
define("ROOT",
  (function () {
    $dirName            = dirname(__FILE__);
    $documentRoot       = $_SERVER["DOCUMENT_ROOT"];
    $documentRootLength = strlen($documentRoot);

    return (substr($dirName, 0, $documentRootLength) == $documentRoot
        ? substr(dirname(__FILE__), $documentRootLength)
        : $dirName) . '/';
  })()
);

/**
 * Codifica $data como json a envia como corpo da resposta à requisição,
 * finalizando a execução da aplicação.
 *
 * @param string $error Parâmetro opcional de error a ser enviado no json
 * @param mixed $data Estrutura de dados que será convertida em JSON e enviada
 *                    como resposta
 */
function json($error, $data) {
  /**
   * Define o header responsável por identificar o tipo de resposta que será
   * enviada. Neste caso o tipo é JSON com codificação UTF-8
   */
  header("Content-Type: application/json;charset=utf-8");
  // Terminamos a aplicação enviando os dados codificados em formato JSON
  exit(json_encode(['error' => $error, 'data' => $data]));
}

/**
 * Define o comportamento caso o servidor encontre algum error irrecuperável.
 *
 * @param string $message Mensagem a ser passada como causa do error
 */
function serverError($message) {
  // Define o código da resposta para 500 (Internal Server Error)
  http_response_code(500);
  // Envia o error e finaliza a aplicação
  json($message, NULL);
}

/**
 * Define o comportamento caso o servidor não encontre o recurso requisitado.
 *
 * @param string $file Caminho para o arquivo não encontrado
 */
function notFound($file) {
  // Define o código de resposta para 404 (Not Found)
  http_response_code(404);
  // Envia o error e finaliza a aplicação
  json(
    'File: ' . ($file ?? $_SERVER['REQUEST_URI']) . ' not found',
    NULL
  );
}