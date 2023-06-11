@extends('layouts.frontend')
@section('content')

@section('styles')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .quiz-results {
            margin: 15px 40px;
        }

        .question {
            margin-bottom: 20px;
        }

        .question h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .question ul {
            list-style-type: none;
            padding: 10px;
            margin: 10px;
        }

        .question li {
            margin-bottom: 5px;
        }

        .question hr {
            margin: 20px 0;

        }



        .correct {
            color: rgb(89, 176, 89);
        }

        .incorrect {
            color: red;
        }

        .correct-answer {
            width: 170px;
            background-color: #8bc34a;
            /* Green background color */
            color: #ffffff;
            /* White text color */
            font-weight: bold;
            padding: 5px 10px;
            /* Optional padding for a better visual effect */
            border-radius: 5px;
            /* Optional rounded corners for a better visual effect */
        }

        .user-selected {
            color: rgb(5, 68, 122);
        }

        .score {
            font-size: 18px;
            margin-bottom: 10px;
            margin-top: -50px;
            margin-left: 40px;
            margin-bottom: 40px;
        }
    </style>
@endsection


<body>

    <div class="score">

        Your score is: {{ $score }} / {{ $question_count }} ({{ $scorePercentage }}%)
    </div>

    @php
        $question_number = 1;
    @endphp
    <div class="quiz-results">
        @foreach ($quizResults as $result)
            <div>
            </div>
            <div class="question">
                <h3>Question{{ $question_number++ }}:: {{ $result['question'] }}</h3>
                <ul>
                    @foreach ($result['answers'] as $answer)
                        @php
                            $isCorrect = $result['isCorrect'];
                            $isSelected = in_array($answer, $result['selectedAnswers']);
                            $isUserSelected = $answer->selected;
                        @endphp
                        <li
                            class="{{ $isSelected ? ($isCorrect ? 'correct selected' : 'incorrect selected') : ($isUserSelected ? 'user-selected' : '') }}">
                            {{ $answer->reponse }}
                        </li>
                    @endforeach
                </ul>
                <p class="correct-answer">Correct Answer is: {{ implode(', ', $result['correct_Answers']) }}</p>
            </div>
            <hr> <!-- Add a horizontal line between each question -->
        @endforeach
    </div>

</body>

</html>
@endsection
