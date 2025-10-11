<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008172144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, brand VARCHAR(50) NOT NULL, license_plate VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, is_electric TINYINT(1) NOT NULL, INDEX IDX_773DE69D7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carpooling (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, driver_id INT NOT NULL, departure VARCHAR(50) NOT NULL, arrival VARCHAR(50) NOT NULL, departure_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', arrival_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', price DOUBLE PRECISION NOT NULL, is_eco_trip TINYINT(1) NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_6CC153F1C3C6F69F (car_id), INDEX IDX_6CC153F1C3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carpooling_user (carpooling_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_257FA72FAFB2200A (carpooling_id), INDEX IDX_257FA72FA76ED395 (user_id), PRIMARY KEY(carpooling_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, carpooling_id INT NOT NULL, comment LONGTEXT NOT NULL, rating SMALLINT NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CAFB2200A (carpooling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE preference (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, is_smoking TINYINT(1) NOT NULL, is_animals TINYINT(1) NOT NULL, extra VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5D69B053A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, passenger_id INT NOT NULL, carpooling_id INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_42C84955C3423909 (driver_id), INDEX IDX_42C849554502E565 (passenger_id), INDEX IDX_42C84955AFB2200A (carpooling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, credit DOUBLE PRECISION DEFAULT NULL, pending_credit DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_7C68921FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE carpooling ADD CONSTRAINT FK_6CC153F1C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE carpooling ADD CONSTRAINT FK_6CC153F1C3423909 FOREIGN KEY (driver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE carpooling_user ADD CONSTRAINT FK_257FA72FAFB2200A FOREIGN KEY (carpooling_id) REFERENCES carpooling (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carpooling_user ADD CONSTRAINT FK_257FA72FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAFB2200A FOREIGN KEY (carpooling_id) REFERENCES carpooling (id)');
        $this->addSql('ALTER TABLE preference ADD CONSTRAINT FK_5D69B053A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C3423909 FOREIGN KEY (driver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849554502E565 FOREIGN KEY (passenger_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955AFB2200A FOREIGN KEY (carpooling_id) REFERENCES carpooling (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7E3C61F9');
        $this->addSql('ALTER TABLE carpooling DROP FOREIGN KEY FK_6CC153F1C3C6F69F');
        $this->addSql('ALTER TABLE carpooling DROP FOREIGN KEY FK_6CC153F1C3423909');
        $this->addSql('ALTER TABLE carpooling_user DROP FOREIGN KEY FK_257FA72FAFB2200A');
        $this->addSql('ALTER TABLE carpooling_user DROP FOREIGN KEY FK_257FA72FA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CAFB2200A');
        $this->addSql('ALTER TABLE preference DROP FOREIGN KEY FK_5D69B053A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C3423909');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849554502E565');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955AFB2200A');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921FA76ED395');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE carpooling');
        $this->addSql('DROP TABLE carpooling_user');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE preference');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE wallet');
    }
}
