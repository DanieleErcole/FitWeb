
<?php

    class TabellaAllenamento {

        public $id;
        public $tableName;
        public $hour;
        public $author;
        public $course;

        public function __construct($attrs) {
            $this->id = $attrs["Id"];
            $this->tableName = $attrs["NomeTabella"];
            $this->hour = $attrs["OraInizio"];
            $this->author = $attrs["Utente"];
            $this->course = $attrs["Corso"];
        }

    }

?>
