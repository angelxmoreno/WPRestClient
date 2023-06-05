<?php

declare(strict_types=1);

namespace WPRestClient\Auth;

use Psr\Http\Message\RequestInterface;
use WPRestClient\Core\AuthInterface;

class BasicAuth implements AuthInterface
{
    protected string $username;
    protected string $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return BasicAuth
     */
    public function setUsername(string $username): BasicAuth
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return BasicAuth
     */
    public function setPassword(string $password): BasicAuth
    {
        $this->password = $password;
        return $this;
    }


    public function withAuth(RequestInterface $request): RequestInterface
    {
        $value = 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword());
        return $request->withHeader('Authorization', $value);
    }
}
