<?php

    class Muscolo {

        public $id;
        public $nome;

        public function __construct($attrs) {
            $this->id = $attrs["Id"];
            $this->nome = $attrs["Nome"];
        }

    }

?>
