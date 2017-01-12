<?php
use Migrations\AbstractSeed;
use Muffin\Slug\Slugger\CakeSlugger;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
        $slugger = new CakeSlugger();
        $data = [
            [
                'name' => 'Hogar',
                'slug' => $slugger->slug('Hogar'),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
