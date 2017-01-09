<?php
use Migrations\AbstractSeed;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'site_name' => 'Muebleria',
            'site_cellphone' => '0987654321',
            'site_phone' => '021678234',
            'site_email' => 'asdf@asdf.com',
            'social_facebook' => 'www.facebook.com',
            'social_twitter' => 'www.twitter.com',
            'social_instagram' => 'www.instagram.com',
            'site_active' => true,
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        ];

        $table = $this->table('settings');
        $table->insert($data)->save();
    }
}
