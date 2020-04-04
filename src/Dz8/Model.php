<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 03.04.20
 * Time: 17:46
 */

namespace App\Dz8;

use App\Helpers\PdoHelper;

abstract class Model
{
    /**
     * @var AnnotationHelper
     */
    private $annotationHelper;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->annotationHelper = new AnnotationHelper();
    }

    /**
     * @return mixed
     */
    abstract function getId();

    /**
     * @return string
     */
    abstract static function getTable(): string;

    /**
     * @param $id
     * @return static|null
     */
    public static function find($id)
    {
        $result = self::getQueryResult(
            "SELECT * FROM " . static::getTable() . " WHERE id = :id",
            [':id' => $id]
        );

        $instance = new static();

        foreach ($result[0] as $field => $value) {
            $setter = 'set' . self::convertToCamelCase($field);
            $instance->$setter($value);
        }

        return $instance;
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        try {
            $modelColumns = $this->annotationHelper->getModelColumns($this);
            $modelFields = implode(', ', array_keys($modelColumns));

            $params = implode(', ', array_map(function($key) { return ":" . $key; }, array_flip($modelColumns)));
            $paramsValues = array_flip(array_map(function($key) { return ":" . $key; }, array_flip($modelColumns)));

            self::getQueryResult("INSERT INTO users (" . $modelFields . ") VALUES(" . $params . ")", $paramsValues);
        } catch (\Exception $exception) {
            var_dump($exception);

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        try {
            $modelColumns = $this->annotationHelper->getModelColumns($this);

            $values = [];

            foreach ($modelColumns as $field => $value) {
                $values[] = $field . " = " . ":" . $field;
            }

            $query = "UPDATE " . static::getTable() . " SET " . implode(', ', $values) . " WHERE id = :id";

            $modelColumns = array_flip(array_map(function($key) { return ":" . $key; }, array_flip($modelColumns)));

            self::getQueryResult($query, [':id' => $this->getId()] + $modelColumns);
        } catch (\Exception $exception) {
            var_dump($exception);

            return false;
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function delete($id): bool
    {
        try {
            self::getQueryResult(
                "DELETE FROM " . static::getTable() . " WHERE id = :id",
                [':id' => $id]
            );
        } catch(\Exception $exception) {
            var_dump($exception);

            return false;
        }

        return true;
    }

    /**
     * @param $query
     * @param $params
     * @return array|null
     */
    private static function getQueryResult($query, $params = []): ?array
    {
        $pdo = PdoHelper::getPdo();

        $smtp = $pdo->prepare($query);

        foreach ($params as $key => $value) {
            $smtp->bindValue($key, $value);
        }

        $smtp->execute();

        return $smtp->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $str
     * @return string
     */
    private function convertToCamelCase($str): string
    {
        return implode('',
            array_map(function($part){
                return ucfirst($part);
            },
            explode('_', $str))
        );
    }
}
