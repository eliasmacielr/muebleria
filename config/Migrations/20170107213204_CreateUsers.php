<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('name', 'string', [
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('last_name', 'string', [
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('username', 'string', [
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('role', 'string', [
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('api_key', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('api_key_hash', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('active', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);

        $table->addIndex('username', ['unique' => true]);

        $table->create();
    }
}
