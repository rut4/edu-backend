<?php
interface IResourceCollection
{
    public function fetch();

    public function fetchFilter($field, $value);

    public function fetchAvg($field);

    public function fetchAvgFilter($field, $filterField, $value);

}
