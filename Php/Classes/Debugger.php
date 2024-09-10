<?php

    class Debugger {

        public static function log($paramNames, $params) {
            $fp = fopen(__DIR__."/debug.txt", "a");
            for($i = 0; $i < count($params); $i++)
                fwrite($fp, $paramNames[$i].": ".$params[$i]);
            fclose($fp);
        }

        public static function logErr($errString) {
            $fp = fopen(__DIR__."/debug.txt", "a");
            fwrite($fp, "--".$errString."\r\n");
            fclose($fp);
        }

    }

?>
