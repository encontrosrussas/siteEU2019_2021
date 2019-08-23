<?php

namespace app\helpers;

/**
 * Class Password
 * @package App\Classes
 */
class Password
{
    /**
     * Gera o HASH do Password
     * @param $password
     * @return string
     */
    public function hash_pass($password)
    {
        return hash('sha512', $password);
    }
    /**
     * Verifica se o Password esta Correto
     * @param $password
     * @param $hash
     * @return bool
     */
    public function verificarPassword($password, $hash)
    {
        return hash('sha512', $password) == $hash;
    }
}
