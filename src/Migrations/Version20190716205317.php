<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190716205317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, attachment_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_5C93B3A4A76ED395 (user_id), UNIQUE INDEX UNIQ_5C93B3A4464E68B (attachment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, started_at VARCHAR(255) NOT NULL, ended_at VARCHAR(255) DEFAULT NULL, INDEX IDX_82020E70A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attachments (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, text_color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, background_img_path VARCHAR(255) DEFAULT NULL, specialty VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, github_link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tools (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tools_projects (tools_id INT NOT NULL, projects_id INT NOT NULL, INDEX IDX_82D76185752C489C (tools_id), INDEX IDX_82D761851EDE0F55 (projects_id), PRIMARY KEY(tools_id, projects_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4464E68B FOREIGN KEY (attachment_id) REFERENCES attachments (id)');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E70A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tools_projects ADD CONSTRAINT FK_82D76185752C489C FOREIGN KEY (tools_id) REFERENCES tools (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tools_projects ADD CONSTRAINT FK_82D761851EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tools_projects DROP FOREIGN KEY FK_82D761851EDE0F55');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4464E68B');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A76ED395');
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E70A76ED395');
        $this->addSql('ALTER TABLE tools_projects DROP FOREIGN KEY FK_82D76185752C489C');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE experiences');
        $this->addSql('DROP TABLE attachments');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE tools');
        $this->addSql('DROP TABLE tools_projects');
    }
}
