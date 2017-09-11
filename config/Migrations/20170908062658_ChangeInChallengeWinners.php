<?php
use Migrations\AbstractMigration;

class ChangeInChallengeWinners extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */

    public function up(){
        $table = $this->table('challenge_winners');
        $table->addColumn('identifier_type', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('identifier_value', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->removeColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->save();
    }

    public function down(){
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])->save();
    }
}
