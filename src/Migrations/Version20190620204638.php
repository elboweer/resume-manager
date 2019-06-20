<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190620204638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458D262AF09');
        $this->addSql('CREATE TABLE summary (id VARCHAR(36) NOT NULL, position VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP INDEX IDX_D2294458D262AF09 ON feedback');
        $this->addSql('ALTER TABLE feedback CHANGE resume_id summary_id VARCHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944582AC2D45C FOREIGN KEY (summary_id) REFERENCES summary (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D22944582AC2D45C ON feedback (summary_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D22944582AC2D45C');
        $this->addSql('CREATE TABLE resume (id VARCHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci, position VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, body LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE summary');
        $this->addSql('DROP INDEX IDX_D22944582AC2D45C ON feedback');
        $this->addSql('ALTER TABLE feedback CHANGE summary_id resume_id VARCHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458D262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_D2294458D262AF09 ON feedback (resume_id)');
    }
}
