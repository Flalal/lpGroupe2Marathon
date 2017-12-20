<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="recipes")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="App\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     */
    private $media;
    /**
     * @var string
     * @ORM\Column(type="string", length=120)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $steps;
    /**
     * @var Comment[]
     * @ORM\OneToMany(targetEntity="App\Entity\Comment",mappedBy="recipe")
     */
    private $comments;

    /**
     * @var Vote[]
     * @ORM\OneToMany(targetEntity="App\Entity\Vote",mappedBy="recipe")
     */
    private $votes;

    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $ingredients;
    /**
     * @var int
     * @ORM\Column(columnDefinition="TINYINT(4)")
     */
    private $difficulty;
    /**
     * @var time
     * @ORM\Column(type="time")
     */
    private $preparation_time;
    /**
     * @var time
     * @ORM\Column(type="time")
     */
    private $cooking_time;
    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $materials;
    /**
     * @var string
     * @ORM\Column(columnDefinition="TEXT")
     */
    private $astuce;
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
     * Recipe constructor.
     */
    public function __construct() {
        $this->comments = new ArrayCollection();
        $this->votes = new ArrayCollection();
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
     * @return Media
     */
    public function getMedia() {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia( $media) {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSteps() {
        return $this->steps;
    }

    /**
     * @param string $steps
     */
    public function setSteps( $steps) {
        $this->steps = $steps;
    }

    /**
     * @return Comment[]
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     */
    public function setComments( $comments) {
        $this->comments = $comments;
    }

    /**
     * @return Vote[]
     */
    public function getVotes() {
        return $this->votes;
    }

    /**
     * @param Vote[] $votes
     */
    public function setVotes( $votes) {
        $this->votes = $votes;
    }

    /**
     * @return string
     */
    public function getIngredients() {
        return $this->ingredients;
    }

    /**
     * @param string $ingredients
     */
    public function setIngredients( $ingredients) {
        $this->ingredients = $ingredients;
    }

    /**
     * @return int
     */
    public function getDifficulty() {
        return $this->difficulty;
    }

    /**
     * @param int $difficulty
     */
    public function setDifficulty( $difficulty) {
        $this->difficulty = $difficulty;
    }

    /**
     * @return time
     */
    public function getPreparationTime() {
        return $this->preparation_time;
    }

    /**
     * @param time $preparation_time
     */
    public function setPreparationTime( $preparation_time) {
        $this->preparation_time = $preparation_time;
    }

    /**
     * @return time
     */
    public function getCookingTime() {
        return $this->cooking_time;
    }

    /**
     * @param time $cooking_time
     */
    public function setCookingTime( $cooking_time) {
        $this->cooking_time = $cooking_time;
    }

    /**
     * @return string
     */
    public function getMaterials() {
        return $this->materials;
    }

    /**
     * @param string $materials
     */
    public function setMaterials( $materials) {
        $this->materials = $materials;
    }

    /**
     * @return string
     */
    public function getAstuce() {
        return $this->astuce;
    }

    /**
     * @param string $astuce
     */
    public function setAstuce( $astuce) {
        $this->astuce = $astuce;
    }

    /**
     * @return date
     */
    public function getCreatedAt() {
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
