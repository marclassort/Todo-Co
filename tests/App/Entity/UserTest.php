<?php

namespace Tests\App\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    private const USERNAME_NOT_BLANK_MESSAGE = 'Vous devez saisir un nom d\'utilisateur.';
    private const EMAIL_NOT_BLANK_MESSAGE = 'Vous devez saisir une adresse email.';
    private const EMAIL_CONSTRAINT_MESSAGE = 'Le format de l\'adresse n\'est pas correct.';
    private const VALID_USERNAME_VALUE = 'anonyme';
    private const VALID_PASSWORD_VALUE = 'test';
    private const VALID_EMAIL_VALUE = 'marc.lassort@gmail.com';
    private const INVALID_EMAIL_VALUE = 'fakeAdresse';

    public ValidatorInterface $validator;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $this->validator = $container->get('validator');
    }

    public function testUserEntityIsValid()
    {
        $user = new User();
        $user->setUsername(self::VALID_USERNAME_VALUE);
        $user->setPassword(self::VALID_PASSWORD_VALUE);
        $user->setEmail(self::VALID_EMAIL_VALUE);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $this->getValidationErrors($user, 0);
    }

    public function testUserEntityIsInvalidBecauseNoUsernameEntered()
    {
        $user = new User();
        $user->setPassword(self::VALID_PASSWORD_VALUE);
        $user->setEmail(self::VALID_EMAIL_VALUE);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::USERNAME_NOT_BLANK_MESSAGE, $errors[0]->getMessage());
    }

    public function testUserEntityIsInvalidBecauseNoEmailEntered()
    {
        $user = new User();
        $user->setUsername(self::VALID_USERNAME_VALUE);
        $user->setPassword(self::VALID_PASSWORD_VALUE);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::EMAIL_NOT_BLANK_MESSAGE, $errors[0]->getMessage());
    }

    public function testUserEntityIsInvalidBecauseInvalidEmailEntered()
    {
        $user = new User();
        $user->setUsername(self::VALID_USERNAME_VALUE);
        $user->setEmail(self::INVALID_EMAIL_VALUE);
        $user->setPassword(self::VALID_PASSWORD_VALUE);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::EMAIL_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }

    private function getValidationErrors(User $user, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);

        $this->assertCount($numberOfExpectedErrors, $errors);

        return $errors;
    }
}
