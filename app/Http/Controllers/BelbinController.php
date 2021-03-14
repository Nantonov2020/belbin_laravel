<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Services\QuestionnairesService;


class BelbinController extends Controller
{
    public function __construct(QuestionnairesService $questionnairesService)
    {
        $this->questionnairesService = $questionnairesService;
    }

    public function start()
    {
        return view('worker.start');
    }

    public function questionnaire()
    {
        $questionares = $this->questionnairesService->makeQuestions();
        $resultsFromDB = $this->questionnairesService->giveResultsFromDBforUserID();

        if (($resultsFromDB != null)and(count($resultsFromDB) == 7)) {
            return redirect()->route('user.index');
        }

        $activeQuestion = $this->questionnairesService->giveActiveQuestion($questionares, $resultsFromDB);

        return view('worker.questionnaire',['questionares' => $activeQuestion]);
    }

    public function answer(AnswerRequest $request)
    {
        $data = $request->only(['number','answers']);

        $this->questionnairesService->processingAnswer($data);

        return redirect()->route('user.questionnaire');
    }
}
