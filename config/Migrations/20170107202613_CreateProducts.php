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
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('description', 'string', [
            'limit' => 1000,
            'null' => false,
        ]);
        $table->addColumn('price', 'decimal', [
            'precision' => 15,
            'scale' => 2,
            'null' => false,
        ]);
        $table->addColumn('stock', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('in_offer', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('discount', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('slug', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('available', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('category_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
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
