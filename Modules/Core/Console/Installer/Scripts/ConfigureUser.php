<?php

namespace Modules\Core\Console\Installer\Scripts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Console\Installer\SetupScript;
use Modules\User\Entities\User;

class ConfigureUser implements SetupScript
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * Fire the install script.
     *
     * @param Command $command
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $this->command = $command;

        $this->command->info('User creation');

        $name = $this->askUserName();
        $email = $this->askUserEmail();
        $password = $this->askUserPassword();

        User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => Hash::make($password),
            ]);

        $command->info('User successfully created');
    }

    /**
     * Ask user admin name.
     *
     * @return string
     */
    protected function askUserName()
    {
        do {
            $name = $this->command->ask('Enter user name', 'Richard');
            if ($name == '') {
                $this->command->error('User name is required');
            }
        } while (!$name);

        return $name;
    }

    /**
     * Ask user admin email.
     *
     * @return string
     */
    protected function askUserEmail()
    {
        do {
            $email = $this->command->ask('Enter user email', 'richard@rich.com');
            if ($email == '') {
                $this->command->error('User email is required');
            }
        } while (!$email);

        return $email;
    }

    /**
     * Ask user admnin password.
     *
     * @return string
     */
    protected function askUserPassword()
    {
        do {
            $password = $this->command->ask('Enter user password', 'secret');
            if ($password == '') {
                $this->command->error('User password is required');
            }
        } while (!$password);

        return $password;
    }
}
