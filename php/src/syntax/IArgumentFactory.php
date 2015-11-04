<?php
namespace Comode\syntax;

interface IArgumentFactory
{
    public function setComplimentFactory(IComplimentFactory $complimentFactory);
    public function provideArgument(IPredicate $predicate, IQuestion $question);
    public function provideArgumentsByQuestion(node\IQuestion $questionNode);
    public function provideArgumentsByPredicate(node\IPredicate $predicateNode);
    public function provideArgumentsByCompliment(node\ICompliment $complimentNode);
}