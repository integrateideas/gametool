<?php
use Migrations\AbstractMigration;

class AddColumnToFbPracticeInformation extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('fb_practice_information');
        $table->addColumn('is_old_buzzydoc', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
