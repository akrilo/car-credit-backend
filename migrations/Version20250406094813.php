<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406094813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, photo VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_773DE69D44F5D008 (brand_id), INDEX IDX_773DE69D7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE car_model (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE credit_program (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE credit_request (id INT AUTO_INCREMENT NOT NULL, car_id INT DEFAULT NULL, credit_program_id INT DEFAULT NULL, initial_payment DOUBLE PRECISION NOT NULL, loan_term INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_113E8B0C3C6F69F (car_id), INDEX IDX_113E8B0CDC0BCB4 (credit_program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE car ADD CONSTRAINT FK_773DE69D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES car_model (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_request ADD CONSTRAINT FK_113E8B0CDC0BCB4 FOREIGN KEY (credit_program_id) REFERENCES credit_program (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE car DROP FOREIGN KEY FK_773DE69D44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B0C3C6F69F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE credit_request DROP FOREIGN KEY FK_113E8B0CDC0BCB4
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brand
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE car
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE car_model
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE credit_program
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE credit_request
        SQL);
    }
}
