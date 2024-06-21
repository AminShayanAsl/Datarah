<?php

namespace App\Entities;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Question")
 */
class Question {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="text")
     */
    protected $title;
    /**
     * @ORM\Column(type="text")
     */
    protected $content;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $confirmation;
    /**
     * @ORM\Column(type="simple_array")
     */
    protected $tags;
    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected $approval;
    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected $disapproval;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="questions")
     * @var User
     */
    protected $user;
    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist"})
     * @var ArrayCollection|Answer[]
     */
    protected $answers;
    /**
     * @ORM\OneToMany(targetEntity="Bookmark", mappedBy="question", cascade={"persist"})
     * @var ArrayCollection|Bookmark[]
     */
    protected $bookmarks;

    /**
     * @param $title
     * @param $content
     * @param $tags
     * @param $user_id
     */
    public function __construct($title, $content, $tags)
    {
        $this->title = $title;
        $this->content = $content;
        $this->tags = $tags;
        $this->created_at = Carbon::now();
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    public function getComment()
    {
        return $this->comment;
    }
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;
    }
    public function getConfirmation()
    {
        return $this->confirmation;
    }
    public function getTags()
    {
        return $this->tags;
    }
    public function setApproval($user_id)
    {
        if (!in_array($user_id, $this->approval)) {
            if (in_array($user_id, $this->disapproval)) {
                unset($this->disapproval[array_search($user_id, $this->disapproval)]);
            }
            $this->approval[] = $user_id;
        }
    }
    public function getApproval()
    {
        return $this->approval;
    }
    public function setDisapproval($user_id)
    {
        if (!in_array($user_id, $this->disapproval)) {
            if (in_array($user_id, $this->approval)) {
                unset($this->approval[array_search($user_id, $this->approval)]);
            }
            $this->disapproval[] = $user_id;
        }
    }
    public function getDisapproval()
    {
        return $this->disapproval;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setUser(User $user)
    {
        $this->user = $user;
    }
    public function getUser(): User
    {
        return $this->user;
    }
    public function addAnswer(Answer $answer)
    {
        if(!$this->answers->contains($answer)) {
            $answer->setQuestion($this);
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
            $bookmark->setQuestion($this);
            $this->bookmarks->add($bookmark);
        }
    }
    public function getBookmarks()
    {
        return $this->bookmarks;
    }
}
