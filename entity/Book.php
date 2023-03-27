<?php

namespace entity;

class Book
{
    private string $isbn;
    private string $title;
    private string $author;
    private string $publisher;
    private int $year;
    private string $description;
    private string $cover;
    private Genre  $genre;

    /**
     * @return string
     */
    public function getIsbn(): string
    {
        return $this->isbn;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCover(): string
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover(string $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @return Genre
     */
    public function getGenre(): Genre
    {
        if(!isset($this->genre)){
            $this->genre= new Genre();
        }
        return $this->genre;
    }

    /**
     * @param Genre $genre
     */
    public function setGenre(Genre $genre): void
    {
        if(!isset($this->genre)){
            $this->genre= new Genre();
        }
        $this->genre = $genre;
    }

    public function __set(string $name, $value): void
    {
        if(!isset($this->genre)){
            $this->genre= new Genre();
        }
        switch ($name){
            case 'publisher_year':
                $this->year=$value;
                break;
            case 'short_description':
                $this->description=$value;
                break;
            case 'genre_id':
                $this->genre->setId($value);
                break;
            case 'name':
                $this->genre->setName($value);
                break;
        }
    }


}