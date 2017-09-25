<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MediaFileUploadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MediaFileUploadsTable Test Case
 */
class MediaFileUploadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MediaFileUploadsTable
     */
    public $MediaFileUploads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.media_file_uploads'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MediaFileUploads') ? [] : ['className' => MediaFileUploadsTable::class];
        $this->MediaFileUploads = TableRegistry::get('MediaFileUploads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MediaFileUploads);

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
