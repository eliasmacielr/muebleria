<?php
use Migrations\AbstractSeed;
use Muffin\Slug\Slugger\CakeSlugger;

/**
 * Products seed.
 */
class ProductsSeed extends AbstractSeed
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
                'name' => 'Mesa de vidrio',
                'price' => 500000,
                'stock' => 10,
                'in_offert' => true,
                'discount' => 20,
                'category_id' => 1,
                'slug' => $slugger->slug('Mesa de vidrio'),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
