<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200222074928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA928A30AB9');
        $this->addSql('DROP INDEX IDX_A412FA928A30AB9 ON quiz');
        $this->addSql('ALTER TABLE quiz DROP results_id');
        $this->addSql('ALTER TABLE result ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_136AC113853CD175 ON result (quiz_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quiz ADD results_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA928A30AB9 FOREIGN KEY (results_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_A412FA928A30AB9 ON quiz (results_id)');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113853CD175');
        $this->addSql('DROP INDEX IDX_136AC113853CD175 ON result');
        $this->addSql('ALTER TABLE result DROP quiz_id');
    }
}
