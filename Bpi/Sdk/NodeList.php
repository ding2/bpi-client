<?php
namespace Bpi\Sdk;

use Bpi\Sdk\Item;

/**
 * Class NodeList interact with list of nodes.
 *
 * @package Bpi\Sdk
 */
class NodeList implements \Iterator, \Countable
{
    /**
     * Total amount of items on server
     *
     * @var int
     */
    public $total = 0;

    /**
     * @var \Bpi\Sdk\Document fetched from web service
     */
    protected $document;

    /**
     * Initiate object
     *
     * @param \Bpi\Sdk\Document $document
     */
    public function __construct(Document $document)
    {
        try
        {
            $this->document = clone $document;
            $this->document->reduceItemsByAttr('type', 'entity');
            $self = $this;
            $document->firstItem('type', 'collection')
                ->walkProperties(function($property) use ($self) {
                    $self->$property['name'] = $property['@value'];
                });
        }
        catch (Exception\EmptyList $e)
        {
            $this->document->clear();
        }
    }

    /**
     * Iterator interface implementation
     *
     * @group Iterator
     */
    function rewind()
    {
        $this->document->rewind();
    }

    /**
     * Returns same instance but with internal pointer to current item in collection
     *
     * @group Iterator
     * @return \Bpi\Sdk\Item\Node will return same instance
     */
    function current()
    {
        return new Node($this->document->current());
    }

    /**
     * Key of current iteration position
     *
     * @group Iterator
     */
    function key()
    {
        return $this->document->key();
    }

    /**
     * Iterate to next item
     *
     * @group Iterator
     */
    function next()
    {
        $this->document->next();
    }

    /**
     * Checks if is ready for iteration
     *
     * @group Iterator
     * @return boolean
     */
    function valid()
    {
        return $this->document->valid();
    }

    /**
     * Count documents
     *
     * @return integer
     */
    function count()
    {
        return $this->document->count();
    }
}
