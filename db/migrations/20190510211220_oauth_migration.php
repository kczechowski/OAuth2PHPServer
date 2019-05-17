<?php

use Phinx\Migration\AbstractMigration;

class OauthMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('oauth_access_tokens', ['id' => false, 'primary_key' => ['access_token']]);
        $table->addColumn('access_token', 'string', ['limit' => 80, 'null' => false])
            ->addColumn('client_id', 'string', ['limit' => 80])
            ->addColumn('expires_at', 'datetime')
            ->addColumn('scope', 'string', ['limit' => 4000, 'null' => true])
            ->addColumn('is_revoked', 'boolean', ['default' => false])
            ->addForeignKey('client_id', 'oauth_clients', 'client_id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
            ->save();


        $table = $this->table('oauth_clients', ['id' => false, 'primary_key' => ['client_id']]);
        $table->addColumn('client_id', 'string', ['limit' => 80, 'null' => false])
            ->addColumn('client_secret', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->save();
    }
}
