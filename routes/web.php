<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('support/', [HomeController::class, 'support']);
Route::get('amin-shayan-asl/', [HomeController::class, 'aboutUs']);
Route::get('help/', [HomeController::class, 'help']);

Route::get('sign-in/', [UserController::class, 'signIn']);
Route::get('sign-up/', [UserController::class, 'signUp']);
Route::post('sign-up-code/', [UserController::class, 'signUpCode']);
Route::post('sign-in-code/', [UserController::class, 'signInCode']);
Route::post('sign-up-account/', [UserController::class, 'signUpAccount']);
Route::post('sign-in-account/', [UserController::class, 'signInAccount']);
Route::get('profile/', [UserController::class, 'profile'])->name('profile');
Route::get('sign-out/', [UserController::class, 'signOut']);
Route::get('users-rank/', [UserController::class, 'usersRank']);

Route::get('add-question/', [QuestionController::class, 'addQuestion']);
Route::post('save-question/', [QuestionController::class, 'saveQuestion']);
Route::get('confirmation-question/', [QuestionController::class, 'confirmationQuestion']);
Route::post('comment-question/', [QuestionController::class, 'commentQuestion']);
Route::get('question/', [QuestionController::class, 'question'])->name('question');
Route::post('question-approval/', [QuestionController::class, 'questionApproval']);
Route::post('question-disapproval/', [QuestionController::class, 'questionDisapproval']);
Route::post('question-bookmark/', [QuestionController::class, 'questionBookmark']);
Route::get('questions/', [QuestionController::class, 'questions']);

Route::post('answer/', [AnswerController::class, 'answer']);
Route::get('confirmation-answer/', [AnswerController::class, 'confirmationAnswer']);
Route::post('comment-answer/', [AnswerController::class, 'commentAnswer']);
Route::post('answer-approval/', [AnswerController::class, 'answerApproval']);
Route::post('answer-disapproval/', [AnswerController::class, 'answerDisapproval']);

Route::any('{catchall}', [HomeController::class, 'error'])->where('catchall', '.*');
