<?php
namespace RegisterVinyl\Entity;
use \PDO;

class Vinyl
{
    protected $id;
    protected $title = '';
    protected $description = '';
    protected $year = date('Y');
    protected $genre = '';
    protected $format = '';
    protected $condition = '';
    protected $price = 0;

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setYear(int $year)
    {
        $this->year = $year;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setGenre(string $genre)
    {
        $this->genre = $genre;
        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setFormat(string $format)
    {
        $this->format = $format;
        return $this;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setCondition(string $condition)
    {
        $this->condition = $condition;
        return $this;
    }

    public function getCondition(): string
    {
        return $this->condition;
    }

    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice(): string
    {
        return number_format($this->price, 2, ',', '.');
    }

    public function save(PDO $db): bool
    {
        if (!empty($this->id)) {
            $sql = "UPDATE vinyl SET title = :title, description = :description,
                    genre = :genre, year = :year, format = :format,
                    condition = :condition, price = :price
                    WHERE id = :id;";
        } else {
            $sql = "INSERT INTO vinyl (title, description, genre, year, format, condition, price)
                    VALUES (:title, :description, :genre, :year, :format, :condition, :price);";
        }

        $stmt = $db->prepare($sql);

        if (!empty($this->id)) {
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        }

        $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindValue(':genre', $this->genre, PDO::PARAM_STR);
        $stmt->bindValue(':year', $this->year, PDO::PARAM_INT);
        $stmt->bindValue(':format', $this->format, PDO::PARAM_STR);
        $stmt->bindValue(':condition', $this->condition, PDO::PARAM_STR);
        $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);

        if(!$stmt->execute()){
            error_log(implode(', ', $stmt->errorInfo()));
            return false;
        }

        $this->id = $db->lastInsertId();

        return true;
    }

    public function delete(PDO $db): bool
    {
        $sql = "DELETE FROM vinyl WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        if(!$stmt->execute()){
            error_log(implode(', ', $stmt->errorInfo()));
            return false;
        }

        return true;
    }

    public static function get(PDO $db, $id): Vinyl
    {
        $sql = "SELECT * FROM vinyl WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $vinylArray = $stmt->fetch(PDO::FETCH_ASSOC);

        $vinyl = new self();
        $vinyl->setId($vinylArray['id'])
            ->setTitle($vinylArray['title'])
            ->setDescription($vinylArray['description'])
            ->setGenre($vinylArray['genre'])
            ->setYear($vinylArray['year'])
            ->setFormat($vinylArray['format'])
            ->setPrice($vinylArray['price']);

        return $vinyl;
    }

    public static function getAll(PDO $db): array
    {
        $sql = "SELECT * FROM vinyl";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $vinyls = $stmt->fetchAll(PDO::FETCH_CLASS, Vinyl::class);

        return $vinyls;
    }

    public static function getTotal(PDO $db): int
    {
        $sql = "SELECT count(*) FROM vinyl";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $total = $stmt->fetchColumn(0);

        return $total;
    }

    public static function getToTable(PDO $db, $page = 1): array
    {
        $limit = 8;
        $start = (($page - 1) * $limit);

        $sql = "SELECT * FROM vinyl ORDER BY title ASC LIMIT {$start}, {$limit}";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $vinyls = $stmt->fetchAll(PDO::FETCH_CLASS, Vinyl::class);

        return $vinyls;
    }
}