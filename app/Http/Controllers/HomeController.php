<?php

namespace App\Http\Controllers;

use App\Entities\Narration;
use App\Entities\Question;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class HomeController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function home()
    {
        $questions = $this->em->getRepository(Question::class)->findBy(['confirmation'=>true], ['created_at' => 'DESC']);
        $questions_vote = [];
        foreach ($questions as $question) {
            $approval = count($question->getApproval());
            $disapproval = count($question->getDisapproval());
            $questions_vote[] = [
                'question' => $question,
                'vote' => $approval - $disapproval
            ];
        }
        $best_questions = bestQuestionsSort($questions_vote);
        $content = createNarration($this->em);
        return view('home', ['best_questions' => $best_questions, 'questions' => array_slice($questions, 0, 5), 'content'=>$content]);
    }

    public function support()
    {
        $content = createNarration($this->em);
        return view('support', ['content'=>$content]);
    }

    public function aboutUs()
    {
        $content = createNarration($this->em);
        return view('aboutUs', ['content'=>$content]);
    }

    public function help()
    {
        $content = createNarration($this->em);
        return view('help', ['content'=>$content]);
    }

    public function error()
    {
        $content = createNarration($this->em);
        return view('error', ['content'=>$content]);
    }
}
