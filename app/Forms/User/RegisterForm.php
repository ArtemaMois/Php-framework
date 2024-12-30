<?php 
namespace App\Forms\User;

use App\Entities\User;
use App\Services\UserService;

class RegisterForm
{
    private ?string $name;
    private string $email;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(
        private UserService $service
    ){}

    public function setFields(string $email, string $password, string $passwordConfirmation, ?string $name = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    } 

    public function getValidationErrors(): array
    {
        $errors = [];

        if(!empty($this->name) && strlen($this->name) > 50)
        {
            $errors[] = 'Максимальная длина имени - 50 символов';

        }

        if(empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $errors[] = 'Неверный формат электоронной почты';
        }
        
        if(empty($this->password) || strlen($this->password) < 8)
        {
            $errors[] = 'Минимальная длина пароля - 8 символов';            
        }

        if($this->password !== $this->passwordConfirmation)
        {
            $errors[] = 'Пароли не совпадают';
        }
        return $errors;
    }

    public function save(): User
    {
        $user =  User::create( $this->email, password_hash($this->password, PASSWORD_DEFAULT), $this->name, null, new \DateTimeImmutable());
        $user = $this->service->save($user); 
        return $user;
    }

    public function hasValidationErrors(): bool
    {
        return !empty($this->getValidationErrors());
    }
}