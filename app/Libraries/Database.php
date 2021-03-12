<?php

  class Database
  {
    private $s_host;
    private $s_usuario;
    private $s_senha;
    private $s_db;
    private $i_porta;
    private $dbh;
    private $stmt;

    public function __construct()
    {
      // Pega as configurações do arquivo de configurações do banco de dados.
      $this->s_host = DB_HOST;
      $this->s_usuario = DB_USER;
      $this->s_senha = DB_PASS;
      $this->s_db = DB_DB;
      $this->i_porta = DB_PORTA;

      // Monta o DSN para conexão.
      $s_dsn = "mysql:host=".$this->s_host.";port=".$this->i_porta.";dbname=".$this->s_db.";charset=utf8;";

      // Armazena as opções da conexão PDO.
      $a_opcoes = [PDO::ATTR_PERSISTENT => true,
                   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

      // Tenta iniciar a conexão com o banco de dados.
      try
      {
        $this->dbh = new PDO($s_dsn, $this->s_usuario, $this->s_senha, $a_opcoes);;
      }
      catch(PDOException $e)
      {
        print "Error!: " . $e->getMessage() . "<br/>";
        die;
      }
    }

    /**
     * Prepara a query na classe do PDO.
     *
     * @param string $sql Query SQL que será executada
     *
     * @return void
     *
     */
    public function query($sql)
    {
      $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Vincula o valor um parâmetro e um tipo.
     *
     * @param string $parametro Nome do parâmetro que receberá o valor
     * @param mixed  $valor     Valor que será atribuído ao parâmetro
     * @param mixed  $tipo      Tipo do valor
     *
     * @return void
     *
     */
    public function bind($parametro, $valor, $tipo = null)
    {
      // Verifica se o tipo é null.
      if(is_null($tipo))
      {
        // Identifica qual é o tipo do valor recebido para definir o tipo dentro do PDO.
        switch(true)
        {
          case is_int($valor):
            $tipo = PDO::PARAM_INT;
            break;
          case is_bool($valor):
            $tipo = PDO::PARAM_BOOL;
            break;
          case is_null($valor):
            $tipo = PDO::PARAM_NULL;
            break;
          default:
            $tipo = PDO::PARAM_STR;
        }
      }

      // Efetua o bind das informações com a função do PDO.
      $this->stmt->bindValue($parametro, $valor, $tipo);
    }

    /**
     * Executa a query informada dentro do stmt.
     *
     * @return mixed
     *
     */
    public function execute()
    {
      return $this->stmt->execute();
    }

    /**
     * Retorna o resultado único da execução da query.
     *
     * @return object
     *
     */
    public function result()
    {
      $this->execute();

      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Retorna os resultados da execução da query.
     *
     * @return object
     *
     */
    public function results()
    {
      $this->execute();

      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Conta o total de resultados da execução da query.
     *
     * @return int
     *
     */
    public function rowCount()
    {
      return $this->stmt->rowCount();
    }

    /**
     * Pega o último id inserido no banco de dados.
     *
     * @return int
     *
     */
    public function lastInsertId()
    {
      return $this->dbh->lastInsertId();
    }
  }

?>
