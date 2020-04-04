<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 03.04.20
 * Time: 18:03
 */

namespace App\Dz8;

/**
 * Class User
 * @package App\Dz8
 */
class User extends Model
{
    /**
     * @var int
     *
     * @Column(type="autoincrement")
     */
    private $id;

    /**
     * @var string
     *
     * @Column
     */
    private $name;

    /**
     * @var string
     *
     * @Column
     */
    private $email;

    /**
     * @var int
     *
     * @Column
     */
    private $status;

    /**
     * @var string
     *
     * @Column(name="created_at", type="date")
     */
    private $createdAt;

    /**
     * @return string
     */
    public static function getTable(): string
    {
        return 'users';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
     */
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}