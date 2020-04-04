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
 *
 * @method static self findById
 * @method static self findByEmailAndByStatus
 * @method static self findBetweenCreatedAt
 * @method static self findBetweenCreatedAtAndByStatus
 * @method static self findBetweenCreatedAtAndInStatus
 */
class UserV1
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
        switch ($name) {
            case 'findById':
                $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = :id";

                return self::getQueryResult($query, [':id' => $arguments[0]]);
            case 'findByEmailAndByStatus':
                $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE email = :email AND status = :status";

                return self::getQueryResult($query, [
                    ':email'  => $arguments[0],
                    ':status' => $arguments[1]
                ]);
            case 'findBetweenCreatedAt':
                $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date";

                return self::getQueryResult($query, [
                    ':start_date' => $arguments[0],
                    ':end_date'   => $arguments[1]
                ]);
            case 'findBetweenCreatedAtAndByStatus':
                $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date AND status = :status";

                return self::getQueryResult($query, [
                    ':start_date' => $arguments[0],
                    ':end_date'   => $arguments[1],
                    ':status'     => $arguments[2]
                ]);
            case 'findBetweenCreatedAtAndInStatus':
                $statuses = array_flip(array_map(
                    function($statusKey) {
                        return ':status_' . $statusKey;
                    },
                    array_flip($arguments[2]))
                );
                $statusesString = implode(', ', array_keys($statuses));

                $query = "SELECT * FROM " . self::TABLE_NAME . " WHERE created_at BETWEEN :start_date AND :end_date AND status IN(" . $statusesString . ")";

                return self::getQueryResult($query, array_merge([
                    ':start_date' => $arguments[0],
                    ':end_date'   => $arguments[1],
                ], $statuses));
            default:
                return "Requested method doesn't exists";
        }
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