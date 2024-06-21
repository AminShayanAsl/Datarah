<?php

namespace App\Http\Controllers;

use App\Entities\Answer;
use App\Entities\Bookmark;
use App\Entities\Question;
use App\Entities\User;
use App\Mail\RegisterMail;
use App\Mail\SignInMail;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    public function signIn() {
        session_start();
        if(isset($_SESSION['auth'])) {
            return redirect()->route('profile');
        } else {
            return view('signIn');
        }
    }
    public function signUp() {
        session_start();
        if(isset($_SESSION['auth'])) {
            return redirect()->route('profile');
        } else {
            return view('signUp');
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function signUpCode(Request $request) {
        $email = $request->email;
        $count = $this->ExistsEmail($email);
        if ($count == 0) {
            Mail::to($email)->send(new RegisterMail($email));
        } else {
            return "ایمیل وارد شده از قبل ثبت گردیده است.";
        }
    }
    public function signUpAccount() {
        $display_name = $_POST['display-name'];
        $email = $_POST['email'];
        $code = $_POST['code'];

        session_start();
        if (!preg_match("/[a-z]/i", $display_name) & !preg_match("/[\x{0600}-\x{06FF}\x]{1,32}/u", $display_name)) {
            $message = "نام کاربری باید حداقل شامل یک حرف باشد.";
            return view('signUp', ['message'=>$message]);
        } else if (time() - $_SESSION['register']['code_time'] > 125) {
            $message = "مدت زمان کد ارسالی به اتمام رسیده است.";
            return view('signUp', ['message'=>$message]);
        } else if ($code != $_SESSION['register']['code']) {
            $message = "کد ارسالی با کد وارد شده مطابقت ندارد.";
            return view('signUp', ['message'=>$message]);
        } else if ($email != $_SESSION['register']['email']) {
            $message = "ایمیل هم‌خوانی ندارد.";
            return view('signUp', ['message'=>$message]);
        } else {
            $user = new User($display_name, $email);
            $this->em->persist($user);
            $this->em->flush();
            if ($email === 'datarah2024@gmail.com') {
                $type = 'admin';
            } else {
                $type = 'user';
            }
            $_SESSION['auth'] = ['user-type'=>$type, 'display-name'=>$display_name, 'email'=>$email];
            return redirect()->route('profile');
        }
    }
    public function signInCode(Request $request)
    {
        $email = $request->email;
        $count = $this->ExistsEmail($email);
        if ($count > 0) {
            Mail::to($email)->send(new SignInMail($email));
        } else {
            return "با ایمیل وارد شده ثبت‌نام صورت نگرفته است.";
        }
    }
    public function signInAccount()
    {
        $email = $_POST['email'];
        $code = $_POST['code'];

        session_start();
        if (time() - $_SESSION['sign-in']['code_time'] > 125) {
            $message = "مدت زمان کد ارسالی به اتمام رسیده است.";
            return view('signIn', ['message'=>$message]);
        } else if ($code != $_SESSION['sign-in']['code']) {
            $message = "کد ارسالی با کد وارد شده مطابقت ندارد.";
            return view('signIn', ['message'=>$message]);
        } else if ($email != $_SESSION['sign-in']['email']) {
            $message = "ایمیل هم‌خوانی ندارد.";
            return view('signIn', ['message'=>$message]);
        } else {
            if ($email === 'datarah2024@gmail.com') {
                $type = 'admin';
            } else {
                $type = 'user';
            }
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$email]);
            $_SESSION['auth'] = ['user-type'=>$type, 'display-name'=>$user->getDisplayName(), 'email'=>$email];
            return redirect()->route('profile');
        }
    }
    public function profile()
    {
        session_start();
        if(isset($_SESSION['auth'])) {
            $content = createNarration($this->em);
            $user = $this->em->getRepository(User::class)->findOneBy(['email'=>$_SESSION['auth']['email']]);
            $bookmarks = $this->em->getRepository(Bookmark::class)->findBy(['user'=>$user]);
            if ($_SESSION['auth']['user-type'] === 'admin') {
                $questions = $this->em->getRepository(Question::class)->findAll();
                $answers = $this->em->getRepository(Answer::class)->findAll();
            } else {
                $questions = $this->em->getRepository(Question::class)->findBy(['user'=> $user]);
                $answers = $this->em->getRepository(Answer::class)->findBy(['user'=> $user]);
            }
            $separateQuestions = separateItems($questions);
            $separateAnswers = separateItems($answers);
            return view('profile', ['questions'=>$separateQuestions, 'answers'=>$separateAnswers, 'bookmarks'=>$bookmarks, 'content'=>$content]);
        } else {
            return redirect()->route('home');
        }
    }

    public function signOut(): \Illuminate\Http\RedirectResponse
    {
        session_start();
        if(isset($_SESSION['auth'])) {
            unset($_SESSION['auth']);
        }
        return redirect()->route('home');
    }

    public function usersRank()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        $users_activity = [];
        foreach ($users as $user) {
            $confirmed_questions = confirmedQuestions($user);
            $confirmed_answers = confirmedAnswers($user);
            $users_activity[] = [
                'display_name' => $user->getDisplayName(),
                'confirmed_questions' => $confirmed_questions,
                'confirmed_answers' => $confirmed_answers,
                'score' => $confirmed_answers * 10 + $confirmed_questions * 5
            ];
        }
        $users_rank = usersSort($users_activity);
        $content = createNarration($this->em);
        return view('usersRank', ['users_rank'=>$users_rank, 'content'=>$content]);
    }

    protected function ExistsEmail($email) {
        $queryBuilder = $this->em->createQueryBuilder();
        $count = $queryBuilder->select('count(u.id)')
            ->from(User::class, 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getSingleResult();
        return $count[1];
    }
}
