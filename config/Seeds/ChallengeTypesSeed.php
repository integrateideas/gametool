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
                        'name'    => 'READ THE ARTICLE'
                    ],
                    [ 
                        'name'    => 'SHARE THE WISDOM'
                    ],
                    [ 
                        'name'    => 'FUNNY CAPTION'
                    ],
                    [ 
                        'name'    => 'FILL IN THE BLANKS'
                    ],
                    [ 
                        'name'    => 'WEEKLY HEALTH TRIVIA'
                    ],
                ];

        $table = $this->table('challenge_types');
        $table->insert($data)->save();
    }
}
