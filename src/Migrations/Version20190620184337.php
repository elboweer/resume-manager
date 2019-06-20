<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190620184337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE company (id VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, site VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id VARCHAR(36) NOT NULL, company_id VARCHAR(36) NOT NULL, resume_id VARCHAR(36) NOT NULL, send_at DATETIME NOT NULL, decision VARCHAR(255) NOT NULL, INDEX IDX_D2294458979B1AD6 (company_id), INDEX IDX_D2294458D262AF09 (resume_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id VARCHAR(36) NOT NULL, position VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458D262AF09 FOREIGN KEY (resume_id) REFERENCES company (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458979B1AD6');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458D262AF09');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE company');
    }
}
