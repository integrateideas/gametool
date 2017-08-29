<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChallengeTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChallengeTypesTable Test Case
 */
class ChallengeTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ChallengeTypesTable
     */
    public $ChallengeTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.challenge_types',
        'app.challenges',
        'app.user_challenge_responses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ChallengeTypes') ? [] : ['className' => ChallengeTypesTable::class];
        $this->ChallengeTypes = TableRegistry::get('ChallengeTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChallengeTypes);

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
