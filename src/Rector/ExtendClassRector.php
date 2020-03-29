<?php

namespace App\Rector;

use App\Domain\SomeNamespace\ParentClass;
use PhpParser\Node;
use Rector\CodingStyle\Node\NameImporter;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\RectorDefinition\RectorDefinition;

class ExtendClassRector extends AbstractRector
{
    private NameImporter $nameImporter;

    public function __construct(NameImporter $nameImporter)
    {
        $this->nameImporter = $nameImporter;
    }

    public function getNodeTypes(): array
    {
        return [Node\Stmt\Class_::class];
    }

    /**
     * @param Node\Stmt\Class_ $node
     */
    public function refactor(Node $node): ?Node
    {
        if ($node->name->toString() !== "TestClass") {
            return null;
        }
        $node->extends = $this->nameImporter->importName(new Node\Name\FullyQualified(ParentClass::class));
        return $node;
    }

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition("", []);
    }
}