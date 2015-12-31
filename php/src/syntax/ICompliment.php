<?php
namespace Comode\syntax;

interface ICompliment
{
    public function getId();
    public function addClause(node\sequence\ICompliment $complimentSequence);
    public function provideNextInClause(node\sequence\ICompliment $complimentSequence, IComplimentFactory $complimentFactory);
    public function providePreviousInClause(node\sequence\ICompliment $complimentSequence, IComplimentFactory $complimentFactory);
    public function fetchClauses();
    public function provideArgument();
    public function provideAnswer();
}