<?php
namespace RegisterVinyl\Entity;

class Vinyl
{
    protected $id;
    protected $title;
    protected $description;
    protected $year;
    protected $genre;
    protected $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function save(\PDO $db): bool
    {
        $sql = "INSERT INTO vinyl (title, description, genre, year, price)
                VALUES (:title, :description, :genre, :year, :price);";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':title', $this->title, \PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, \PDO::PARAM_STR);
        $stmt->bindValue(':genre', $this->genre, \PDO::PARAM_STR);
        $stmt->bindValue(':year', $this->year, \PDO::PARAM_INT);
        $stmt->bindValue(':price', $this->price, \PDO::PARAM_INT);

        if(!$stmt->execute()){
            error_log(implode(', ', $stmt->errorInfo()));
            return false;
        }

        $this->id = $db->lastInsertId();

        return true;
    }

    public static function get(\PDO $db, $id): Vinyl
    {
        $sql = "SELECT * FROM vinyl WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $vinyl = $stmt->fetch(\PDO::FETCH_CLASS, Vinyl::class);

        return $vinyl;
    }

    public static function getAll(\PDO $db): array
    {
        $sql = "SELECT * FROM vinyl";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $vinyls = $stmt->fetchAll(\PDO::FETCH_CLASS, Vinyl::class);

        return $vinyls;
    }

    public static function getTotal(\PDO $db): int
    {
        $sql = "SELECT count(*) FROM vinyl";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $total = $stmt->fetchColumn(0);

        return $total;
    }

    public static function getToTable(\PDO $db, $page = 1): array
    {
        $limit = 8;
        $start = (($page - 1) * $limit);

        $sql = "SELECT * FROM vinyl LIMIT {$start}, {$limit}";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $vinyls = $stmt->fetchAll(\PDO::FETCH_CLASS, Vinyl::class);

        return $vinyls;

    }
}