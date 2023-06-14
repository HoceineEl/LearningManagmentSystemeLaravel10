<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQuizRequest;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuestionReponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizsController extends Controller
{
    public function hi($lesson){
         $quiz = Quiz::all()->where('lesson_id',$lesson);
        // dd($quiz->id);
        return view('frontend.lessons.quiz',compact('quiz'));
    }
    public function index()
    {
        abort_if(Gate::denies('quiz_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quizzes = Quiz::with(['lesson'])->get();

        return view('frontend.quizzes.index', compact('quizzes'));
    }


    public function create()
    {
        abort_if(Gate::denies('quiz_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.quizzes.create', compact('lessons'));
    }

    public function store(StoreQuizRequest $request)
    {
        $quiz = Quiz::create($request->all());

        return redirect()->route('frontend.quizzes.index');
    }

    public function edit(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::pluck('label', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quiz->load('lesson');

        return view('frontend.quizzes.edit', compact('lessons', 'quiz'));
    }

    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $quiz->update($request->all());

        return redirect()->route('frontend.quizzes.index');
    }

    public function show(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->load('lesson', 'quizQuizQuestions', 'quizScoreQuizzes');

        return view('frontend.quizzes.show', compact('quiz'));
    }

    public function destroy(Quiz $quiz)
    {
        abort_if(Gate::denies('quiz_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quiz->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuizRequest $request)
    {
        $quizzes = Quiz::find(request('ids'));

        foreach ($quizzes as $quiz) {
            $quiz->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }



    public function hamza(Request $request)
    {
        // Retrieve the selected answers
        $selectedAnswers = $request->input('answers');
        $quizId = $request->input('quiz_id'); // Assuming you have a hidden input field with the name 'quiz_id' in your form
        
        // Get the questions and their answers from your data source
        $questions = QuizQuestion::with(['questionQuestionReponses'])
            ->whereHas('quiz', function ($query) use ($quizId) {
                $query->where('id', $quizId);
            })
            ->get();
                // $questions = QuizQuestion::with(['questionQuestionReponses'])
        // ->whereHas('quiz', function ($query) use ($quizId) {
        //     $query->where('id', $quizId);
        // })
        // ->get();

        // Prepare an array to store the quiz results and the score
        $quizResults = [];
        $score = 0;
        $question_count = 0;
    
        foreach ($questions as $question) {
            $questionText=$question->question;
            $correctAnswers = [];
            $correct_Answers = [];

            $selected = isset($selectedAnswers[$question->id]) ? $selectedAnswers[$question->id] : [];
    
            foreach ($question->questionQuestionReponses as $answer) {
                $answer->selected = in_array($answer->id, $selected); // Add 'selected' property to each answer
                if ($answer->est_correct) {
                    $correctAnswers[] = $answer->id; // Store the ID of the correct answer
                    $correct_Answers [] =$answer->reponse;
                }
            }
    
            $isCorrect = count($correctAnswers) === count($selected) && empty(array_diff($correctAnswers, $selected));
    
            if ($isCorrect) {
                $score++; // Increment the score if the answer is correct
            }
            
            $quizResults[] = [
                // 'question' => $question->question,
                'question' => $questionText,
                'answers' => $question->questionQuestionReponses, // Add 'answers' property
                'isCorrect' => $isCorrect,
                'selectedAnswers' => $selected,
                'correctAnswers' => $correctAnswers,
                'correct_Answers'=>$correct_Answers,
            ];
            $question_count++;
        }
        $scorePercentage = ($question_count > 0) ? round(($score / $question_count) * 100) : 0;
        // $scorePercentage = round(($score / $question_count) * 100);
    
        return view('frontend.lessons.quiz_results', compact('quizResults', 'score', 'question_count', 'scorePercentage'));
    }
}
