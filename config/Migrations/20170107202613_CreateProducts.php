<?php
use Migrations\AbstractMigration;

class CreateProducts extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('price', 'decimal', [
            'default' => null,
            'precision' => 15,
            'scale' => 2,
            'null' => false,
        ]);
        $table->addColumn('stock', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('main_image', 'string', [
            'limit' => 200,
            'null' => true,
        ]);
        $table->addColumn('in_offert', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('discount', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('slug', 'string', [
            'default' => null,
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addIndex(['name'], [
            'unique' => true,
        ]);
        $table->addForeignKey('category_id', 'categories', 'id', [
            'delete' => 'NO_ACTION',
            'update' => 'NO_ACTION'
        ]);

        $table->create();
    }
}
