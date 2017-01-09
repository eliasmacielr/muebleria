<?php
use Migrations\AbstractSeed;

/**
 * DevelSeed seed.
 */
class DevelSeed extends AbstractSeed
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
        $this->call('CategoriesSeed');
        $this->call('ProductsSeed');
        $this->call('ProductImagesSeed');
        $this->call('ProductSpecificationsSeed');
        $this->call('SettingsSeed');
        $this->call('UsersSeed');
    }
}
