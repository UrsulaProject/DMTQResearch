<?php

class MemoController {

    function getMemoList ($params) {
        return (object)[
            'result' => [
                // [
                //     'memo_id' => 112525,
                //     'sender_guid' => 1,
                //     'sender_display_name' => "\uc6b4\uc601\uc790",
                //     'content' => 'Hello 2018 Skin',
                //     'memo_type' => 'G',
                //     'btn_type' => 'C',
                //     'product_id' => 110002,
                //     'admin_yn' => 'Y',
                //     'reg_date' => '20171223',
                //     'remain_see' => 1838075
                // ]
            ],
            'error' => NULL
        ];
    }
}