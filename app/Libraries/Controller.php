<?php

  class Controller
  {
    public function model($model)
    {
      // Chama o arquivo do modelo.
      require_once("../app/Models/".$model.".php");

      return new $model;
    }

    public function view($view, $dados = [])
    {
      // Armazena o arquivo da view.
      $s_arquivo_view = "../app/Views/".$view.".php";

      // Verifica se o arquivo da view existe.
      if(file_exists($s_arquivo_view))
      {
        require_once($s_arquivo_view);
      }
      else
      {
        die("O arquivo de view não existe.");
      }
    }
  }

?>
