<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles")
     */
    private $user;
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="App\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     */
    private $media;
    /**
     * @var string
     * @ORM\Column(type="string",length=150)
     */
    private $title;
    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $summary;
    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $content;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $hitcount;
    /**
     * @var date
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @var date
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * Article constructor.
     */
    public function __construct() {
        $this->hitcount = 0;
        $this->title = "";
        $this->summary = "";
        $this->content = "";
//        $this->media = new Media();
        $this->created_at = new \DateTime('now');
        $this->updated_at = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user) {
        $this->user = $user;
    }

    /**
     * @return Media
     */
    public function getMedia() {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia(Media $media) {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSummary(): string {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary) {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getContent(): string {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content) {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getHitcount(): int {
        return $this->hitcount;
    }

    /**
     * @param int $hitcount
     */
    public function setHitcount(int $hitcount) {
        $this->hitcount = $hitcount;
    }

    /**
     * @return date
     */
    public function getCreatedAt(){
        return $this->created_at;
    }

    /**
     * @param date $created_at
     */
    public function setCreatedAt( $created_at) {
        $this->created_at = $created_at;
    }

    /**
     * @return date
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * @param date $updated_at
     */
    public function setUpdatedAt( $updated_at) {
        $this->updated_at = $updated_at;
    }



}
