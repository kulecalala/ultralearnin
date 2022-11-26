<?php

  namespace App\Db;

  class Pagination {

    /**
     * Numero maximo de registros por Pagina
     * @var integer
     */
    private $limit;

    /**
     * Quantidade total de resultados do banco
     * @var integer
     */
    private $results;

    /**
     * Quantidade de paginas
     * @var integer
     */
    private $pages;

    /**
     * Pagina actual
     * @var integer
     */
    private $currentPage;

    /**
     * Construtor da classe
     * @param integer $results
     * @param integer $currentPage
     * @param integer $limit
     */
    public function __construct($results, $currentPage = 1, $limit = 10) {
      $this->results     = $results;
      $this->limit       = $limit;
      $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
      $this->calculate();
    }

    /**
     * Metodo responsavel por calcular a paginacao
     */
    private function calculate() {
      // Calcula o total de paginas
      $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

      // Verifica se a pagina actual nao excede o numero de paginas
      $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Metodo responsavel por retornar a clausula limit da SQL
     * @return string
     */
    public function getLimit() {
      $offset = ($this->limit * ($this->currentPage - 1));
      return $offset.','.$this->limit;
    }

    /**
     * Metodo responsavel por retornar as opcoes de paginas disponiveis
     * @return array
     */
    public function getPages() {
      // Nao retorna paginas
      if ( $this->pages == 1) return [];

      // paginas
      $paginas = [];

      for( $i = 1; $i <= $this->pages; $i++ ) {
        $paginas[] = [
          'pagina' => $i,
          'actual' => $i == $this->currentPage
        ];
      }

      return $paginas;

    }


  }










  /// Comentario
