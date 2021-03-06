<?php

namespace App\Http\Middleware;

use Menu;
use Closure;
use Entrust;

class LaravelMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //左側
        Menu::make('left', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            if (auth()->check()) {
                $menu->add('我的課表', ['route' => 'courseTable.my']);
                $menu->add('公開課表', ['route' => 'courseTable.index']);
            }
            //$menu->add('Home', ['route' => 'index']);
            //$menu->add('About', 'javascript:void(0)');
            //$menu->add('Contact', 'javascript:void(0)');
        });
        //右側
        Menu::make('right', function ($menu) {
            /* @var \Lavary\Menu\Builder $menu */
            //會員
            if (auth()->check()) {
                if (!auth()->user()->isConfirmed) {
                    $menu->add('尚未完成信箱驗證', ['route' => 'confirm-mail.resend'])
                        ->link->attr(['class' => 'text-danger']);
                }
                $menu->add('課程', ['route' => 'course.index']);
                $menu->add('教師', ['route' => 'teacher.index']);
                $menu->add('空堂分析', ['route' => 'analysis.index']);
                //管理員
                if (Entrust::can('menu.view') and auth()->user()->isConfirmed) {
                    /** @var \Lavary\Menu\Builder $courseManageMenu */
                    $courseManageMenu = $menu->add('CS管理', 'javascript:void(0)');
                    if (Entrust::can('courseTable.manage')) {
                        $courseManageMenu->add('課表管理', ['route' => 'admin.courseTable.index']);
                    }
                    if (Entrust::can('course.manage')) {
                        $courseManageMenu->add('課程管理', ['route' => 'admin.course.index']);
                    }
                    if (Entrust::can('teacher.manage')) {
                        $courseManageMenu->add('教師管理', ['route' => 'admin.teacher.index']);
                    }

                    /** @var \Lavary\Menu\Builder $adminMenu */
                    $adminMenu = $menu->add('管理選單', 'javascript:void(0)');

                    if (Entrust::can(['user.manage', 'user.view'])) {
                        $adminMenu->add('會員清單', ['route' => 'user.index'])->active('user/*');
                    }

                    if (Entrust::can('role.manage')) {
                        $adminMenu->add('角色管理', ['route' => 'role.index']);
                    }

                    if (Entrust::can('log-viewer.access')) {
                        $adminMenu->add(
                            '記錄檢視器 <i class="fa fa-external-link" aria-hidden="true"></i>',
                            ['route' => 'log-viewer::dashboard']
                        )->link->attr('target', '_blank');
                    }
                }
                /** @var \Lavary\Menu\Builder $userMenu */
                $userMenu = $menu->add(auth()->user()->name, 'javascript:void(0)');
                $userMenu->add('個人資料', ['route' => 'profile'])->active('profile/*');
                $userMenu->add('登出', ['route' => 'logout']);
            } else {
                //遊客
                $menu->add('登入', ['route' => 'login']);
            }
        });

        return $next($request);
    }
}
