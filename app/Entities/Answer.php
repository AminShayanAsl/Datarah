<?php

namespace App\Entities;

use Carbon\Carbon;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Answer")
 */
class Answer {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="answers")
     * @var User
     */
    protected $user;
    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @var Question
     */
    protected $question;

    /**
     * @param $content
     * @param $user_id
     */
    public function __construct($content)
    {
        $this->content = $content;
        $this->created_at = Carbon::now();
    }
    public function getId()
    {
        return $this->id;
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
    public function getUser()
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
