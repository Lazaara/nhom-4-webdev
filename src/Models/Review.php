<?php
class Review
{
    private int $rating = 0;
    private string $comment = null;
    private DateTime $date;

    public function __construct(int $rating, string $comment, DateTime $date)
    {
        $this->rating = $rating;
        $this->comment = $comment;
        $this->date = $date;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
}
?>