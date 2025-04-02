<?php
require_once './app/trait/AuthTrait.php';
require_once './app/repositories/UserRepository.php';
class AuthService {

    use AuthTrait;

    public function setUser(User $user): void {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    
        $_SESSION['user'] = serialize($user);
    }
    
    public function getUser(): ?User {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    
        $user = $_SESSION['user'] ?? null;
    
        if ($user) {
            $user = unserialize($user);
            if ($user instanceof User) {
                return $user;
            }
        }
        return null;
    }

    public function logout(): void {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
        
        $_SESSION = [];
    
        session_destroy();
    
        header("Location: /index.php");
        exit();
    }
    

    public function isLoggedIn(): bool {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
        return isset($_SESSION['user']);
    }

    public function login(string $email, string $password): bool
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByEmail($email);

        if ($user && $password == $userRepository->getPasswordFromEmail($email)) {
            $this->setUser($user);
            return true;
        }

        return false;
    }

    public function register(User $user, string $password): bool
    {
        $userRepository = new UserRepository();
        return $userRepository->createUser($user, $password);
    }

    public function getUserById(int $id): ?User
    {
        $userRepository = new UserRepository();
        return $userRepository->getUserById($id);
    }

    public function updateUser(User $user): bool
    {
        $userRepository = new UserRepository();
        return $userRepository->updateUser($user);
    }

    public function deleteUser(int $id): bool
    {
        $userRepository = new UserRepository();
        return $userRepository->deleteUser($id);
    }
    
}
