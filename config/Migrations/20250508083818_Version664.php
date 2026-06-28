<?php

use Migrations\AbstractMigration;

class Version664 extends AbstractMigration
{
    public $autoId = false;

    public function up()
    {
        $this->execute("SET SESSION sql_mode = ''");

        $rows = [
            [
                'name' => 'turnstile_site_key',
                'value' => '',
            ],
            [
                'name' => 'turnstile_secret_key',
                'value' => '',
            ],
        ];

        $this->table('options')
            ->insert($rows)
            ->saveData();
    }
}
