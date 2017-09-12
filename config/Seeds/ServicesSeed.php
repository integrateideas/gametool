<?php
use Phinx\Seed\AbstractSeed;

/**
* Roles seed.
*/
class ServicesSeed extends AbstractSeed
{
  /**
  * Run Method.
  *
  * Write your database seeder using this method.
  *
  * More information on writing seeders is available here:
  * http://docs.phinx.org/en/latest/seeding.html
  *
  * @return void
  */
  public function run()
  {
    $data = [
      [ 'name'    => 'facebook',
      'label'   =>'Facebook',
      'status'=> 1,
      'created' => date('Y-m-d H:i:s'),
      'modified'=> date('Y-m-d H:i:s')
    ],
    [ 'name'    => 'Twitter',
    'label'   =>'twitter',
    'status'=> 1,
    'created' => date('Y-m-d H:i:s'),
    'modified'=> date('Y-m-d H:i:s')
  ]

];

$table = $this->table('social_connections');
$table->insert($data)->save();
}
}
