<?php

namespace App\Helpers;

use Closure;
use Illuminate\Support\Facades\Log;

class ExceptionController
{
    /**
     * Exécute un callback dans un try/catch sans bloquer l exécution
     * @param Closure $callback le code à traiter
     * @param $fallback // valeur renvoyée en cas d'erreur
     * @param string|null $message Message optionnel pour les logs
     * @return mixed|null
     */
    public static function run(Closure $callback,  $fallback = null, string $message = null ): mixed
    {
        try{
            return $callback();
        }catch (\Exception $e){
            Log::error($message?? "Exception handler error: ".$e->getMessage());
            return $fallback;
        }
    }
}
