<?php

namespace App\Http\Controllers;

use App\Entities\Answer;
use App\Entities\Question;
use App\Entities\User;
use App\Mail\NewSubjectMail;
use Doctrine\ORM\EntityManagerInterface;
use http\Header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Scalar\String_;

class AnswerController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function answer(): \Illuminate\Http\RedirectResponse
    {
        session_start();
        if (isset($_SESSION['auth'])) {
            $answer_text = $_POST['answer'];
            $question_id = $_POST['question-id'];
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$question_id]);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $answer = new Answer($answer_text);
            $question->addAnswer(
                $answer
            );
            $this->em->persist($question);
            $this->em->flush();
            $user->addAnswer(
                $answer
            );
            $this->em->persist($user);
            $this->em->flush();
            Mail::to('datarah2024@gmail.com')->send(new NewSubjectMail());
            return redirect()->route('question', ['title'=>$question->getTitle(), 'created_at'=>$question->getCreatedAt()->format('Y-m-d H:i:s'), 'status'=>'successful']);
        } else {
            return redirect()->route('home');
        }
    }

    public function confirmationAnswer(): \Illuminate\Http\RedirectResponse
    {
        session_start();
        if ($_SESSION['auth']['user-type'] === 'admin') {
            $a_id = $_GET['a-id'];
            $answer = $this->em->getRepository(Answer::class)->findOneBy(['id'=>$a_id]);
            $answer->setConfirmation(true);
            $this->em->persist($answer);
            $this->em->flush();
            return redirect()->route('profile');
        } else {
            return redirect()->route('home');
        }
    }

    public function commentAnswer(): \Illuminate\Http\RedirectResponse
    {
        session_start();
        if ($_SESSION['auth']['user-type'] === 'admin') {
            $a_id = $_POST['a-id'];
            $comment = $_POST['comment'];
            $answer = $this->em->getRepository(Answer::class)->findOneBy(['id'=>$a_id]);
            $answer->setConfirmation(false);
            $answer->setComment($comment);
            $this->em->persist($answer);
            $this->em->flush();
            return redirect()->route('profile');
        } else {
            return redirect()->route('home');
        }
    }

    public function answerApproval(Request $request)
    {
        session_start();
        if (isset($_SESSION['auth'])) {
            $answer_id = $request->answer_id;
            $answer = $this->em->getRepository(Answer::class)->findOneBy(['id'=>$answer_id]);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $user_id = (string)$user->getId();
            if (!in_array($user_id, $answer->getApproval())) {
                if (in_array($user_id, $answer->getDisapproval())) {
                    $result['number'] = 2;
                } else {
                    $result['number'] = 1;
                }
                $answer->setApproval($user_id);
                $this->em->persist($answer);
                $this->em->flush();
                return $result;
            }
        } else {
            $result['message'] = 'برای ثبت رای، ابتدا باید وارد حساب کاربری خود شوید.';
            return $result;
        }
    }

    public function answerDisapproval(Request $request)
    {
        session_start();
        if (isset($_SESSION['auth'])) {
            $answer_id = $request->answer_id;
            $answer = $this->em->getRepository(Answer::class)->findOneBy(['id'=>$answer_id]);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $user_id = (string)$user->getId();
            if (!in_array($user_id, $answer->getDisapproval())) {
                if (in_array($user_id, $answer->getApproval())) {
                    $result['number'] = -2;
                } else {
                    $result['number'] = -1;
                }
                $answer->setDisapproval($user_id);
                $this->em->persist($answer);
                $this->em->flush();
                return $result;
            }
        } else {
            $result['message'] = 'برای ثبت رای، ابتدا باید وارد حساب کاربری خود شوید.';
            return $result;
        }
    }
}
