<?php

namespace app\helpers;

/**
 * Interface Ilogin
 * @package App\Interfaces
 */
interface Ilogin
{
    /**
     * Metodo da interface para logar
     * @param $db
     * @param $email
     * @param $password
     * @return mixed
     */
    public function logar($db, $email, $password);
}
