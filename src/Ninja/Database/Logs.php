<?php

namespace Ninja\Database;

abstract class Logs {
    protected function getDate(){
        $date = date("d-m-Y");
        $heure = date("H:i");
        return $date . " " . $heure;
    }

    protected function writeActionLogs($file, $text, $time = 0){
        $date = $this->getDate();
        $line = $date . " || => " . $text . " || => " . number_format($time * 1000, 2) . " ms \n";

        $filename = 'logs/' . $file;
        if (!is_dir(dirname($filename)))
        {
            mkdir(dirname($filename), 0755, true);
        }
        $file_log = fopen($filename, 'a');
        fwrite($file_log, $line);
        fclose($file_log);
    }

    protected function writeRequestLog($log, $time) {
        $this->writeActionLogs('request.log', $log, $time);
    }

    protected function writeErrorLog($log) {
        $this->writeActionLogs('error.log', $log);
    }

}
