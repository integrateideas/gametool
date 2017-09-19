<?php
use Migrations\AbstractSeed;

/**
 * ChallengeWinners seed.
 */
class ChallengeWinnersSeed extends AbstractSeed
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
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'anonymous4610309',
                      'created' => date('Y-m-d H:i:s', mktime(8, 14, 0, 5, 19, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'robogator',
                      'created' => date('Y-m-d H:i:s', mktime(10, 47, 0, 5, 26, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'kaylieghholt@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(9, 44, 0, 6, 2, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'kaylieghholt@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(7, 23, 0, 6, 9, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'emmajaden265@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(7, 58, 0, 6, 28, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'hmursain@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(11, 47, 0, 6, 29, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'clhumphries@mymail.gaston.edu',
                      'created' => date('Y-m-d H:i:s', mktime(8, 03, 0, 7, 11, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'kaylieghholt@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(8, 56, 0, 8, 18, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'seeesare@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(7, 27, 0, 8, 22, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 35,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'nikie.etters311@gmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(13, 33, 0, 8, 24, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 31,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'kaitlyntaylor',
                      'created' => date('Y-m-d H:i:s', mktime(9, 51, 0, 6, 2, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 31,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'ryanchristman',
                      'created' => date('Y-m-d H:i:s', mktime(11, 03, 0, 5, 26, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 31,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'victoriacottrell',
                      'created' => date('Y-m-d H:i:s', mktime(10, 13, 0, 5, 19, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 10,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'sstrasser',
                      'created' => date('Y-m-d H:i:s', mktime(8, 18, 0, 8, 22, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 10,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'alecbronz',
                      'created' => date('Y-m-d H:i:s', mktime(7, 57, 0, 6, 9, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 10,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'alecbronz',
                      'created' => date('Y-m-d H:i:s', mktime(11, 21, 0, 5, 26, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 10,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'anonymous801207100',
                      'created' => date('Y-m-d H:i:s', mktime(10, 10, 0, 5, 19, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 3,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'emilyredburn00',
                      'created' => date('Y-m-d H:i:s', mktime(12, 31, 0, 8, 24, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 3,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'enderfoxx',
                      'created' => date('Y-m-d H:i:s', mktime(13, 35, 0, 8, 22, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 3,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(9, 46, 0, 8, 18, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'anonymous801207100',
                      'created' => date('Y-m-d H:i:s', mktime(10, 1, 0, 9, 8, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'emilyredburn00',
                      'created' => date('Y-m-d H:i:s', mktime(12, 38, 0, 8, 24, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'enderfoxx',
                      'created' => date('Y-m-d H:i:s', mktime(13, 6, 0, 8, 18, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(8, 34, 0, 7, 11, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'anonymous801207100',
                      'created' => date('Y-m-d H:i:s', mktime(12, 24, 0, 6, 29, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'emilyredburn00',
                      'created' => date('Y-m-d H:i:s', mktime(7, 28, 0, 6, 28, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'enderfoxx',
                      'created' => date('Y-m-d H:i:s', mktime(8, 19, 0, 6, 19, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(10, 10, 0, 6, 9, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(10, 2, 0, 6, 2, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(11, 49, 0, 5, 26, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(9,46, 0, 5, 19, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],
                    [ 'fb_practice_information_id'    => 8,
                      'challenge_id'   => 1,
                      'identifier_type'   =>'username',
                      'identifier_value'   =>'bayliepitts14@hotmail.com',
                      'created' => date('Y-m-d H:i:s', mktime(8, 45, 0, 5, 11, 2017)),
                      'modified'=> date('Y-m-d H:i:s')
                    ],                    
                ];

        $table = $this->table('challenge_winners');
        $table->insert($data)->save();
    }
}
