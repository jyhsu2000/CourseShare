<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Migrations\Migration;

class CreateCourseManagePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permCourseTableManage = Permission::create([
            'name'         => 'courseTable.manage',
            'display_name' => '管理課表',
            'description'  => '',
            'protection'   => false,
        ]);
        $permCourseManage = Permission::create([
            'name'         => 'course.manage',
            'display_name' => '管理課程',
            'description'  => '',
            'protection'   => false,
        ]);
        $permCourseTimeManage = Permission::create([
            'name'         => 'courseTime.manage',
            'display_name' => '管理開課時間',
            'description'  => '',
            'protection'   => false,
        ]);
        $permPeriodManage = Permission::create([
            'name'         => 'period.manage',
            'display_name' => '管理節次',
            'description'  => '',
            'protection'   => false,
        ]);
        $permTeacherManage = Permission::create([
            'name'         => 'teacher.manage',
            'display_name' => '管理教師',
            'description'  => '',
            'protection'   => false,
        ]);

        // Find Admin and give permission to him
        /* @var Role $admin */
        $admin = Role::where('name', 'Admin')->first();
        $admin->attachPermission($permCourseTableManage);
        $admin->attachPermission($permCourseManage);
        $admin->attachPermission($permCourseTimeManage);
        $admin->attachPermission($permPeriodManage);
        $admin->attachPermission($permTeacherManage);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'courseTable.manage')->delete();
        Permission::where('name', 'course.manage')->delete();
        Permission::where('name', 'courseTime.manage')->delete();
        Permission::where('name', 'period.manage')->delete();
        Permission::where('name', 'teacher.manage')->delete();
    }
}
