<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603164943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, breed_id INT NOT NULL, breeder_id INT NOT NULL, mother_id INT DEFAULT NULL, father_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, type INT NOT NULL, gender TINYINT(1) NOT NULL, INDEX IDX_6AAB231FA8B4A30F (breed_id), INDEX IDX_6AAB231F33C95BB1 (breeder_id), INDEX IDX_6AAB231FB78A354D (mother_id), INDEX IDX_6AAB231F2055B9A2 (father_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breed_catalog (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breeder (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_73DA3D7AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed_catalog (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F33C95BB1 FOREIGN KEY (breeder_id) REFERENCES breeder (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB78A354D FOREIGN KEY (mother_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F2055B9A2 FOREIGN KEY (father_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE breeder ADD CONSTRAINT FK_73DA3D7AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB78A354D');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F2055B9A2');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FA8B4A30F');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F33C95BB1');
        $this->addSql('ALTER TABLE breeder DROP FOREIGN KEY FK_73DA3D7AA76ED395');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE breed_catalog');
        $this->addSql('DROP TABLE breeder');
        $this->addSql('DROP TABLE user');
    }
}
