# easysite/engine

Bare skeleton on top of [`easysite/library`](vendor/easysite/library) — a minimal
custom PHP MVC engine (front controller, config-driven routing, middleware
pipeline, a thin controller/model/view layer). Comes with a working
login/register/logout/account example so a new project has something to build on
instead of an empty shell.

See `vendor/easysite/library/CHANGELOG.md` for what the engine itself provides.

## Requirements

- PHP ^8.4, extensions `pdo_mysql`
- MySQL
- Composer

## Setup

1. `composer install`
2. Fill in real values in `config/database.php` (currently placeholders —
   `host`/`dbname`/`username`/`password`).
3. `php database/install.php` — creates the database if missing and runs
   `database/schema.sql` (`users`, `user_remember_tokens`). Safe to re-run.
4. Point your webserver's document root at this directory (`.htaccess` is set up
   for Apache `mod_rewrite`; for nginx, route everything that isn't a real file
   to `index.php`), or for a quick local check:
   ```
   php -S localhost:8000
   ```
5. Open `/register`, create an account, then `/account` (requires login) and
   `/logout`.

## Structure

```
application/
  controllers/{name}Controller.php        # class {name}Controller extends Controller
  controllers/{dir}/{name}Controller.php   # subdirectory controllers, see 'dir' below
  models/{name}Model.php                   # class {name}Model extends BaseModel
  middleware/{Name}Middleware.php          # class {Name}Middleware extends Easysite\Library\Middleware
  services/                                # shared traits/services, no fixed convention
  commands/{name}Command.php               # CLI: php console.php {name}:{action}
  view/...                                 # templates + layout/
config/
  *.php                                    # each file returns an array (or a Config\* object)
database/
  schema.sql                               # hand-maintained, no migration tool
  install.php                              # applies schema.sql
public/                                    # static assets (empty for now)
storage/
  cache/                                   # file cache (config/cache.php)
  logs/                                    # config/log.php
```

## Adding a controller + route

```php
// application/controllers/pageController.php
use Easysite\Library\Controller;

class pageController extends Controller
{
    public function showAction()
    {
        $this->view->setLayout('layout/index.html');
        $this->view->render('page/show.html');
    }
}
```

```php
// config/routs.php
'page' => [
    'controller' => 'page',
    'type_method' => 'get',
    'action' => 'show',
],
```

Routing supports up to 3 nesting levels (see the comment at the top of
`config/routs.php`); `&name` marks a dynamic segment (`$this->_url_params['name']`).
After changing `routs.php`, clear the cache — the route map is cached under
`system:user_route_map`.

## Models

Every model extends `App\Models\BaseModel` and is created lazily via the
`App\Models\UsesModels` trait: `$this->model('User')` instantiates
`App\Models\UserModel` on first use, with `$this->dbRepository->getRepository('first')`
injected. No query builder — write SQL directly against `$this->db`
(`fetchOne`/`fetchAll`/`insert`/`update`/`delete`/`query`, see
`Easysite\Library\Interface\SqlRepositoryInterface`).

## Middleware

Registered in `config/middleware.php`:

```php
return [
    'aliases' => ['auth' => \App\Middleware\AuthMiddleware::class],
    'global'  => ['auth'],   // runs on every request, $params = null
];
```

A route opts into one (with parameters) via its own `middleware` key:

```php
'account' => [
    'controller' => 'account',
    'type_method' => 'get',
    'action' => 'show',
    'middleware' => ['auth' => ['role' => 'user']],
    'dir' => 'users',
],
```

`AuthMiddleware` (`application/middleware/AuthMiddleware.php`) is the one
example: it puts `Easysite\Library\Auth` on `$controller->auth` for every
request, and — when the route lists it with `role` — redirects to `/login` if
the current user doesn't have that role or better (`user` < `superuser`).

The `dir` key is optional and picks the subdirectory of
`application/controllers/` the controller is loaded from (e.g.
`application/controllers/users/accountController.php`); write your own
`{Name}Middleware` the same way for anything else that should run before an
action (validation, rate limiting, ...).

## Auth

`Easysite\Library\Auth` (engine) handles session + a separate remember-me
cookie; `App\Models\UserModel` and the `login`/`register`/`logout`/`account`
controllers (application) are the example built on top of it. See the
`Auth` class docblock and `vendor/easysite/library/CHANGELOG.md` for the
exact mechanics (cookie rotation, session fixation, etc.).

## CLI

```
php console.php ping:test
php console.php ping:test --key=value
```

Commands live in `application/commands/{name}Command.php`
(`class {name}Command extends Easysite\Library\Command`), same
controller/action convention as HTTP.
