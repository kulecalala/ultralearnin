<?php

  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class MeusProfessores {
    public $id;
    public $user_id;
    public $id_proff;

    public function cadastrar() {
      $obMeusProfessores = new DatBase('meus_professores');

      $this->id = $obMeusProfessores->insert(
        [
          'user_id'  => $this->user_id,
          'id_proff' => $this->id_proff
        ]
      );

      return true;
    }

    public function actualizar() {
      return (new DataBase('meus_professores'))->update('id = '. $this->id, [
        'user_id'  => $this->user_id,
        'id_proff' => $this->id_proff
      ]);
    }

    public function deletar() {
      return (new DataBae('meus_professores'))->delete('id = '. $this->id);
    }

    public static function getMeusProfessores( $where = null, $order = null, $limit = null) {
      return (new DataBase('meus_professores'))->select($where, $order, $limit)
                                               ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQuantidadeDeProfessores ( $where = null ) {
      return (new DataBase('meus_professores'))->select($where, null, null, 'COUNT(*) as qtde')
                                               ->fetchObject()
                                               ->qtde;
    }

    public static function getMeuProfessor( $id ) {
      return (new DataBase('meus_professores'))->select('id = '. $id)
                                               ->fetchObject(self::class);
    }
  }
