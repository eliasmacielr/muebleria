<?php
use Migrations\AbstractMigration;

class CreateSettings extends AbstractMigration
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
        $table = $this->table('settings');
        $table->addColumn('site_name', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('site_cellphone', 'string', [
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('site_phone', 'string', [
            'limit' => 20,
            'null' => false,
        ]);
        $table->addColumn('site_email', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('social_facebook', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('social_twitter', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('social_instagram', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('city', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('street', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('country', 'string', [
            'limit' => 200,
            'null' => false,
        ]);
        $table->addColumn('site_active', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'null' => false,
        ]);
        $table->create();
    }
}
