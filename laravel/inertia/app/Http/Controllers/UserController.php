<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        // JOIN������g�p����user_table�Apost_table�Aproduct_table�̃f�[�^������
        $users = DB::select('
            SELECT
                user_table.*,
                post_table.*,
                product_table.*
            FROM
                post_table
            JOIN
                user_table ON post_table.USER_ID = user_table.id
            LEFT JOIN
                product_table ON post_table.PRODUCT_ID = product_table.id
        ');


        return $users;
    }
}
