<?php 

namespace Timon\PhpFramework\Authenticate;

interface AuthUserInterface
{

    public function getId(): ?int;
    public function getEmail(): string;

    public function getPassword(): string ;

}