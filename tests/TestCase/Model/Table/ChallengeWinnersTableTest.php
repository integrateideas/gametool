<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChallengeWinnersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChallengeWinnersTable Test Case
 */
class ChallengeWinnersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ChallengeWinnersTable
     */
    public $ChallengeWinners;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.challenge_winners',
        'app.users',
        'app.roles',
        'app.user_challenge_responses',
        'app.challenges',
        'app.challenge_types',
        'app.fb_pages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ChallengeWinners') ? [] : ['className' => ChallengeWinnersTable::class];
        $this->ChallengeWinners = TableRegistry::get('ChallengeWinners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChallengeWinners);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
