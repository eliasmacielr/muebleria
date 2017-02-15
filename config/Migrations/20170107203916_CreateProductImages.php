<?php
use Migrations\AbstractMigration;

class CreateProductImages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('product_images');
        $table->addColumn('file_name', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('file_dir', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('main', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('product_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);

        $table->addForeignKey('product_id', 'products', 'id',[
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ]);;

        $table->create();
    }
}
