# セットアップ

```shell script
cp .env.example .env
```

dockerのローカル開発環境は各自違うと思うのでdocker-compose.example.ymlから
docker-compose.ymlをコピーし適宜書き換えて以下を実行

```shell script
cp docker-compose.example.yml docker-compose.yml
# 書き換え不要ならそのまま実行
docker-compose up -d
```

# 0. 序文

　このドキュメントには、事前に合意しておくべきいくつかの注意点が記載されています。

統一されたコーディング規約はプロジェクトの開発、読み込み、保守のコストを削減します。

よく構造化されたサンプルプロジェクトをドキュメントそのものとして使用する場合もあります。

コーディング規約はルールではありません。従って、全てのケースに適用されているとは限りません。

しかし、特定のプロジェクトで規約が適用されている場合は従うべきです。

コーディング規約は会社の標準であり、業界標準とは限りません。


# 1. ディレクトリ構造

Laravel公式のディレクトリ構造は [ここ](https://readouble.com/laravel/6.x/ja/structure.html) に記載されています。

加えて、Laravelのプロジェクトでは以下の様なディレクトリ構造が頻繁に採用されます。


## 1-2. Models ディレクトリ

絶対パス: `{project_path}/app/Models`

このディレクトリはLaravelインストール時には存在しません。
Laravelの公式見解として意図的なものです。

実際のプロジェクトでは`app/Modes`を作成し、プロジェクトで使用される全てのModelの設置場所として利用します。

Laravelでは複数のデータベースコネクションを定義できます。
（ほとんどの場合は1つのデータベースコネクションです。）
複数のコネクションを使用する場合は、
下記のように、コネクションごとに特定のディレクトリに分離する必要はありません。

```
app/Models/Mysql
app/Models/Postgresql
app/Models/Mongodb
```

代わりに、モデルのコネクションを切り替える場合は、コネクションを定義した親クラスを作成し、親クラスを継承してモデルのコネクションを切り替えます。

例(親)：
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
	protected $connection = 'mysql';
}
```

例(継承):

```php
<?php

namespace App\Models;

use App\Models\Model as AppModel;

class User extends AppModel
{
    //...
}
```
## 1.2 Services ディレクトリ

絶対パス: `{project_path}/app/Services`

Servicesディレクトリは、プロジェクトのすべてのビジネスロジックを定義するクラスを含むサービスレイヤーが格納されます。
サービス層は、以下のように下位層と対話するために使用できるすべてのメソッドを提供します。

```
Controller -> Service -> Repository -> Model
// Or
Command  -> Service -> Repository -> Model
// Repository層は無いケースの方が多い
```

このディレクトリには、これらのサービスのインターフェースも含まれます。
インターフェースファイルの次のパスに保存します。

`{project_path}/app/Services/Interfaces`

使用例:

- Interface
```php
<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
	// ....
}

```

 - Service

 ```php
namespace App\Services;

use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    // ...
}
```

## 1-3. Repositories ディレクトリ

サービスレイヤーはほとんどのビジネスロジックに拡張でき複雑なクエリを記述する必要はほとんどないため（必要に応じて、モデルクラスに記述することができます）、

デフォルトとしてRepositoriesディレクトリを追加しません。

ただし、アプリケーション構築のドメイン層の理論にしっかり従う必要がある場合は、それをプロジェクトに追加できます。

リポジトリディレクトリは、サービスディレクトリと同じように構成されています。

絶対パス:

`{project_path}/app/Repositories `


インターフェースの絶対パス:

`{project_path}/app/Repositories/Interfaces`

## 1-4. Support ディレクトリ

Supportディレクトリには、ビジネスロジックではない汎用的なロジックを格納するために利用します。
文字列/数値フォーマッタ、テキストを表示するヘルパ、サードパーティのシステム接続などの実装はここに格納します。

通常はヘルパーファイルを使用します:

`app/Support/helpers.php`

ヘルパークラス:

```
app/Support/CsvHelper.php
app/Support/JapaneseFormatter.php
```

サードパーティシステム接続の定義:

`app/Support/Ikazuchi/Api.php`

# 2.Service Provider

サービスプロバイダーは、Laravelのコアコンセプトの1つです。
詳細なドキュメントは [ここ](https://readouble.com/laravel/6.x/ja/providers.html) で読むことができます。

> イントロダクション
>
>サービスプロバイダは、Laravelアプリケーション全体の起動処理における、初めの心臓部です

プロバイダーディレクトリには、ルート、サービス、イベント、リスナーなどプロジェクトの内のすべての物が登録されています。

ここでの規則は、適切なプロバイダーに登録を記述することです。

## 2-1. AppServiceProvider

このファイルは以下を登録する:

     ─ プロジェクトサービスレイヤー内のすべてのサービスのバインディング
     ─ コアLaravelサービスまたはファサードを拡張または再登録

例:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

use App\Services\Interfaces;
use App\Services;
use App\Support\Session\MongoSessionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        Interfaces\UserServiceInterface::class => Services\UserService::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Session::extend('mongo', function ($app) {
            return new MongoSessionHandler;
        });
    }    
}
```
## 2-2. RouteServiceProvider

このファイルは、プレフィックス、名前空間、適用されたミドルウェア、名前のプレフィックスなどを含むすべてのルートを登録します

例:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * @var string
     */
    protected $adminNamespace = 'App\Http\Controllers\Admin';

   /**
    * Define the routes for the application.
    *
    * @return void
    */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
    }

    /**
     * Define the routes for admin user
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix(admin)
            ->middleware('web')
            ->namespace($this->adminNamespace)
            ->name('admin.')
            ->group(base_path('routes/admin.php'));
    }
}
```

## 2-3. EventServiceProvider

このファイルは、すべてのイベントとそのリスナーを登録します。

さらにデータベースイベントなどのコアLaravelイベントのリスナーはここに登録する必要があります。

例:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events;
use App\Listeners;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Events\CustomerRegistered::class => [
            Listeners\Customer\SendMailWelcome::class,
            Listeners\Customer\SendMailToShopManager::class,
            Listeners\Customer\PrepareCustomerStatistics::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // SQL log
        if (config('app.sql_log')) {
             DB::listen(function ($query) {
                 // ...
             });
        }
    }
}
```

## 2-4 AuthServiceProvider

このファイルには、ゲートやポリシーなどの認証または承認ロジックに関連するものを登録します。

例:

```php
<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manager', function() {
                // ....
        });
    }
}
```
