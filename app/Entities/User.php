<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $display_name;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;
    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection|Question[]
     */
    protected $questions;
    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection|Answer[]
     */
    protected $answers;
    /**
     * @ORM\OneToMany(targetEntity="Bookmark", mappedBy="user", cascade={"persist"})
     * @var ArrayCollection|Bookmark[]
     */
    protected $bookmarks;

    public function __construct($display_name, $email)
    {
        $this->display_name = $display_name;
        $this->email = $email;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getDisplayName()
    {
        return $this->display_name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function addQuestion(Question $question)
    {
        if(!$this->questions->contains($question)) {
            $question->setUser($this);
            $this->questions->add($question);
        }
    }
    public function getQuestions()
    {
        return $this->questions;
    }
    public function addAnswer(Answer $answer)
    {
        if(!$this->answers->contains($answer)) {
            $answer->setUser($this);
            $this->answers->add($answer);
        }
    }
    public function getAnswers()
    {
        return $this->answers;
    }
    public function addBookmark(Bookmark $bookmark)
    {
        if(!$this->bookmarks->contains($bookmark)) {
            $bookmark->setUser($this);
            $this->bookmarks->add($bookmark);
        }
    }
    public function getBookmarks()
    {
        return $this->bookmarks;
    }
}
