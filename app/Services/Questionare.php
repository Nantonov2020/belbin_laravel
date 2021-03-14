<?php


namespace App\Services;


class Questionare
{
    private  $number;
    private $question;
    private $answers;

    public function getNumber(){
        return $this->number;
    }

    public function setNumber($number){
        $this->number = $number;
    }

    public function getQuestion(){
        return $this->question;
    }

    public function setQuestion($question){
        $this->question = $question;
    }

    public function getAnswers(){
        return $this->answers;
    }

    public function setAnswers($answers){
        $this->answers = $answers;
    }

}
