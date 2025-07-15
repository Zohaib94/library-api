<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loan}}`.
 */
class m250714_132003_create_loan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%loan}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer(),
            'borrower_id' => $this->integer(),
            'borrowed_on' => $this->dateTime(),
            'to_be_returned_on' => $this->dateTime()
        ]);

        $this->addForeignKey(
            'fk-loan-book_id',
            'loan',
            'book_id',
            'book',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-loan-borrower_id',
            'loan',
            'borrower_id',
            'member',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-loan-book_id',
            'loan',
            'book_id'
        );

        $this->createIndex(
            'idx-loan-borrower_id',
            'loan',
            'borrower_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-loan-book_id', 'loan');
        $this->dropIndex('idx-loan-borrower_id', 'loan');
        $this->dropForeignKey('fk-loan-book_id', 'loan');
        $this->dropForeignKey('fk-loan-borrower_id', 'loan');

        $this->dropTable('{{%loan}}');
    }
}
