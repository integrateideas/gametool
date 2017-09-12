<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SocialConnectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SocialConnectionsTable Test Case
 */
class SocialConnectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SocialConnectionsTable
     */
    public $SocialConnections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.social_connections',
        'app.user_social_connections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SocialConnections') ? [] : ['className' => SocialConnectionsTable::class];
        $this->SocialConnections = TableRegistry::get('SocialConnections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SocialConnections);

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
}
