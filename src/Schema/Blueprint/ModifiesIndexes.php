<?php

namespace SingleStore\Laravel\Schema\Blueprint;

use SingleStore\Laravel\Fluency\SpatialIndexCommand;

trait ModifiesIndexes
{
    /**
     * @param $columns
     * @return \Illuminate\Support\Fluent
     */
    public function shardKey($columns)
    {
        return $this->indexCommand('shardKey', $columns, 'shardKeyDummyName');
    }

    /**
     * @param $columns
     * @param $direction
     * @return \Illuminate\Support\Fluent
     */
    public function sortKey($columns = null, $direction = 'asc')
    {
        $command = $this->indexCommand('sortKey', $columns, 'sortKeyDummyName');
        $command->direction = $direction;

        return $command;
    }

    /**
     * @param $columns
     * @param $name
     * @return SpatialIndexCommand
     */
    public function spatialIndex($columns, $name = null)
    {
        parent::spatialIndex($columns, $name);

        return $this->recastLastCommand(SpatialIndexCommand::class);
    }

    /**
     * @param  string|array  $columns
     * @param  string|null  $name
     * @param  string|null  $algorithm
     * @return \Illuminate\Database\Schema\IndexDefinition
     */
    public function hashUnique($columns, $name = null, $algorithm = null)
    {
        return $this->indexCommand('hashUnique', $columns, $name, $algorithm);
    }

    /**
     * @param  string|array  $columns
     * @param  string|null  $name
     * @param  string|null  $algorithm
     * @return \Illuminate\Database\Schema\IndexDefinition
     */
    public function hashIndex($columns, $name = null, $algorithm = null)
    {
        return $this->indexCommand('hashIndex', $columns, $name, $algorithm);
    }

    /**
     * Recast the last fluent command into a different class,
     * which is helpful for IDE completion.
     *
     * @template T
     *
     * @param  class-string<T>  $class
     * @return T
     */
    protected function recastLastCommand($class)
    {
        return $this->commands[] = new $class(array_pop($this->commands)->getAttributes());
    }
}
