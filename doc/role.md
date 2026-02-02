# Roleの作成

役割ごとに動作や表示に制限をかける。

## Roleモデルとテーブルの作成

```bash
php artisan make:model Role -m
```

```php
<?php
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
```

=> nameカラムのみ追加

## 多対多のリレーション

今回は、Userモデルと多対多のリレーションを作成する。

多対多のリレーションを設定した場合、関係を記録するための別テーブルが必要となる。

そのテーブルを中間テーブルと呼ぶ。

中間テーブルには`user_id`と`role_id`が対になっており、どの要素とどの要素がつながっているかを記録する。

Userモデル、Roleモデルに`belognsToManyメソッド`を使いリレーションを設定する。

```php
<?php
// Userモデル
public function roles() {
    return $this->belongsToMany(Role::class);
}

// Roleモデル
public function users() {
    return $this->belongsToMany(User::class);
}
```

### 中間テーブルの作成

```bash
php artisan make:migration create_roles_users_table --create=role_user
```

`--create=テーブル名`オプション: 作成するテーブルの名前を指定するオプション

=> 中間テーブルは、関係を記録する2つのモデル名をアルファベット順に並べる(というルールがある)

マイグレーションファイルを編集:

```php
<?php
public function up(): void
{
    Schema::create('role_user', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id');
        $table->foreignId('role_id');

        $table->timestamps();
    });
}
```

## デフォルトのRoleをSeederで作成

```bash
php artisan make:seeder RolesTableSeeder
```

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// 追加
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['id' => 1, 'name' => 'admin']);
        Role::create(['id' => 2, 'name' => 'user']);
    }
}
```

Seederの実行(ファイル指定):

```bash
php artisan db:seed --class=RolesTableSeeder
```

## adminとuserの役割を持つユーザーもSeederで作成

```bash
php artisan make:seeder RoleUserTableSeeder
```

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// 追加
use App\Models\User;

class RoleUserTableSeeder extends Seeder
{
    public function run(): void
    {
        // admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],

            [
                'name'     => 'admin user',
                'password' => bcrypt('password'),
            ]
        );

        // regular user
        $regularUser = User::firstOrCreate(
            ['email' => 'test@gmail.com'],

            [
                'name'     => 'regular user',
                'password' => bcrypt('password'),
            ]
        );

        // admin userにadminロールのみ(id:1)を付与
        $adminUser->roles()->attach(1);

        // regular userにuserロールのみ(id:2)を付与
        $regularUser->roles()->attach(2);
    }
}
```

- `firstOrCreateメソッド`: 指定した条件に合致するレコードがなければ新たに作成
- `bcrypt()`: 指定した文字列をハッシュ化

```bash
# 実行
php artisan db:seed --class=RoleUserTableSeeder
```

