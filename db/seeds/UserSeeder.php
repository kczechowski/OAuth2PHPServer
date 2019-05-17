<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $password = password_hash('pass', PASSWORD_BCRYPT);
        $table = $this->table('oauth_clients');
        $table->insert(['client_id' => 'admin', 'client_secret' => $password, 'email' => 'admin@example.com'])
            ->save();
    }
}
