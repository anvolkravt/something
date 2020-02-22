<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200222072938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, username_id INT NOT NULL, correct_answers INT NOT NULL, start DATETIME NOT NULL, finish DATETIME NOT NULL, UNIQUE INDEX UNIQ_136AC113ED766068 (username_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113ED766068 FOREIGN KEY (username_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD results_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA928A30AB9 FOREIGN KEY (results_id) REFERENCES result (id)');
        $this->addSql('CREATE INDEX IDX_A412FA928A30AB9 ON quiz (results_id)');
        $this->addSql('ALTER TABLE user ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA928A30AB9');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP INDEX IDX_A412FA928A30AB9 ON quiz');
        $this->addSql('ALTER TABLE quiz DROP results_id');
        $this->addSql('ALTER TABLE user DROP is_active');
    }
}
