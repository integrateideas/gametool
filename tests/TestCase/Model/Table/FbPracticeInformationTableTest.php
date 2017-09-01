<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FbPracticeInformationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FbPracticeInformationTable Test Case
 */
class FbPracticeInformationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FbPracticeInformationTable
     */
    public $FbPracticeInformation;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fb_practice_information',
        'app.fb_pages',
        'app.buzzydoc_vendors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('FbPracticeInformation') ? [] : ['className' => FbPracticeInformationTable::class];
        $this->FbPracticeInformation = TableRegistry::get('FbPracticeInformation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FbPracticeInformation);

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
