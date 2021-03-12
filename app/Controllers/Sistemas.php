<?php

  class Sistemas extends Controller
  {
    /**
     * Controller da página principal do portal.
     *
     * @return void
     *
     */
    public function home()
    {
      $dados = [];

      $this->view("sistemas/home", $dados);
    }
  }

?>
