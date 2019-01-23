<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190114183131 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE song (id INT AUTO_INCREMENT NOT NULL, album_id_id INT NOT NULL, artist_id_id INT NOT NULL, song_title VARCHAR(255) NOT NULL, song_length VARCHAR(10) NOT NULL, INDEX IDX_33EDEEA19FCD471 (album_id_id), INDEX IDX_33EDEEA11F48AE04 (artist_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, album_title VARCHAR(255) NOT NULL, album_cover VARCHAR(255) NOT NULL, album_description VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_artist (album_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_D322AB301137ABCF (album_id), INDEX IDX_D322AB30B7970CF8 (artist_id), PRIMARY KEY(album_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, artist_name VARCHAR(255) NOT NULL, artist_token VARCHAR(6) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA19FCD471 FOREIGN KEY (album_id_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11F48AE04 FOREIGN KEY (artist_id_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB30B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA19FCD471');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB301137ABCF');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11F48AE04');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB30B7970CF8');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_artist');
        $this->addSql('DROP TABLE artist');
    }
}
