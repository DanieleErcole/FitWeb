<?php

    require_once 'DbManager.php';
    require_once 'Giorno.php';
    require_once 'Esercizio.php';
    require_once 'Muscolo.php';
    require_once 'TabellaAllenamento.php';
    require_once 'Utente.php';
    require_once 'Debugger.php';

    class EntityController {

        private $database;
        private $attrs;
        private $type;
        public $tables;

        public function __construct($tables, $type) {
            $this->database = new DbManager("localhost", "fitweb", "", "my_fitweb");
            $this->tables = $tables;
            $this->type = $type;
        }

        public function create($params) {
            $attrNames = array();
            $attrValues = array();

            foreach($params as $key => $value) {
                $attrNames[] = $key;
                $attrValues[] = $value;
            }

            $this->database->insert($this->tables[0], $attrNames, $attrValues)->queryDb();
        }

        public function find($attr, $attrName) {
            $conditions = array($attrName." = ".$attr);
            $queryResult = $this->database->select(array("*"), $this->tables)->where($conditions, array())->queryDb();

            if($queryResult && $queryResult->num_rows > 0) {
                $obj = $queryResult->fetch_assoc();
                foreach($obj as $key => $value)
                    $this->attrs[$key] = $value;
                $queryResult->close();
            }
            return $this->returnData();
        }

        public function findWhere($conditions, $operators = null, $attrs = null) {
            $queryResult = $this->database->select($attrs == null ? array("*") : $attrs, $this->tables)->where($conditions, $operators != null ? $operators : array())->queryDb();

            $array = array();
            while($queryResult && $obj = $queryResult->fetch_assoc()) {
                foreach($obj as $key => $value)
                    $this->attrs[$key] = $value;
                $array[] = $this->returnData();
            }

            if($queryResult)
                $queryResult->close();

            return $array;
        }

        public function findWhereAssoc($attrs, $conditions, $operators = null) {
            //Se non ho messo nel costruttore 'dbObj' questo metodo ritorna false
            if($this->type != "dbObj")
                return false;

            $queryResult = $this->database->select($attrs != null ? $attrs : array('*'), $this->tables)->where($conditions, $operators != null ? $operators : array())->queryDb();

            $array = array();
            while($queryResult && $obj = $queryResult->fetch_assoc()) {
                foreach($obj as $key => $value)
                    $this->attrs[$key] = $value;
                $array[] = $this->returnData();
            }

            if($queryResult)
                $queryResult->close();

            return count($array) > 0 ? $array : false;
        }

        public function update($attrs, $values, $conditions, $operators) {
            $this->database->update($this->tables[0], $attrs, $values)->where($conditions, $operators != null ? $operators : array())->queryDb();
        }

        public function delete($conditions, $operators = null) {
            $this->database->delete($this->tables[0])->where($conditions, $operators != null ? $operators : array())->queryDb();
        }

        private function returnData() {
            switch($this->type) {
                case 'giorno':
                    return new Giorno($this->attrs);
                    break;
                case 'tabellaAllenamento':
                    return new TabellaAllenamento($this->attrs);
                    break;
                case 'esercizio':
                    return new Esercizio($this->attrs);
                    break;
                case 'muscolo':
                    return new Muscolo($this->attrs);
                    break;
                case 'utente':
                    return new Utente($this->attrs);
                    break;
                case 'dbObj':
                    return $this->attrs;
                    break;
            }
        }

        public function getLastId() {
            $result = $this->database->getLastId($this->tables[0]);
            return ($result->fetch_assoc())["Id"];
        }

        public function closeConnection() {
            $this->database->closeDb();
        }

    }

?>
