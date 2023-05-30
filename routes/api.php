<?php
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LessonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
    Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Cours
    Route::post('cours/media', 'CoursApiController@storeMedia')->name('cours.storeMedia');
    Route::apiResource('cours', 'CoursApiController');

    // Sections
    Route::apiResource('sections', 'SectionsApiController');

    // Lecons
    Route::apiResource('lecons', 'LeconsApiController');

    // Quizs
    Route::apiResource('quizzes', 'QuizsApiController');

    // Quiz Questions
    Route::apiResource('quiz-questions', 'QuizQuestionsApiController');

    // Question Reponse
    Route::apiResource('question-reponses', 'QuestionReponseApiController');

    // Utilisateur Reponses
    Route::apiResource('utilisateur-reponses', 'UtilisateurReponsesApiController');

    // Score Quizs
    Route::apiResource('score-quizzes', 'ScoreQuizsApiController');

    // Progressions
    Route::apiResource('progressions', 'ProgressionsApiController');

    // Commentaires
    Route::post('commentaires/media', 'CommentairesApiController@storeMedia')->name('commentaires.storeMedia');
    Route::apiResource('commentaires', 'CommentairesApiController');

    // Contenus
    Route::post('contenus/media', 'ContenusApiController@storeMedia')->name('contenus.storeMedia');
    Route::apiResource('contenus', 'ContenusApiController');

    // Videos
    Route::post('videos/media', 'VideosApiController@storeMedia')->name('videos.storeMedia');
    Route::apiResource('videos', 'VideosApiController');

    // User Alerts
    Route::apiResource('user-alerts', 'UserAlertsApiController', ['except' => ['update']]);
});

