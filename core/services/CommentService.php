<?php

namespace core\services;

use core\helpers\Database;

class CommentService {

    public static function addCommentInDatabase($fields) {

        $params = [
            ":userId" => $fields["userId"],
            ":noticeId" => $fields["noticeId"],
            ":comment" => $fields["comment"]
        ];

        $db = new Database();
        $db->insert("INSERT INTO notice_comments VALUES (0, :userId, :noticeId, :comment, NOW())", $params);

    }

}