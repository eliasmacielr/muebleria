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
                'description' => 'Breve reseña',
                'price' => 500000,
                'stock' => 10,
                'in_offer' => 1,
                'discount' => 20,
                'category_id' => 1,
                'slug' => $slugger->slug('Mesa de vidrio'),
                'available' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sillas',
                'description' => 'Breve reseña',
                'price' => 500000,
                'stock' => 10,
                'in_offer' => 1,
                'discount' => 20,
                'category_id' => 1,
                'slug' => $slugger->slug('Sillas'),
                'available' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
