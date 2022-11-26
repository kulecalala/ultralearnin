<?php
  namespace App\Entity;

  use \App\Db\DataBase;

  use \PDO;
  use \PDOStatement;

  class Users {
    public $id;
    public $usename;
    public $useremail;
    public $userpassword;
    public $userdata;
    public $autenticationcod;
    public $path;
    public $userstatus;

    /**
     * Metodo responsavel por adicionar cadastrar novos utilizadores
     * @return true
     */
    public function cadastrar(){
      $code = 'mfkboc';
      $this->userdata = date('Y-m-d H:i:s');
      $this->userstatus = 'a';

      $obDataBase = new DataBase('usuarios');

      $this->id = $obDataBase->insert(
        [
          'username'         => $this->username,
          'useremail'        => $this->useremail,
          'userpassword'     => $this->userpassword,
          'userdata'         => $this->userdata,
          'autenticationcod' => $this->autenticationcod,
          'path'             => $this->path,
          'userstatus'       => $this->userstatus
        ]
      );

      return true;

    }

    /**
     * Metodo responsavel por actualizar os dados do utilizadores
     * @return true
     */
    public function actualizar() {
      return (new DataBase('usuarios'))->update('id = '. $this->id, [
        'username'         => $this->username,
        'useremail'        => $this->useremail,
        'userpassword'     => $this->userpassword,
        'userdata'         => $this->userdata,
        'autenticationcod' => $this->autenticationcod,
        'path'             => $this->path,
        'userstatus'       => $this->userstatus
      ]);
    }

    /**
     * Metodo responsavel por excluir usuarios
     * @return true
     */
    public function excluir(){
      return (new DataBase('usuarios'))->delete('id = '. $this->id);
    }

    /**
     * Metodo responsavel por buscar todos os utilizadores
     * @return array
     */
    public static function getUsers( $where = null, $order = null, $limit = null ) {
      return (new DataBase('usuarios'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Metodo responsavel por buscar usuario
     * @return array
     */
    public static function getUser( $id ){
      return (new DataBase('usuarios'))->select('id = '. $id)->fetchObject(self::class);
    }


  }
