<?php
use Migrations\AbstractSeed;

/**
 * ProductImages seed.
 */
class ProductImagesSeed extends AbstractSeed
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
            [
                'file_name' => 'not_found.jpg',
                'file_dir' => '/image/path',
                'main' => 1,
                'product_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'file_name' => 'not_found.jpg',
                'file_dir' => '/image/path',
                'main' => 0,
                'product_id' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('product_images');
        $table->insert($data)->save();
    }
}
