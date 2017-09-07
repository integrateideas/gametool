<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserChallengeResponsesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserChallengeResponsesTable Test Case
 */
class UserChallengeResponsesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserChallengeResponsesTable
     */
    public $UserChallengeResponses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_challenge_responses',
        'app.users',
        'app.roles',
        'app.social_profiles',
        'app.challenges',
        'app.challenge_types',
        'app.fb_practice_information'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserChallengeResponses') ? [] : ['className' => UserChallengeResponsesTable::class];
        $this->UserChallengeResponses = TableRegistry::get('UserChallengeResponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserChallengeResponses);

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
