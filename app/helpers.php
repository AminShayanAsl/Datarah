<?php

use App\Entities\Narration;
use App\Entities\User;
use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Morilog\Jalali\Jalalian;

function disposablePassword($len = 5): string
{
    $words = array_merge(range('a', 'z'), range('0', '9'));
    $selected_words = array_rand($words,5);
    $pass = '';
    foreach ($selected_words as $index) {
        $pass = $pass.$words[$index];
    }
    return $pass;
}

function createNarration($em)
{
    $queryBuilder = $em->createQueryBuilder();
    $countNarration = $queryBuilder->select('count(n.content)')
        ->from(Narration::class, 'n')
        ->getQuery()
        ->getSingleResult();
    return $em->find(Narration::class, rand(1, $countNarration[1]))->getContent();
}

function separateItems($items): array
{
    $confirmed = [];
    $rejected = [];
    $waited = [];
    foreach ($items as $item) {
        if ($item->getConfirmation() === true) {
            $confirmed[] = $item;
        } else if ($item->getConfirmation() === false) {
            $rejected[] = $item;
        } else {
            $waited[] = $item;
        }
    }
    return [
        'confirmed'=> $confirmed,
        'rejected'=> $rejected,
        'waited'=> $waited
    ];
}

function getJDate($datetime): Jalalian
{
    return Jalalian::fromCarbon(Carbon::parse($datetime));
}

function tagDetail($tag)
{
    if (is_numeric($tag)) {
        $level = ['اول', 'دوم', 'سوم', 'چهارم', 'پنجم', 'ششم', 'هفتم', 'هشتم', 'نهم', 'دهم', 'یازدهم', 'دوازدهم'];
        $text = $level[(int)$tag - 1];
        if ((int)$tag < 7) {
            $img = 'level_first.png';
        } elseif ((int)$tag < 10) {
            $img = 'level_second.png';
        } else {
            $img = 'level_third.png';
        }
    } else {
        $lesson = [
            'math' => 'ریاضی', 'physics' => 'فیزیک', 'chemistry' => 'شیمی', 'biology' => 'زیست',
            'earth' => 'زمین', 'poet' => 'ادبیات', 'arabic' => 'عربی', 'english' => 'انگلیسی',
            'quran' => 'دینی', 'philosophy' => 'فلسفه', 'art' => 'هنر', 'other' => 'سایر',
        ];
        $text = $lesson[$tag];
        $img = $tag.'.png';
    }
    return [
        'text' => $text,
        'image' => $img
    ];
}

function questionTagsFilter($questions, $tag): array
{
    $result = [];
    foreach ($questions as $question) {
        if (in_array($tag, $question->getTags())) {
            $result[] = $question;
        }
    }
    return $result;
}

function paginate($objs, $page_num, $per_page): array
{
    if ((int)$per_page * ((int)$page_num - 1) >= count($objs)) {
        $result = [];
    } else {
        if (intdiv(count($objs), (int)$per_page) < (int)$page_num) {
            $result = array_slice($objs, (int)$per_page * ((int)$page_num - 1), count($objs));
        } else {
            $result = array_slice($objs, (int)$per_page * ((int)$page_num - 1), (int)$per_page * (int)$page_num);
        }
    }
    return $result;
}

function confirmedQuestions($user): int
{
    $count = 0;
    foreach ($user->getQuestions() as $question) {
        if ($question->getConfirmation()) {
            $count++;
        }
    }
    return $count;
}

function confirmedAnswers($user): int
{
    $count = 0;
    foreach ($user->getAnswers() as $answer) {
        if ($answer->getConfirmation()) {
            $count++;
        }
    }
    return $count;
}

function usersSort($users_activity)
{
    $users_rank = [];
    foreach ($users_activity as $user_activity) {
        if ($users_rank === []) {
            $users_rank[] = $user_activity;
        } else {
            $flag = false;
            foreach ($users_rank as $key=>$user_rank) {
                if (isset($user_rank['score'])) {
                    if ($user_rank['score'] <= $user_activity['score']) {
                        $users_rank = array_merge(array_slice($users_rank, 0, $key), array($user_activity), array_slice($users_rank, $key));
                        $flag = true;
                        break;
                    }
                }
            }
            if (!$flag) {
                $users_rank[] = $user_activity;
            }
        }
    }
    return array_slice($users_rank, 0, 5);
}

function bestQuestionsSort($questions_vote) {
    $best_questions = [];
    foreach ($questions_vote as $question_vote) {
        if ($best_questions === []) {
            $best_questions[] = $question_vote;
        } else {
            $flag = false;
            foreach ($best_questions as $key=>$value) {
                if (isset($value['vote'])) {
                    if ($value['vote'] <= $question_vote['vote']) {
                        $best_questions = array_merge(array_slice($best_questions, 0, $key), array($question_vote), array_slice($best_questions, $key));
                        $flag = true;
                        break;
                    }
                }
            }
            if (!$flag) {
                $best_questions[] = $question_vote;
            }
        }
    }
    return array_slice($best_questions, 0, 5);
}
