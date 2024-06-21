<?php

namespace App\Http\Controllers;

use App\Entities\Answer;
use App\Entities\Bookmark;
use App\Entities\Question;
use App\Entities\User;
use App\Mail\NewSubjectMail;
use App\Mail\SignInMail;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function addQuestion()
    {
        $content = createNarration($this->em);
        return view('addQuestion', ['content'=>$content]);
    }

    public function saveQuestion()
    {
        $content = createNarration($this->em);
        session_start();
        if (isset($_SESSION['auth'])) {
            $title = $_POST['title'];
            $explain = $_POST['explain'];
            $level = $_POST['level'];
            $lesson = $_POST['lesson'];
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $user->addQuestion(new Question($title, $explain, [$level, $lesson]));
            $this->em->persist($user);
            $this->em->flush();
            Mail::to('datarah2024@gmail.com')->send(new NewSubjectMail());
            $message_success = "سوال شما با موفقیت ثبت شد.";
            return view('addQuestion', ['message_success'=>$message_success, 'content'=>$content]);
        } else {
            $message = "برای افزودن سوال، ابتدا باید وارد شوید.";
            return view('addQuestion', ['message'=>$message, 'content'=>$content]);
        }
    }

    public function confirmationQuestion()
    {
        session_start();
        if ($_SESSION['auth']['user-type'] === 'admin') {
            $q_id = $_GET['q-id'];
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$q_id]);
            $question->setConfirmation(true);
            $this->em->persist($question);
            $this->em->flush();
            return redirect()->route('profile');
        } else {
            return redirect()->route('home');
        }
    }

    public function commentQuestion()
    {
        session_start();
        if ($_SESSION['auth']['user-type'] === 'admin') {
            $q_id = $_POST['q-id'];
            $comment = $_POST['comment'];
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$q_id]);
            $question->setConfirmation(false);
            $question->setComment($comment);
            $this->em->persist($question);
            $this->em->flush();
            return redirect()->route('profile');
        } else {
            return redirect()->route('home');
        }
    }

    public function question()
    {
        session_start();
        $title = $_GET['title'];
        $created_at = $_GET['created_at'];
        $status = $_GET['status'] ?? '';
        $question = $this->em->getRepository(Question::class)->findOneBy(['title'=> $title, 'created_at'=> date_create_from_format('Y-m-d H:i:s' ,$created_at)]);
        if ($question->getConfirmation()) {
            $content = createNarration($this->em);
            $question_bookmarked = false;
            if (isset($_SESSION['auth'])) {
                $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
                $bookmark = $this->em->getRepository(Bookmark::class)->findOneBy(['user'=>$user, 'question'=>$question]);
                if ($bookmark) {
                    $question_bookmarked = true;
                }
            }
            return view('question', ['content'=>$content, 'question'=>$question, 'question_bookmarked'=>$question_bookmarked, 'status'=>$status]);
        } else {
            return redirect()->route('home');
        }
    }

    public function questionApproval(Request $request)
    {
        session_start();
        if (isset($_SESSION['auth'])) {
            $question_id = $request->question_id;
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$question_id]);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $user_id = (string)$user->getId();
            if (!in_array($user_id, $question->getApproval())) {
                if (in_array($user_id, $question->getDisapproval())) {
                    $result['number'] = 2;
                } else {
                    $result['number'] = 1;
                }
                $question->setApproval($user_id);
                $this->em->persist($question);
                $this->em->flush();
                return $result;
            }
        } else {
            $result['message'] = 'برای ثبت رای، ابتدا باید وارد حساب کاربری خود شوید.';
            return $result;
        }
    }

    public function questionDisapproval(Request $request)
    {
        session_start();
        if (isset($_SESSION['auth'])) {
            $question_id = $request->question_id;
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$question_id]);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $user_id = (string)$user->getId();
            if (!in_array($user_id, $question->getDisapproval())) {
                if (in_array($user_id, $question->getApproval())) {
                    $result['number'] = -2;
                } else {
                    $result['number'] = -1;
                }
                $question->setDisapproval($user_id);
                $this->em->persist($question);
                $this->em->flush();
                return $result;
            }
        } else {
            $result['message'] = 'برای ثبت رای، ابتدا باید وارد حساب کاربری خود شوید.';
            return $result;
        }
    }

    public function questionBookmark(Request $request): bool
    {
        session_start();
        $question_id = $request->question_id;
        if (isset($_SESSION['auth'])) {
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $question = $this->em->getRepository(Question::class)->findOneBy(['id'=>$question_id]);
            $bookmark = $this->em->getRepository(Bookmark::class)->findOneBy(['user'=>$user, 'question'=>$question]);
            if ($bookmark) {
                $this->em->remove($bookmark);
                $this->em->flush();
                $question_bookmarked = false;
            } else {
                $bookmark = new Bookmark($user, $question);
                $question->addBookmark($bookmark);
                $this->em->persist($question);
                $this->em->flush();
                $user->addBookmark($bookmark);
                $this->em->persist($user);
                $this->em->flush();
                $question_bookmarked = true;
            }

        }
        return $question_bookmarked;
    }

    public function questions()
    {
        $data = [
            'level' => 'all',
            'lesson' => 'all',
            'sort' => 'default'
        ];
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $data['sort'] = $sort;
            if ($sort === 'new') {
                $sort_type = ['created_at'=>'DESC'];
            } elseif ($sort === 'old') {
                $sort_type = ['created_at'=>'ASC'];
            } else {
                $sort_type = ['title'=>'ASC'];
            }
        } else {
            $sort_type = ['title'=>'ASC'];
        }
        $questions = $this->em->getRepository(Question::class)->findBy(['confirmation'=>true], $sort_type);
        if (isset($_GET['level']) && $_GET['level'] !== 'all') {
            $level = $_GET['level'];
            $questions = questionTagsFilter($questions, $level);
            $data['level'] = $level;
        }
        if (isset($_GET['lesson']) && $_GET['lesson'] !== 'all') {
            $lesson = $_GET['lesson'];
            $questions = questionTagsFilter($questions, $lesson);
            $data['lesson'] = $lesson;
        }
        $pages_count = ceil(count($questions) / 6);
        if (isset($_GET['page']) && $_GET['page'] !== '') {
            $questions = paginate($questions, $_GET['page'], 6);
        } else {
            $questions = paginate($questions, 1, 6);
        }
        $pages_info = ['pages_count'=>$pages_count, 'current_page'=>$_GET['page']??1];
        $content = createNarration($this->em);
        return view('questions', ['questions'=>$questions, 'data'=>$data, 'pages_info'=>$pages_info, 'content'=>$content]);
    }
}
