<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Bookmark")
 */
class Bookmark {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bookmarks")
     * @var User
     */
    protected $user;
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="bookmarks")
     * @var Question
     */
    protected $question;

    public function __construct($user, $question)
    {
        $this->user = $user;
        $this->question = $question;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }
    public function getQuestion(): Question
    {
        return $this->question;
    }
}
