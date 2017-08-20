<?php

/**
 * ############################# Singleton.php #################################
 *  Arquivo de definição da classe abstrata Singleton
 *
 * @autor: Vítor Augusto da Silva Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

/**
 * =============================================================================
 *  abstract class:
 *    É um tipo especial de classe que não pode ser instânciada. Seu propósito é
 *    definir um comportamento genérico que será estendido por outras classes
 *    filhas, sendo essas, então, instanciáveis
 * =============================================================================
 * get_called_class:
 *    Retorna o nome da classe à qual a função sendo executada pertence
 * =============================================================================
 */

/**
 * Classe que define o comportamento de um Singleton. Singleton é um padrão de
 * design de classe que só permite que uma única instância seja criada e
 * utilizada durante a execução da aplicação.
 *
 * saiba mais: https://pt.wikipedia.org/wiki/Singleton
 */
abstract class Singleton {

  // Membro privado que armazena as instâncias das classes filhas
  private static $_instances = [];

  /**
   * Construtor privado impede múltipla instanciação da classe através do
   * operador `new`
   */
  final private function __construct() {}

  /**
   * Método privado `clone` impede a clonagem de uma instância através do
   * operador `clone`
   */
  final private function __clone() {}

  /**
   * Método privado `wakeup` impede a desserialização da instância através da
   * função global `unserialize`
   */
  final private function __wakeup() {}

  /**
   * Função pública que permite o acesso externo à instância única de cada
   * classe filha
   *
   * @return mixed Instância única da classe
   */
  final public static function getInstance() {
    $className = get_called_class();

    // Instância a classe, caso ela ainda não tenha sido instânciada.
    if (!array_key_exists($className, self::$_instances)) {
      self::$_instances[$className] = new static();
    }

    // Retorna a instância da classe
    return self::$_instances[$className];
  }
}