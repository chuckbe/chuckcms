<?php

namespace Chuckbe\Chuckcms\Commands;

use Chuckbe\Chuckcms\Chuck\SiteRepository;
use Illuminate\Console\Command;

class GenerateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chuckcms:generate-site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates a new site entry.';

    /**
     * The site repository implementation.
     *
     * @var SiteRepository
     */
    protected $siteRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SiteRepository $siteRepository)
    {
        parent::__construct();

        $this->siteRepository = $siteRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('What is name of the site? ');
        $slug = $this->ask('What is the unique slug of the site? ');
        $domain = $this->ask('What will be the domain of this site? E.G. http://google.be ');

        // Validate user input
        $this->info('Validating your information and generating a new site...');

        $data = array(
            'name'  => $name,
            'slug' => $slug,
            'domain'  => $domain
        );

        $rules = array(
            'name' => 'required|max:185',
            'slug' => 'required|unique:sites',
            'domain'  => 'required|min:11'
        );

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            foreach ($messages->all() as $message) {
                $this->error($message);
            }
        } else {
            $settings = [];
            $settings['company']['name'] = 'ChuckCMS';
            $settings['company']['vat'] = 'BE0000.000.000';
            $settings['company']['street'] = 'Berlaarsestraat';
            $settings['company']['housenumber'] = '10';
            $settings['company']['postalcode'] = '2500';
            $settings['company']['city'] = 'Lier';
            $settings['company']['email'] = 'hello@chuck.be';
            $settings['company']['tel'] = '0470 12 34 56';
            $settings['socialmedia']['facebook'] = 'https://facebook.com/chuckcmsmedia';
            $settings['socialmedia']['twitter'] = 'https://twitter.com/chuckcms';
            $settings['socialmedia']['tiktok'] = 'https://tiktok.com/chuckcms';
            $settings['socialmedia']['pinterest'] = 'https://pinterest.com/chuckcms';
            $settings['socialmedia']['instagram'] = 'https://instagram.com/chuckcms';
            $settings['socialmedia']['snapchat'] = 'https://snapchat.co/username';
            $settings['socialmedia']['googleplus'] = 'https://plus.google.com/+ChuckCMS';
            $settings['socialmedia']['linkedin'] = 'https://linkedin.com/chuckcms';
            $settings['socialmedia']['tumblr'] = 'https://tumblr.com/chuckcms';
            $settings['socialmedia']['youtube'] = 'https://youtube.com/chuckcms';
            $settings['socialmedia']['vimeo'] = 'https://vimeo.com/chuckcms';
            $settings['integrations']['ga-id'] = null;
            $settings['integrations']['g-site-verification'] = null;
            $settings['favicon']['href'] = '/chuckbe/chuckcms/favicon.ico';
            $settings['logo']['href'] = '/chuckbe/chuckcms/chuckcms-logo.png';
            $settings['lang'] = 'nl,en';
            $settings['domain'] = $domain;
            // create the site
            $this->siteRepository->createFromArray([
                'name' => $name,
                'slug' => $slug,
                'domain' => $domain,
                'settings' => $settings
            ]);

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
            $this->info('New site: ' . $name . ' (' . $domain . ') generated successfully');
            $this->info(' ');
        }

        
    }
}
