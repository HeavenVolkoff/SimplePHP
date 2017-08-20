<?php

/**
 * ################################ env.php ####################################
 *  Arquivo que define constante globais do usuário que devem estar disponíveis
 *  em todos os arquivos durante a execução do PHP.
 *
 *  ATENÇÃO: Esse arquivo deve ser customizado para cada ambiente que o projeto
 *           for ser executado
 *
 * @autor: Vítor Augusto da Silva Vasconcellos
 * @grupo: NewsNet
 * #############################################################################
 */

/**
 * Define se o ambiente que o projeto está sendo executado é de desenvolvimento
 * ou de produção, isso influência o comportamento de alguns componentes quanto
 * ao nível de detalhamento que as informações de depuração serão apresentadas
 */
define('DEVELOPMENT', true);