<?php
use Migrations\AbstractMigration;

class CreateProductSpecifications extends AbstractMigration
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
        $table = $this->table('product_specifications');
        $table->addColumn('name', 'string', [
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('value', 'string', [
            'limit' => 200,
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

        $table->addIndex(['name', 'product_id'], [
            'unique' => true,
        ]);
        $table->addForeignKey('product_id', 'products', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION'
        ]);

        $table->create();
    }
}
