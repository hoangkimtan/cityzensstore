<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminUserController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);

            return $next($request);
        });
    }

    function list(Request $request)
    {
        $status = $request->input('status');
        $list_act = [
            'trash' => 'Xóa tạm thời'
        ];
        if ($status == "trash") {
            $list_act = [
                'restore' => 'Khôi phục',
                'force_delete' => 'Xóa vĩnh viễn'
            ];
            $users = User::onlyTrashed()->paginate(10);
        } else {
            $key = "";
            if ($request->input('key')) {
                $key = $request->input('key');
            }
            $users = User::where("name", "LIKE", "%{$key}%")->paginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        return view('admin.user.index', compact('users', 'count', 'list_act'));
    }

    function add()
    {
        return view('admin.user.add');
    }

    function delete($id)
    {
        if (Auth::id() != $id) {
            User::withTrashed()->find($id)->delete();
            return redirect('admin/user/list')->with('alert', 'Bạn đã xóa thành công');
        } else {
            return redirect('admin/user/list')->with('alert', 'Bạn không thể xóa chính mình ra khỏi hệ thống');
        }
    }

    function update($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        return view('admin.user.update', compact('user'));
    }

    function storeUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['confirmed'],
            ],
            [
                'required' => ':attribute không để trống',
                'string' => ':attribute kí tự không hợp lệ',
                'max' => ':attribute tối đa 255 kí tự',
                'min' => ':attribute tối thiểu 8 kí tự',
                'unique' => ':attribute đã tồn tại',
                'confirmed' => ':attribute mật khẩu không khớp'
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );
        $password = !empty($request->password) ? Hash::make($request->password) : User::find($id)->password;
        User::withTrashed()->where('id', $id)->update([
            'name' => $request->input('name'),
            'password' => $password,
        ]);

        return redirect()->back()->with('alert', 'Cập nhật thành công');
    }

    function store(Request $request)
    {
        if ($request->input('btn-add')) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ],
                [
                    'required' => ':attribute không để trống',
                    'string' => ':attribute kí tự không hợp lệ',
                    'max' => ':attribute tối đa 255 kí tự',
                    'min' => ':attribute tối thiểu 8 kí tự',
                    'unique' => ':attribute đã tồn tại',
                    'confirmed' => ':attribute mật khẩu không khớp'
                ],
                [
                    'name' => 'Họ và tên',
                    'email' => 'Email',
                    'password' => 'Mật khẩu'
                ]
            );
            DB::transaction(function () use ($request) {
                User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                ]);
            });
            return redirect('admin/user/add')->with('alert', 'Thêm mới thành công');
        }
    }

    function action(Request $request)
    {
        $list_check = $request->input('listcheck');
        if ($list_check) {
            foreach ($list_check as $k => $v) {
                if (Auth::id() == $v) {
                    unset($list_check[$k]);
                }
            }
            if (!empty($list_check)) {
                $action = $request->input('action');
                if ($action == "") {
                    return redirect('admin/user/list')->with('alert', 'Bạn chưa chọn hành động nào');
                } elseif ($action == "trash") {
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('alert', 'Xóa tạm thời thành công');
                } elseif ($action == "restore") {
                    User::whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('alert', 'Bạn đã khôi phục thành công');
                } elseif ($action == "force_delete") {
                    User::whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list')->with('alert', 'Xóa vĩnh viễn tài khoản thành công');
                }
            } else {
                return redirect('admin/user/list')->with('alert', 'Bạn không thể thao tác trên user của mình');
            }
        } else {
            return redirect('admin/user/list')->with('alert', 'Bạn chưa chọn user nào');
        }
    }
}
