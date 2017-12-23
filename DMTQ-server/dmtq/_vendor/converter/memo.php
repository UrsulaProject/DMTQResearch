<?php

class MemoConverter {

    function getMemoList ($params) {
        return (object)[
            'guid' => $params[0],
            'fromMemoId' => $params[1],
            'limit' => $params[2]
        ];
    }
}