<?php

  class Rotes
  {
    // Armazena o controlador padrão.
    private $controller = "Sistemas";

    // Armazena a função padrão.
    private $function = "home";

    // Armazena os parâmetros.
    private $parameters = [];

    public function __construct()
    {
      // Armazena a URL em array.
      $a_url = $this->url() ? $this->url() : [0];

      // Verifica se o controlador da página existe.
      if(file_exists("../app/Controllers/".ucwords($a_url[0]).".php"))
      {
        $this->controller = ucwords($a_url[0]);

        unset($a_url[0]);
      }

      // Chama o arquivo do controlador.
      require_once("../app/Controllers/".$this->controller.".php");

      // Substitui o controlador padrão pelo controlador localizado.
      $this->controller = new $this->controller;

      // Verifica se a posição do array da URL existe.
      if(isset($a_url[1]))
      {
        // Verifica se a função existe dentro do controlador.
        if(method_exists($this->controller, $a_url[1]))
        {
          $this->function = $a_url[1];

          unset($a_url[1]);
        }
      }

      // Armazena os parâmetros da URL.
      $this->parameters = $a_url ? array_values($a_url) : [];

      call_user_func_array([$this->controller, $this->function], $this->parameters);
    }

    /**
     * Pega a URL da página.
     *
     * Utiliza a URL completa da página para efetuar manipulação nas informações.
     *
     * @return string
     *
     */
    private function url()
    {
      // Armazena a URL da página filtrando as informações.
      $s_url = filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);

      // Verifica se a variável esta setada.
      if(isset($s_url))
      {
        // Formata a URL removendo os espaços.
        $s_url = trim(rtrim($s_url, "/"));

        // Armazena a URL separado as páginas em um array.
        $a_url = explode("/", $s_url);

        return $a_url;
      }
    }
  }

?>
