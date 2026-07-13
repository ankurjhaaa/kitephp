# KitePHP AI Agent Instructions

You are working on a project built with **KitePHP**, a lightweight, high-performance PHP micro-framework.
When writing code for this project, you MUST strictly adhere to the following architectural guidelines and syntax rules.

## Core Philosophy
- KitePHP is a zero-config, minimalist framework. Do NOT introduce Composer dependencies (like Laravel Eloquent, Guzzle, or Twig) unless explicitly asked by the user.
- The framework handles its own Routing, Views, ORM, and SPA rendering.

## Directory Structure
- `app/controller/`: Place all your Controller classes here.
- `database/models.php`: Define ALL database models and schemas in this single file. No external migration files!
- `resource/view/`: Place all views here. Use the `.kite.php` extension.
- `route/url.php`: Register all web routes here.
- `public/`: The web root. CSS, JS, and `index.php` live here.

## 1. Routing (`route/url.php`)
Use global route functions. Name your routes using `->name()`.
```php
get('/', 'HomeController@index')->name('home');
post('/login', 'AuthController@login')->name('login.post');
get('/user/{id}', function($id) { ... });
```

## 2. Request Handling, Validation & Controllers
Controllers must be in the `App\Controller` namespace. The `Kite\Core\Request` object captures GET/POST/JSON inputs and is automatically injected.

**Form Validation:**
KitePHP provides Laravel-style validation. Use `$request->validate()`. If validation fails, it automatically redirects back with flashed errors and old input.
```php
namespace App\Controller;
use Kite\Core\Request;

class UserController {
    public function store(Request $request) {
        // Validation (Automatically redirects on failure)
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email'
        ]);

        // Insert into DB
        db('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        session()->flash('success', 'User added!');
        return redirect(route('home'));
    }
}
```

## 3. Database & Models (`database/models.php`)
KitePHP uses a Django-style auto-migration system. Do NOT create Laravel-style migration files. Define the schema directly in the model class inside `database/models.php`.
```php
class Post extends Model {
    public static function schema(): array {
        return [
            'user_id' => Field::foreignId('users', 'id', ['onDelete' => 'CASCADE']),
            'title'   => Field::string(),
        ];
    }
}
```
*Note: To sync the database, instruct the user to run `php kite migrate`.*

## 4. Query Builder (Filtering & CRUD)
Use the global `db()` helper for all database operations. It uses PDO prepared statements automatically to prevent SQL injection.

**Filtering (Selects):**
```php
// Basic Select
$users = db('users')->where('status', 'active')->get(); // Returns array of objects

// First result only
$user = db('users')->where('id', 1)->first(); // Returns a single object

// Advanced Filtering (>, <, !=)
$expensiveItems = db('products')->where('price', '>', 1000)->get();

// Joins (Raw SQL)
$posts = db('posts')
    ->select('posts.*', 'users.name as author_name')
    ->join('users', 'posts.user_id = users.id')
    ->get();

// ORM Relationships (Eloquent Style)
// In Model:
// public function posts() { return $this->hasMany(Post::class, 'user_id'); }
// public function user() { return $this->belongsTo(User::class, 'user_id'); }
$user = User::objects()->first();
$userPosts = $user->posts; // Magic property triggers method automatically

// Chaining
$query = db('users')
    ->where('role', 'admin')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->get();

// Pagination
$users = db('users')->orderBy('id', 'DESC')->paginate(10);
// In the view, render links: {!! $users->links() !!}
```

**Insert, Update, Delete:**
```php
// Insert (Returns new ID)
$insertId = db('users')->insert([
    'name' => 'John', 
    'role' => 'user'
]);

// Update (Returns affected rows count)
db('users')->where('id', $insertId)->update(['role' => 'admin']);

// Delete
db('users')->where('id', $insertId)->delete();
```

## 5. Views & Templating
All views MUST be in `resource/view/` and end with `.kite.php`.
- Extend layouts: `@extends('layout')`
- Define sections: `@section('content') ... @endsection`
- Output variables: `{{ $variable }}` (escapes HTML automatically). For raw output, use `{!! $variable !!}`.
- Logic: `@if(condition) ... @elseif(...) ... @else ... @endif`
- Loops: `@foreach($items as $item) ... @endforeach`
- CSRF Token: `@csrf` (Use inside all POST forms).
- Validation Errors: `@error('field') {{ $message }} @enderror`
- Old Form Input: `{{ old('field', $default) }}`

## 6. SPA & Reactive Engine (KiteJS)
KitePHP acts as a Single Page Application without any build tools, and includes a built-in Alpine-like Reactive Engine.

**SPA Navigation:**
- **Navigation without reload:** `<a href="/about" kite:navigate>About</a>`
- **AJAX Form Submission:** `<form action="/login" method="POST" kite:submit>`
  - When `kite:submit` is present, the form submits via AJAX.
  - If the controller returns a `redirect()`, KiteJS will automatically fetch the new page via AJAX and update the DOM!

**Reactive State & Auto-Binding:**
- **Define State & PHP Defaults:** Use `kite:data="{ count: 0, search: '' }"` on a container. PHP will automatically parse this and inject these as default variables into the view!
- **Auto-Update Text:** Simply write `{{ $count }}`. PHP automatically wraps this in `<kite-var>`, and `kite.js` updates it instantly when the state changes. NO `kite:text` needed!
- **Auto-Bind Inputs:** Simply use the `name` attribute matching the state key: `<input type="text" name="search">`. KiteJS will automatically establish two-way binding. NO `kite:model` needed!
- **Client-Side Functions:** Use `kite:click="count++"` or `kite:function="doSomething()"` to execute Javascript logic directly in the reactive state context.

## 7. Global Helpers
- `view('view.name', ['key' => 'value'])`
- `route('route.name')`
- `redirect('/url')`
- `asset('filename.ext')`
- `session()->set('key', 'val')`
- `session()->flash('key', 'msg')`
- `db()`

## Styling
- **Tailwind CSS** is loaded via the local `public/tailwind.js` file.
- Do NOT write custom CSS unless absolutely necessary. Use pure Tailwind utility classes in the HTML.
- Default to a modern, clean, dark-mode friendly design when generating new UI components.
