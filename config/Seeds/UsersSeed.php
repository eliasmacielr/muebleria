<?php
use Cake\Auth\DefaultPasswordHasher;
use Migrations\AbstractSeed;
use Cake\Utility\Text;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
        $hasher = new DefaultPasswordHasher();
        $api_key[] = Text::uuid();
        $api_key[] = Text::uuid();
        $api_key[] = Text::uuid();
        $data = [
            [
                'name' => 'Super',
                'last_name' => 'Admin',
                'username' => 'sadmin',
                'password' => $hasher->hash('admin098'),
                'api_key' => $api_key[0],
                'api_key_hash' => $hasher->hash($api_key[0]),
                'active' => 1,
                'role' => 'super-admin',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Admin',
                'last_name' => 'Admin',
                'username' => 'admin',
                'password' => $hasher->hash('admin098'),
                'api_key' => $api_key[1],
                'api_key_hash' => $hasher->hash($api_key[1]),
                'active' => 1,
                'role' => 'admin',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Staff',
                'last_name' => 'Admin',
                'username' => 'staff',
                'password' => $hasher->hash('admin098'),
                'api_key' => $api_key[2],
                'api_key_hash' => $hasher->hash($api_key[2]),
                'active' => 1,
                'role' => 'staff',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
