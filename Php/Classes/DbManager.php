<?php

    require_once 'Debugger.php';

    class DbManager {

        private $dbHost;
        private $dbUsername;
        private $dbPassword;
        private $database;
        private $connectionObj;

        private $queryString;

        /**
         * Costruttore degli oggetti di classe DBManager
         */
        public function __construct($dbHost, $dbUsername, $dbPassword, $database) {
            $this->dbHost = $dbHost;
            $this->dbUsername = $dbUsername;
            $this->dbPassword = $dbPassword;
            $this->database = $database;
            $this->queryString = "";
            $this->connectionObj = $this->connectToDb();
        }

        /**
         * Compone il predicato WHERE di una query
         */
        public function where($conditions, $logicOperators) {
            $whereString = " WHERE ";
            for($i = 0, $c = 0; $i < count($conditions); $i++) {
                if($i == 0)
                    $whereString .= $conditions[$i];
                else {
                    $whereString .= " ".$logicOperators[$c]." ".$conditions[$i];
                    $c++;
                }
            }

            if(count($logicOperators) == 0 && count($conditions) == 0)
                $whereString = "";
            else if($whereString == " WHERE " && count($logicOperators) == 0)
                $whereString .= $conditions[0];

            $this->queryString .= $whereString;
            //Debugger::logErr($whereString);
            return $this;
        }

        /**
         * Operazione SELECT
         */
        public function select($attrs, $tables) {
            $queryString = "SELECT ".implode(", ", $attrs)." FROM ".implode(", ", $tables);

            //Debugger::logErr($queryString);
            $this->queryString = $queryString;
            return $this;
        }

        /**
         * Operazione INSERT
         */
        public function insert($table, $attributes, $values) {
            $queryString = "INSERT INTO ".$table."(".implode(", ", $attributes).
            ") VALUES(".implode(", ", $values).")";

            //Debugger::logErr($queryString);
            $this->queryString = $queryString;
            return $this;
        }

        /**
         * Operazione DELETE
         */
        public function delete($table) {
            $queryString = "DELETE FROM ".$table;
            //Debugger::logErr($queryString);
            $this->queryString = $queryString;
            return $this;
        }

        /**
         * Operazione UPDATE
         */
        public function update($table, $attributes, $values) {
            $queryString = "UPDATE ".$table." SET ";

            $setString = "";
            for($i = 0; $i < count($attributes); $i++) {
                if($i == count($attributes) - 1)
                    $comma = "";
                else $comma = ", ";
                $setString .= $attributes[$i]." = ".$values[$i].$comma;
            }
            $queryString .= $setString;

            //Debugger::logErr($queryString);
            $this->queryString = $queryString;
            return $this;
        }

        /**
         * Esegue la query preparata precedentemente
         */
        public function queryDb() {
            if($this->queryString == "")
                return false;

            $str = $this->queryString;
            $this->queryString = "";
            Debugger::logErr($str);
            return $this->connectionObj->query($str);
        }

        /**
         * Clausole opzionali
         */
        private function limit($limit) {
            $this->queryString .= 'LIMIT '.$limit;
            return $this;
        }

        private function offset($offset) {
            $this->queryString .= 'OFFSET '.$offset;
            return $this;
        }

        private function orderBy($orderby) {
            $this->queryString .= 'ORDER BY '.$orderby;
            return $this;
        }

        private function groupBy($groupby) {
            $this->queryString .= 'ORDER BY '.$groupby;
            return $this;
        }

        public function getLastId($table) {
            $this->queryString = "SELECT Id FROM ".$table." WHERE Id = (SELECT MAX(ID) FROM ".$table.")";
            return $this->queryDb();
        }

        /**
         * Getter della query
         */
        public function getQueryString() {
            return $this->queryString;
        }

        /**
         * Chiude la connessione con il database
         */
        public function closeDb() {
            $this->connectionObj->close();
        }

        /**
         * Apre la connessione con il database
         */
        private function connectToDb() {
            return new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->database);
        }

    }

?>
