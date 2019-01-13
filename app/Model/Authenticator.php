<?php
namespace App\Model;
use Nette;
use Nette\Security;
use Nette\Security\IIdentity;

/**
 * Users authenticator.
 */
class Authenticator implements Security\IAuthenticator
{
    use Nette\SmartObject;
    /** @var Nette\Database\Context */
    private $database;
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
    /**
     * Performs an authentication.
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials): IIdentity
    {
        [$email, $password] = $credentials;
        $row = $this->database->table('user')->where('email', $email)->fetch();
        if (!$row) {
            throw new Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);
        } elseif (!Security\Passwords::verify($password, $row->password_hash)) {
            throw new Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);
        }
        $arr = $row->toArray();
        unset($arr['password']);
        return new Security\Identity($row->id, null, $arr);
    }
}