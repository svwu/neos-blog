<?php
namespace Breadlesscode\Blog\FlowQuery\Operations;

use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\Eel\FlowQuery\FlowQueryException;

class FilterByTagsOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    static protected $shortName = 'filterByTags';

    /**
     * {@inheritdoc}
     *
     * @param FlowQuery $flowQuery the FlowQuery object
     * @param array $arguments the arguments for this operation
     * @return void
     */
    public function evaluate(FlowQuery $flowQuery, array $arguments)
    {
        if (!is_array($arguments[0])) {
            throw new FlowQueryException('The first parameter of '.self::$shortName.' should be an array');
        }
        $context = $flowQuery->getContext();

        $context = \array_filter($context, function ($node) use ($arguments) {
            $tags = $node->getProperty('tags');

            if ($tags === null) {
                return false;
            }
            return count(array_intersect($tags, $arguments[0])) > 0;
        });

        $flowQuery->setContext($context);
    }
}
