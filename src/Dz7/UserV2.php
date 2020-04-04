<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 02.04.20
 * Time: 15:15
 */

namespace App\Dz7;

use App\Helpers\PdoHelper;

/**
 * Class User
 * @package App\Dz7
 */
class UserV2
{
    public const TABLE_NAME = 'users';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserV1
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserV1
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserV1
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return UserV1
     */
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return UserV1
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::$name(...$arguments);
    }

    /**
     * @param $id
     * @return array|null
     */
    private static function findById($id): ?array
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = :id";

        return self::getQueryResult($query, [':id' => $id]);
    }

    /**
     * @param $email
     * @param $status
     * @return array|null
     */
    private static function findByEmailAndByStatus($email, $status): ?array
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE email = :email AND status = :status";

        return self::getQueryResult($query, [
            ':email'  => $email,
            ':status' => $status
        ]);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return array|null
     */
    private static function findBetweenCreatedAt($startDate, $endDate): ?array
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date";

        return self::getQueryResult($query, [
            ':start_date' => $startDate,
            ':end_date'   => $endDate
        ]);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $status
     * @return array|null
     */
    private static function findBetweenCreatedAtAndByStatus($startDate, $endDate, $status): ?array
    {
        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date AND status = :status";

        return self::getQueryResult($query, [
            ':start_date' => $startDate,
            ':end_date'   => $endDate,
            ':status'     => $status
        ]);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $statuses
     * @return array|null
     */
    private static function findBetweenCreatedAtAndInStatus($startDate, $endDate, $statuses): ?array
    {
        $statuses = array_flip(array_map(function($statusKey){ return ':status_' . $statusKey; }, array_flip($statuses)));
        $statusesString = implode(', ', array_keys($statuses));

        $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date AND status IN(" . $statusesString . ")";

        return self::getQueryResult($query, array_merge([
            ':start_date' => $startDate,
            ':end_date'   => $endDate,
        ], $statuses));
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
}