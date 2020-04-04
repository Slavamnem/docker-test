<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 02.04.20
 * Time: 15:21
 */

namespace App\Helpers;

class PdoHelper
{
    public const DB_DRIVER = 'mysql';
    public const HOST = 'db';
    public const LOGIN = 'root';
    public const PASSWORD = 'slava1234';
    public const DB_NAME = 'docker_test';
    public const CHARSET = 'utf8';

    /**
     * @return \PDO
     */
    public static function getPdo(): \PDO
    {
        return new \PDO(self::getDsn(), self::LOGIN, self::PASSWORD, self::getPdoOptions());
    }

    /**
     * @return string
     */
    private static function getDsn(): string
    {
        return self::DB_DRIVER . ":host=" . self::HOST . ";dbname=" . self::DB_NAME .";charset=" . self::CHARSET;
    }

    /**
     * @return array
     */
    private static function getPdoOptions(): array
    {
        return [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }
}