<?php

namespace app\helpers;

class Rolename {

    const SUPER_ADMIN = 1;
    const OPERATOR = 5;

    public static function listRole() {
        return [
            self::OPERATOR => 'Operator',
            self::SUPER_ADMIN => 'Super Admin',
        ];
    }

}
