<?php
use Migrations\AbstractSeed;

/**
 * ChallengeTypes seed.
 */
class ChallengeTypesSeed extends AbstractSeed
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
        $data = [
                    [ 
                        'name'    => 'READ THE ARTICLE',
                        'created' => date('Y-m-d H:i:s'),
                        'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 
                        'name'    => 'SHARE THE WISDOM',
                        'created' => date('Y-m-d H:i:s'),
                        'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 
                        'name'    => 'FUNNY CAPTION',
                        'created' => date('Y-m-d H:i:s'),
                        'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 
                        'name'    => 'FILL IN THE BLANKS',
                        'created' => date('Y-m-d H:i:s'),
                        'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 
                        'name'    => 'WEEKLY HEALTH TRIVIA',
                        'created' => date('Y-m-d H:i:s'),
                        'modified'=> date('Y-m-d H:i:s')
                    ],
                ];

        $table = $this->table('challenge_types');
        $table->insert($data)->save();
    }
}
