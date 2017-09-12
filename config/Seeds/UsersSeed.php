<?php
use Phinx\Seed\AbstractSeed;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Text;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
        $hasher = new DefaultPasswordHasher();
        $data = [
                    [
                      'name'    => 'james',
                      'email'   =>'james.kukreja@twinspark.co',
                      'username' => 'james',
                      'uuid' => '1234567890',
                      'password'   =>$hasher->hash('twinspark'),
                      'role_id'=>'1',
                      'created' => '2016-06-15 10:01:27',
                      'modified'=> '2016-06-15 10:01:27',
                    ],
                    [
                      'name'    => 'Integrateideas',
                      'email'   =>'engage@integrateideas.com',
                      'username' => 'Integrateideas',
                      'uuid' => '1234567890',
                      'password'   =>$hasher->hash('IIitb123$'),
                      'role_id'=>'1',
                      'created' => '2016-06-15 10:01:27',
                      'modified'=> '2016-06-15 10:01:27',
                    ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
