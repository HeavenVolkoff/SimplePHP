<?php

/**
 * ############################### Router.php ##################################
 *  Arquivo de definição da classe Router
 *
 * @autor: Vítor Augusto da Silva Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

include_once(__DIR__ . '/../global.php');
include_once(__DIR__ . '/abstract/Singleton.php');

/**
 * =============================================================================
 *  array_key_exists: (1, 2)
 *    Verifica se chave (1) está definida no array (2)
 * =============================================================================
 */

/**
 * Classe responsável pelo redirecionamento dos recursos para funções
 * pré-definidas de acordo com a URL e o método requisitado
 */
class Router extends Singleton {

  // Membro privado que armazena todas as funções associadas
  private $routes = [];

  /**
   * Executa a função associada à dado método e caminho
   *
   * @param string $method Método HTTP
   * @param string $path Caminho requisitado na URL
   *
   * @return mixed Retorno da função associada
   */
  public function _exec($method, $path) {
    /**
     * Verifica se alguma função foi associada com esse método e caminho,
     * se não tiver nenhuma função associada retornamos a mensagem padrão de
     * arquivo não encontrado
     */
    if (
      !array_key_exists($method, $this->routes)
      || !array_key_exists($path, $this->routes[$method])
    ) {
      // Função global que retorna mensagem arquivo não encontrado
      notFound($path);
    }

    // Se houver uma função associada com esse método e caminho execute-a
    return $this->routes[$method][$path]();
  }

  /**
   * Associa uma função com um método e um caminho
   *
   * @param string $method Método HTTP a ser associado
   * @param string $path Caminho a ser associado
   * @param callable $function Função a ser associada
   *
   * @return \Router
   */
  public function _add($method, $path, callable $function) {
    /**
     * Inicializa um novo array para o dado método, caso seja a primeira vez
     * que uma função esteja sendo associada a ele
     */
    if (!array_key_exists($method, $this->routes)) {
      $this->routes[$method] = [];
    }

    // Associa a função
    $this->routes[$method][$path] = $function;

    // Retorna o próprio objeto router permitindo chamada de métodos em corrente
    return $this;
  }

  /**
   * Atalho para a função _add() pré-associada ao método GET
   *
   * @param string $path Caminho a ser associado
   * @param callable $function Função a ser associada
   *
   * @return \Router
   */
  public function get($path, callable $function) {
    return $this->_add('GET', $path, $function);
  }

  /**
   * Atalho para a função _add() pré-associada ao método POST
   *
   * @param string $path Caminho a ser associado
   * @param callable $function Função a ser associada
   *
   * @return \Router
   */
  public function post($path, callable $function) {
    return $this->_add('POST', $path, $function);
  }

  /**
   * Atalho para a função _add() pré-associada ao método UPDATE
   *
   * @param string $path Caminho a ser associado
   * @param callable $function Função a ser associada
   *
   * @return \Router
   */
  public function update($path, callable $function) {
    return $this->_add('UPDATE', $path, $function);
  }

  /**
   * Atalho para a função _add() pré-associada ao método DELETE
   *
   * @param string $path Caminho a ser associado
   * @param callable $function Função a ser associada
   *
   * @return \Router
   */
  public function delete($path, callable $function) {
    return $this->_add('DELETE', $path, $function);
  }
}