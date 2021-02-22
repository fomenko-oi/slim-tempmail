<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126193504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email_messages (id CHAR(36) NOT NULL COMMENT \'(DC2Type:email_id)\', native_id VARCHAR(255) NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', host VARCHAR(255) NOT NULL, receiver VARCHAR(255) NOT NULL, sender VARCHAR(255) NOT NULL, subject VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, body LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX mail_idx (host, receiver), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_message_files (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', message_id CHAR(36) NOT NULL COMMENT \'(DC2Type:email_id)\', path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, size VARCHAR(255) DEFAULT NULL, INDEX IDX_BA4AC1A537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email_domains (id CHAR(36) NOT NULL COMMENT \'(DC2Type:domain_id)\', host VARCHAR(255) NOT NULL, checked_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(16) NOT NULL, type CHAR(36) NOT NULL COMMENT \'(DC2Type:domain_type)\', UNIQUE INDEX UNIQ_31BBD752CF2713FD (host), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email_message_files ADD CONSTRAINT FK_BA4AC1A537A1329 FOREIGN KEY (message_id) REFERENCES email_messages (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE email_message_files DROP FOREIGN KEY FK_BA4AC1A537A1329');
        $this->addSql('DROP TABLE email_messages');
        $this->addSql('DROP TABLE email_message_files');
        $this->addSql('DROP TABLE email_domains');
    }
}
