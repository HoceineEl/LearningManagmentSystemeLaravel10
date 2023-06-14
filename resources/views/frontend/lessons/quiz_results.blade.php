@extends('layouts.frontend') @section('content') @section('styles')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    .quiz-results {
        margin: 15px 40px;
    }

    .question {
        margin-bottom: 20px;
    }

    .question-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        font-size: 16px;
        /* Increase the answer text size */
    }

    .question li span {
        font-size: 18px;
        /* Increase the answer number size */
        margin-right: 5px;
        /* Add some spacing between the answer number and text */
    }

    .question hr {
        margin: 20px 0;
    }

    .correct-answer {
        display: inline-block;
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
</style> @endsection @section('content') <div class="score"> Your score is: {{ $score }} / {{ $question_count }}
    ({{ $scorePercentage }}%) </div>
<div class="quiz-results"> @php $question_number = 1; @endphp @foreach ($quizResults as $result)
        <div class="question">
            <div class="card question-card">
                <div class="card-body">
                    <h3>Question {{ $question_number++ }}: {{ $result['question'] }}</h3>
                    <ul>
                        @foreach ($result['answers'] as $answer)
                            @php
                                $isCorrect = $result['isCorrect'];
                                $isSelected = in_array($answer, $result['selectedAnswers']);
                                $isUserSelected = $answer->selected;
                            @endphp
                            <li>
                                <span>{{ $loop->iteration }}.</span>
                                <!-- Add a span for the answer number -->
                                @if ($isUserSelected && $isCorrect)
                                    <span class="text-success">{{ $answer->reponse }}</span>
                                    <i class="bi bi-check text-success"
                                        style="font-size: 28px; margin-left: -10px; vertical-align: middle;"></i>
                                @elseif ($isUserSelected && !$isCorrect)
                                    <span class="text-danger" style="padding">{{ $answer->reponse }}</span>
                                    <i class="bi bi-x text-danger"
                                        style="font-size: 28px; margin-left: -10px; vertical-align: middle;"></i>
                                @elseif (!$isSelected && !$isCorrect)
                                    <span class="text-success">{{ $answer->reponse }}</span>
                                @else
                                    {{ $answer->reponse }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <hr> <!-- Add a horizontal line between each question -->
    @endforeach
</div> @endsection
