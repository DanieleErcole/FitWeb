
<?php

    class Esercizio {

        public $id;
        public $nome;
        public $tempo;
        public $pesi;
        public $ripetizioni;
        public $serie;
        public $riposo;

        public function __construct($attrs) {
            $this->id = $attrs["Id"];
            $this->nome = $attrs["Nome"];
            $this->tempo = $attrs["Tempo"];
            $this->pesi = $attrs["Pesi"];
            $this->ripetizioni = $attrs["Ripetizioni"];
            $this->serie = $attrs["Serie"];
            $this->riposo = $attrs["Riposo"];
        }

    }

?>
