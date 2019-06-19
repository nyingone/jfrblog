<?php
class Table implements arrayAcces

{
    public function isNew()
    {
        return empty($this->id);
    }
}
