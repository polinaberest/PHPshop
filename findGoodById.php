<?php

function findGoodById($goods, $id)
{
    foreach ($goods as $idx => $item)
        if ($item['id'] == $id)
            return $idx;
    return -1;
}