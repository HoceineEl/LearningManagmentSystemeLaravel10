@extends('layouts.frontend')
@section('content')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .step-container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .step {
            display: none;
        }

        .step.current {
            display: block;
        }

        .question {
            margin-bottom: 20px;
        }

        .question h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .answerList {
            list-style-type: none;
            padding: 0;
            text-decoration: none;

        }

        .answer {
            margin-bottom: 10px;
            text-decoration: none;
            list-style-type: none;
        }

        input[type="checkbox"] {
            margin-right: 5px;
            text-decoration: none;
            transform: scale(1.5);
            /* Increase the size of the checkboxes */

        }

        label {
            font-size: 20px;
        }

        .button {
            display: block;
            /* position: relative; */
            width: 30%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #ffffff;
            background-color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 50%;
            margin-left: 100px;

        }

        .button:hover {
            background-color: #0056b3;
        }

        .submit {
            width: 30%;
            /* display: flex; */
            background-color: #28a745;
            margin-left: 50p;
            /* float: right; */

        }

        .submit:hover {
            background-color: #1e7d39;
        }
    </style>
@endsection
<div class="step-container">
    <form id="multi-step-form" method="post" action="{{ url('user/reponse') }}">
        @csrf
        @foreach ($quiz as $singleQuiz)
            <input type="hidden" name="quiz_id" value="{{ $singleQuiz->id }}"> <!-- Add this line to store the quiz ID -->
            <span class="badge bg-primary badge-lg">{{ $singleQuiz->nom }}</span>
            @foreach ($singleQuiz->quizQuizQuestions as $key => $question)
                <div class="step{{ $key === 0 ? ' current' : '' }}">
                    <div class="question">
                        <h3 style="margin-top: 20px;">{{ $question->question }}</h3>
                        <ul class="answerListe">
                            @foreach ($question->questionQuestionReponses as $answer)
                                <li class="answer">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]"
                                        value="{{ $answer->id }}">
                                    <label>{{ $answer->reponse }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($key < $singleQuiz->quizQuizQuestions->count() - 1)
                        <button type="button" class="button next" style="margin-left:230px; ">Next</button>
                    @else
                        <button type="submit" class="button submit" style="margin-left:230px; ">Submit</button>
                    @endif
                </div>
            @endforeach
        @endforeach
    </form>
</div>

{{-- <script>
    $(document).ready(function() {
        var currentStep = 0;
        var totalSteps = $(".step").length;

        function showStep(stepNumber) {
            $(".step").hide();
            $(".step:eq(" + stepNumber + ")").show();
        }

        function updateButtons() {
            if (currentStep === totalSteps - 1) {
                $(".next").hide();
                $(".submit").show();
            } else {
                $(".next").show();
                $(".submit").hide();
            }
        }

        updateButtons();

        $(".next").click(function() {
            var $currentStep = $(".step").eq(currentStep);

            if (currentStep < totalSteps - 1) {
                currentStep++;
                showStep(currentStep);
                updateButtons();
            }
        });
    });
</script> --}}

@endsection
