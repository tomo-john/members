<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserRegistered;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */

    /** 元のコード
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
     */

    // 作り直し
    public function create(array $input): User
    {
        // 1. バリデーション実行
        // 成功すると、ルールに定義した項目だけが $validated に入る
        $validated = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
            'avatar' => ['nullable', 'image', 'max:1024'],
        ])->validate();

        // 2. ユーザーデータの準備
        $userData = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'], // Fortifyが自動でハッシュ化しない設定なら Hash::make() が必要
        ];

        // 3. アバター処理
        // バリデーション後の $validated['avatar'] を使うのが安全！
        if (isset($input['avatar'])) {
            $timestamp = now()->format('YmdHis');
            $originalName = $input['avatar']->getClientOriginalName();
            $filename = $timestamp . '_' . $originalName;

            $input['avatar']->storeAs('avatar', $filename, 'public');
            $userData['avatar'] = $filename;
        }

        // ユーザーを作成
        $user = User::create($userData);

        // デフォルトの役割を追加
        $user->roles()->attach(2);

        // 管理者への通知を送信
        Notification::route('mail', config('mail.admin'))->notify(new NewUserRegistered($user));
        return $user;
    }
}
