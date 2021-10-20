<?php

namespace Chuckbe\Chuckcms\Commands;

use Chuckbe\Chuckcms\Chuck\UserRepository;
use Chuckbe\Chuckcms\Models\User;
use Illuminate\Console\Command;

class GenerateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chuckcms:generate-super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates a super admin user.';

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * The user model implementation.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, User $user)
    {
        parent::__construct();

        $this->userRepository = $userRepository;

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('What is your name? ');
        $email = $this->ask('What is your email? ');
        $password = $this->secret('Enter a password ');

        // Validate user input
        $this->info('Validating your information and generating a new user...');

        $data = [
            'name'      => $name,
            'email'     => $email,
            'password'  => $password,
        ];

        $rules = [
            'name'      => 'required|max:185',
            'email'     => 'required|email',
            'password'  => 'required|min:8',
        ];

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            foreach ($messages->all() as $message) {
                $this->error($message);
            }
        } else {
            // create the user
            $user = $this->user->create([
                'name'     => $name,
                'email'    => $email,
                'token'    => $this->userRepository->createToken(),
                'password' => bcrypt($password),
                'active'   => 1,
            ]);
            // add role
            $user->assignRole('super-admin');
            $this->info('.         .');
            $this->info('..         ..');
            $this->info('...         ...');
            $this->info('.... AWESOME ....');
            $this->info('...         ...');
            $this->info('..         ..');
            $this->info('.         .');
            $this->info('.         .');
            $this->info('..         ..');
            $this->info('...         ...');
            $this->info('....   JOB   ....');
            $this->info('...         ...');
            $this->info('..         ..');
            $this->info('.         .');
            $this->info(' ');
            $this->info('New super admin: '.$name.' ('.$email.') generated successfully');
            $this->info(' ');
        }
    }
}
