<?php

namespace App\Controller\Utility;

class VarDumpController
{

    public static function pretty($whatevs) {

        echo '<pre>';
        var_dump($whatevs);
        echo '</pre>';

    }

}
