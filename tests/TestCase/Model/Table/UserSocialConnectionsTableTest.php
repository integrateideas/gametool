<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserSocialConnectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserSocialConnectionsTable Test Case
 */
class UserSocialConnectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserSocialConnectionsTable
     */
    public $UserSocialConnections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_social_connections',
        'app.users',
        'app.roles',
        'app.social_profiles',
        'app.user_challenge_responses',
        'app.challenges',
        'app.challenge_types',
        'app.fb_practice_information',
        'app.challenge_winners',
        'app.social_connections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserSocialConnections') ? [] : ['className' => UserSocialConnectionsTable::class];
        $this->UserSocialConnections = TableRegistry::get('UserSocialConnections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserSocialConnections);

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
