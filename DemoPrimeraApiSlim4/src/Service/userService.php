<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Exception\UserException;
use App\Repository\UserRepository;
use App\roles\Roles;
use App\Utils;
use Firebase\JWT\JWT;
use Slim\Psr7\UploadedFile;


final class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getOne(int $id){
        return $this->userRepository->getOneUser($id);
    }

    public function getAll() : array{
        return $this->userRepository->getAllUsers();
    }

    public function createUser (array $input):object{

        $newUser = json_decode((string) json_encode($input),false);
        $this->validateNewUser($newUser);
        $res = $this->validateEmail($newUser);
       
        if ($res === false){
            return $this->userRepository->createUser($newUser);
        }
    }

    private function validateNewUser(object $newUser){

        if(!isset($newUser->correo)){
            throw new UserException("FILL IN ALL THE FIELDS!",400);
        }

        if(empty($newUser->correo)){
            throw new UserException("FILL IN ALL THE FIELDS!",400);
        }
        

    }

    private function validateEmail(object $newUser){

        $res = $this->userRepository->validateEmail($newUser->correo);

        if($res > 0){
            throw new UserException("EMAIL GIVEN EXISTS,",400);
            return true;
        }
        
        return false;

    }

    public function update(array $input, int $id): object{

        $data = json_decode((string) json_encode($input), false);
    
        return $this->userRepository->update($data, $id);
    }

    public function delete(int $id): void{
        $this->userRepository->delete($id);
    }


}