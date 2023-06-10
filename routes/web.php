<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\VideoController;
use App\Models\LessonVideo;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Frontend\LessonController as FrontendLessonController;
use Illuminate\Support\Facades\Http;


Route::view('/', 'welcome');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Cours
    Route::delete('cours/destroy', 'CoursController@massDestroy')->name('cours.massDestroy');
    Route::post('cours/media', 'CoursController@storeMedia')->name('cours.storeMedia');
    Route::post('cours/ckmedia', 'CoursController@storeCKEditorImages')->name('cours.storeCKEditorImages');
    Route::resource('cours', 'CoursController');





    // Quizs
    Route::delete('quizzes/destroy', 'QuizsController@massDestroy')->name('quizzes.massDestroy');
    Route::get('quizzes/create/{lesson}', 'QuizsController@create')->name('quizzes.create');
    Route::post('quiz-questions/store', 'QuizQuestionsController@store')->name('admin.quiz-questions.store');
    Route::resource('quizzes', 'QuizsController');

    // Quiz Questions
    Route::delete('quiz-questions/destroy', 'QuizQuestionsController@massDestroy')->name('quiz-questions.massDestroy');
    Route::get('quiz-questions/{quiz}','QuizQuestionsController@index1');
    // ('admin/quiz-questions/store/'.$quizzes)
    Route::get('quiz-questions/index1/{quiz}','QuizQuestionsController@index1')->name('quiz-questions.index1');
    Route::post('quiz-questions/store/{quizzes}','QuizQuestionsController@store');
    // admin/quiz-questions/create 
    Route::get('quiz-questions/create/{quiz}','QuizQuestionsController@create');
    Route::resource('quiz-questions', 'QuizQuestionsController');



    // Question Reponse
    Route::delete('question-reponses/destroy', 'QuestionReponseController@massDestroy')->name('question-reponses.massDestroy');
    Route::get('question-reponses/{question}', 'QuestionReponseController@index1');
    Route::get('question-reponses/create/{question}', 'QuestionReponseController@create');
    Route::post('question-reponses/store/{question}', 'QuestionReponseController@store');
    Route::get('question-reponses/index1/{question}','QuestionReponseController@index1')->name('questionReponses.index1');
    Route::resource('question-reponses', 'QuestionReponseController');




    // Utilisateur Reponses
    Route::delete('utilisateur-reponses/destroy', 'UtilisateurReponsesController@massDestroy')->name('utilisateur-reponses.massDestroy');
    Route::resource('utilisateur-reponses', 'UtilisateurReponsesController');

    // Score Quizs
    Route::delete('score-quizzes/destroy', 'ScoreQuizsController@massDestroy')->name('score-quizzes.massDestroy');
    Route::resource('score-quizzes', 'ScoreQuizsController');

    // Progressions
    Route::delete('progressions/destroy', 'ProgressionsController@massDestroy')->name('progressions.massDestroy');
    Route::resource('progressions', 'ProgressionsController');

    // Commentaires
    Route::delete('commentaires/destroy', 'CommentairesController@massDestroy')->name('commentaires.massDestroy');
    Route::post('commentaires/media', 'CommentairesController@storeMedia')->name('commentaires.storeMedia');
    Route::post('commentaires/ckmedia', 'CommentairesController@storeCKEditorImages')->name('commentaires.storeCKEditorImages');
    Route::resource('commentaires', 'CommentairesController');

    // Contenus
    Route::delete('contenus/destroy', 'ContenusController@massDestroy')->name('contenus.massDestroy');
    Route::post('contenus/media', 'ContenusController@storeMedia')->name('contenus.storeMedia');
    Route::post('contenus/ckmedia', 'ContenusController@storeCKEditorImages')->name('contenus.storeCKEditorImages');
    Route::resource('contenus', 'ContenusController');

    // Videos
    Route::delete('videos/destroy', 'VideosController@massDestroy')->name('videos.massDestroy');
    Route::post('videos/media', 'VideosController@storeMedia')->name('videos.storeMedia');
    Route::post('videos/ckmedia', 'VideosController@storeCKEditorImages')->name('videos.storeCKEditorImages');
    Route::resource('videos', 'VideosController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::get('messenger', 'MessengerController@index')->name('messenger.index');
    Route::get('messenger/create', 'MessengerController@createTopic')->name('messenger.createTopic');
    Route::post('messenger', 'MessengerController@storeTopic')->name('messenger.storeTopic');
    Route::get('messenger/inbox', 'MessengerController@showInbox')->name('messenger.showInbox');
    Route::get('messenger/outbox', 'MessengerController@showOutbox')->name('messenger.showOutbox');
    Route::get('messenger/{topic}', 'MessengerController@showMessages')->name('messenger.showMessages');
    Route::delete('messenger/{topic}', 'MessengerController@destroyTopic')->name('messenger.destroyTopic');
    Route::post('messenger/{topic}/reply', 'MessengerController@replyToTopic')->name('messenger.reply');
    Route::get('messenger/{topic}/reply', 'MessengerController@showReply')->name('messenger.showReply');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Cours
    Route::delete('cours/destroy', 'CoursController@massDestroy')->name('cours.massDestroy');
    Route::post('cours/media', 'CoursController@storeMedia')->name('cours.storeMedia');
    Route::post('cours/ckmedia', 'CoursController@storeCKEditorImages')->name('cours.storeCKEditorImages');
    Route::resource('cours', 'CoursController');

    //lessons
    Route::get('/lesson/show/{lesson}', [FrontendLessonController::class, 'show'])->name('lesson.show');


    // Quizs
    Route::delete('quizzes/destroy', 'QuizsController@massDestroy')->name('quizzes.massDestroy');
    Route::resource('quizzes', 'QuizsController');

    // Quiz Questions
    Route::delete('quiz-questions/destroy', 'QuizQuestionsController@massDestroy')->name('quiz-questions.massDestroy');
    Route::resource('quiz-questions', 'QuizQuestionsController');

    // Question Reponse
    Route::delete('question-reponses/destroy', 'QuestionReponseController@massDestroy')->name('question-reponses.massDestroy');
    Route::resource('question-reponses', 'QuestionReponseController');

    // Utilisateur Reponses
    Route::delete('utilisateur-reponses/destroy', 'UtilisateurReponsesController@massDestroy')->name('utilisateur-reponses.massDestroy');
    Route::resource('utilisateur-reponses', 'UtilisateurReponsesController');

    // Score Quizs
    Route::delete('score-quizzes/destroy', 'ScoreQuizsController@massDestroy')->name('score-quizzes.massDestroy');
    Route::resource('score-quizzes', 'ScoreQuizsController');

    // Progressions
    Route::delete('progressions/destroy', 'ProgressionsController@massDestroy')->name('progressions.massDestroy');
    Route::resource('progressions', 'ProgressionsController');

    // Commentaires
    Route::delete('commentaires/destroy', 'CommentairesController@massDestroy')->name('commentaires.massDestroy');
    Route::post('commentaires/media', 'CommentairesController@storeMedia')->name('commentaires.storeMedia');
    Route::post('commentaires/ckmedia', 'CommentairesController@storeCKEditorImages')->name('commentaires.storeCKEditorImages');
    Route::resource('commentaires', 'CommentairesController');

    // Contenus
    Route::delete('contenus/destroy', 'ContenusController@massDestroy')->name('contenus.massDestroy');
    Route::post('contenus/media', 'ContenusController@storeMedia')->name('contenus.storeMedia');
    Route::post('contenus/ckmedia', 'ContenusController@storeCKEditorImages')->name('contenus.storeCKEditorImages');
    Route::resource('contenus', 'ContenusController');

    // Videos
    Route::delete('videos/destroy', 'VideosController@massDestroy')->name('videos.massDestroy');
    Route::post('videos/media', 'VideosController@storeMedia')->name('videos.storeMedia');
    Route::post('videos/ckmedia', 'VideosController@storeCKEditorImages')->name('videos.storeCKEditorImages');
    Route::resource('videos', 'VideosController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});


////////////////////////////////? HOUCEINE 

Route::post('clearVideos', [VideoController::class, 'clear'])->name('videos.clear');
Route::get('/videos/create/{lesson}', [VideoController::class, 'create'])->name('videos.create');
Route::resource('videos', VideoController::class);
Route::get('/captions/example.vtt', function () {
    $response = Http::get('http://ffmpegvideojs.test/captions/example.vtt');
    return $response->body();
});
Route::get('/video-conversion-progress', [VideoController::class, 'getVideoConversionProgress'])->name('video-conversion-progress');



////////////////////////////////////?Hamza /////////////////////////////////////////
// *******/ Sections : 

Route::post('/saveSection', [SectionController::class, 'store']);
Route::put('/updateSectionPosition', [SectionController::class, 'updatePosition']);
Route::delete('/sections/delete/{section}', [SectionController::class, 'delete']);
Route::get('/editSection', [SectionController::class, 'edit'])->name('section.edit');
Route::put('/sections/{section}', [SectionController::class, 'update']);
Route::put('/lessons/{lesson}', [LessonController::class, 'update']);
// Route::delete('sections/destroy', 'SectionsController@massDestroy')->name('sections.massDestroy');
// Route::resource('sections', 'SectionsController');

// *******/ Lessons : 
Route::get('/lessons/{cour}', [LessonController::class, 'index'])->name('section.index');
Route::post('/saveLesson', [LessonController::class, 'store']);
Route::put('/updateLessonPosition', [LessonController::class, 'updatePosition']);
Route::delete('/lessons/delete/{lesson}', [LessonController::class, 'delete']);
// Route::delete('lecons/destroy', 'LeconsController@massDestroy')->name('lecons.massDestroy');
// Route::resource('lecons', 'LeconsController');



////////////////////////////?         Abdallah
//* route to the dashboard
Route::get('dashboard', 'DashboardController@index')->name('dashboard');

//* route to the unapproved users table
Route::get('/unapproved_users',[UsersController::class, 'unapprovedUsersTable'])->name('/unapproved_users');

//* route to approve a user
Route::get('approve/{user}', [UsersController::class, 'approve'])->name('approve.user');

//* route to delete an unapproved user
Route::delete('delete/{user}', [UsersController::class, 'deleteUnapproved'])->name('delete.user');




//?Hamza Ben Allou 
