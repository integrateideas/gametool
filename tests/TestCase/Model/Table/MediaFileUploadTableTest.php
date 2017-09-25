<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MediaFileUploadTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MediaFileUploadTable Test Case
 */
class MediaFileUploadTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MediaFileUploadTable
     */
    public $MediaFileUpload;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.media_file_upload'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MediaFileUpload') ? [] : ['className' => MediaFileUploadTable::class];
        $this->MediaFileUpload = TableRegistry::get('MediaFileUpload', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MediaFileUpload);

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
