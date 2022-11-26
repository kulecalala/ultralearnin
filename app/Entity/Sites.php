<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Sites {
    public $id;
    public $user;
    public $titulo;
    public $link;
    public $descricao;
    public $imagem;
    public $relacionado_a;
    public $actualizado_em;

    public function cadastrar() {
      $data = date('Y-m-d');
      $this->actualizado_em = $data;

      $obDatabase = new DataBase('sites');

      $this->id = $obDatabase->insert(
        [
          'user'           => $this->user,
          'titulo'         => $this->titulo,
          'link'           => $this->link,
          'descricao'      => $this->descricao,
          'imagem'         => $this->imagem,
          'relacionado_a'  => $this->relacionado_a,
          'actualizado_em' => $this->actualizado_em
        ]
      );

      return true;
    }

    public function actualizar(){
      return (new DataBase('sites'))->update('id = '. $this->id .' AND user = '. $this->user,
      [
        'titulo'         => $this->titulo,
        'link'           => $this->link,
        'descricao'      => $this->descricao,
        'imagem'         => $this->imagem,
        'relacionado_a'  => $this->relacionado_a,
        'actualizado_em' => $this->actualizado_em
      ] );
    }

    public function excluir() {
      return (new DataBase('sites'))->delete('id = '. $this->id .' AND user =  '. $this->user);
    }

    public static function getSites($where = null, $order = null, $limit = null ) {
      return (new Database('sites'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeSites( $where = null ) {
      return (new DataBase('sites'))->select($where, null, null, 'COUNT(*) as qtd')
                                     ->fetchObject()
                                     ->qtd;
    }

    public static function getSite($id) {
      return (new DataBase('sites'))->select('id = '. $id)
                                    ->fetchObject(self::class);
    }

  }
