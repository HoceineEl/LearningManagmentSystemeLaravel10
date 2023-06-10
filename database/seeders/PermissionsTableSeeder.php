<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Schema;

// use Illuminate\Database\Seeders\DB;
// use DB;
class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Permission::truncate();
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'cour_create',
            ],
            [
                'id'    => 18,
                'title' => 'cour_edit',
            ],
            [
                'id'    => 19,
                'title' => 'cour_show',
            ],
            [
                'id'    => 20,
                'title' => 'cour_delete',
            ],
            [
                'id'    => 21,
                'title' => 'cour_access',
            ],
            [
                'id'    => 22,
                'title' => 'section_create',
            ],
            [
                'id'    => 23,
                'title' => 'section_edit',
            ],
            [
                'id'    => 24,
                'title' => 'section_show',
            ],
            [
                'id'    => 25,
                'title' => 'section_delete',
            ],
            [
                'id'    => 26,
                'title' => 'section_access',
            ],
            [
                'id'    => 27,
                'title' => 'lesson_create',
            ],
            [
                'id'    => 28,
                'title' => 'lesson_edit',
            ],
            [
                'id'    => 29,
                'title' => 'lesson_show',
            ],
            [
                'id'    => 30,
                'title' => 'lesson_delete',
            ],
            [
                'id'    => 31,
                'title' => 'lesson_access',
            ],
            [
                'id'    => 32,
                'title' => 'quiz_create',
            ],
            [
                'id'    => 33,
                'title' => 'quiz_edit',
            ],
            [
                'id'    => 34,
                'title' => 'quiz_show',
            ],
            [
                'id'    => 35,
                'title' => 'quiz_delete',
            ],
            [
                'id'    => 36,
                'title' => 'quiz_access',
            ],
            [
                'id'    => 37,
                'title' => 'quiz_question_create',
            ],
            [
                'id'    => 38,
                'title' => 'quiz_question_edit',
            ],
            [
                'id'    => 39,
                'title' => 'quiz_question_show',
            ],
            [
                'id'    => 40,
                'title' => 'quiz_question_delete',
            ],
            [
                'id'    => 41,
                'title' => 'quiz_question_access',
            ],
            [
                'id'    => 42,
                'title' => 'question_reponse_create',
            ],
            [
                'id'    => 43,
                'title' => 'question_reponse_edit',
            ],
            [
                'id'    => 44,
                'title' => 'question_reponse_show',
            ],
            [
                'id'    => 45,
                'title' => 'question_reponse_delete',
            ],
            [
                'id'    => 46,
                'title' => 'question_reponse_access',
            ],
            [
                'id'    => 47,
                'title' => 'utilisateur_reponse_create',
            ],
            [
                'id'    => 48,
                'title' => 'utilisateur_reponse_edit',
            ],
            [
                'id'    => 49,
                'title' => 'utilisateur_reponse_show',
            ],
            [
                'id'    => 50,
                'title' => 'utilisateur_reponse_delete',
            ],
            [
                'id'    => 51,
                'title' => 'utilisateur_reponse_access',
            ],
            [
                'id'    => 52,
                'title' => 'score_quiz_create',
            ],
            [
                'id'    => 53,
                'title' => 'score_quiz_edit',
            ],
            [
                'id'    => 54,
                'title' => 'score_quiz_show',
            ],
            [
                'id'    => 55,
                'title' => 'score_quiz_delete',
            ],
            [
                'id'    => 56,
                'title' => 'score_quiz_access',
            ],
            [
                'id'    => 57,
                'title' => 'progression_create',
            ],
            [
                'id'    => 58,
                'title' => 'progression_edit',
            ],
            [
                'id'    => 59,
                'title' => 'progression_show',
            ],
            [
                'id'    => 60,
                'title' => 'progression_delete',
            ],
            [
                'id'    => 61,
                'title' => 'progression_access',
            ],
            [
                'id'    => 62,
                'title' => 'commentaire_create',
            ],
            [
                'id'    => 63,
                'title' => 'commentaire_edit',
            ],
            [
                'id'    => 64,
                'title' => 'commentaire_show',
            ],
            [
                'id'    => 65,
                'title' => 'commentaire_delete',
            ],
            [
                'id'    => 66,
                'title' => 'commentaire_access',
            ],
            [
                'id'    => 67,
                'title' => 'contenu_create',
            ],
            [
                'id'    => 68,
                'title' => 'contenu_edit',
            ],
            [
                'id'    => 69,
                'title' => 'contenu_show',
            ],
            [
                'id'    => 70,
                'title' => 'contenu_delete',
            ],
            [
                'id'    => 71,
                'title' => 'contenu_access',
            ],
            [
                'id'    => 72,
                'title' => 'video_create',
            ],
            [
                'id'    => 73,
                'title' => 'video_edit',
            ],
            [
                'id'    => 74,
                'title' => 'video_show',
            ],
            [
                'id'    => 75,
                'title' => 'video_delete',
            ],
            [
                'id'    => 76,
                'title' => 'video_access',
            ],
            [
                'id'    => 77,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 78,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 79,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 80,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 81,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 82,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 83,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
