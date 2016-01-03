<?php
namespace Comode\syntax;

interface IWordFactory
{
    public function setPredicateFactory(IPredicateFactory $predicateFactory);
    public function setQuestionFactory(IQuestionFactory $questionFactory);
    public function setAnswerFactory(IAnswerFactory $answerFactory);
    public function provideWord($value);
    public function provideWordByPredicate(node\IPredicate $predicateNode);
    public function provideWordByQuestion(node\IQuestion $questionNode);
    public function provideWordByAnswer(node\IAnswer $answerNode);
}