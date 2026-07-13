# 🪁 KitePHP - The Full Stack PHP Micro-Framework

KitePHP gives you the developer experience of Laravel and the blazing speed of a React SPA, without the heavy setup. It comes with built-in TailwindCSS, smart migrations, a query builder, and a zero-config Single Page Application engine.

## ✨ Features

- **Zero-Config SPA Engine (KiteJS):** Fetch HTML via AJAX and update the DOM and browser history seamlessly.
- **Django-Style Models:** Define schemas directly inside models. No separate migration files required.
- **Auto Migrations:** Just run `php kite migrate` and the database structure automatically syncs with your models.
- **Kite Templating Engine:** A fast, secure engine similar to Laravel Blade.
- **Secure Query Builder:** PDO prepared statements out of the box to prevent SQL injection.
- **Built-in TailwindCSS:** Designed to look beautiful from the start with a customized dark mode UI.
- **Minimalist & Lightweight:** No bloat, incredibly fast, and easy to understand.

---

## 📁 Directory Structure

```text
kitephp/
├── app/          # Application Logic
│   └── controller/ # HTTP Controllers (e.g. HomeController.php)
├── core/         # The Framework Engine (Core logic)
├── database/     # SQLite DB & Config
│   └── models.php  # Define Models & Schemas here
├── helper/       # Global helper functions (route, view, db, etc)
├── public/       # Web Root (index.php, CSS, JS assets)
├── resource/     # Frontend Resources
│   └── view/       # Kite Templates (*.kite.php)
├── route/        # Web Routes
│   └── url.php     # Map URLs to Controllers
└── kite          # Command Line Interface Tool (CLI)
```

---

## 🛣️ Routing

Routes are registered in `route/url.php`.

```php
// Basic GET and POST routes
get('/', 'HomeController@index')->name('home');
post('/login', 'AuthController@login')->name('login.post');

// Route parameters
get('/user/{id}', function($id) {
    return "User ID: " . $id;
});
```

---

## ⚙️ Controllers & Request

Controllers handle incoming HTTP requests. The `Request` object is injected automatically.

```php
namespace App\Controller;
use Kite\Core\Request;

class UserController {
    public function store(Request $request) {
        $name = $request->input('name', 'Default');
        
        session()->flash('success', 'Created successfully!');
        
        return redirect(route('home'));
    }
}
```

---

## 🎨 Views (Kite Engine)

KitePHP uses `.kite.php` extensions for templates, providing a clean syntax similar to Laravel Blade.

```html
@extends('layout')

@section('content')
    <h1>Hello {{ $user->name }}</h1>
    
    @if($user->isAdmin)
        <p>Admin access</p>
    @endif
    
    <ul>
    @foreach($items as $item)
        <li>{{ $item }}</li>
    @endforeach
    </ul>
@endsection
```

---

## 🪄 Models & Migrations

Define schemas directly in `database/models.php`.

```php
class Product extends Model {
    public static function schema(): array {
        return [
            'id'    => Field::id(),
            'name'  => Field::string()->nullable(),
            'slug'  => Field::string()->unique(),
            'price' => Field::integer()->default('0'),
        ];
    }
}
```

To automatically sync your database schema, just run:
```bash
php kite migrate
```

---

## 🔍 Query Builder

Interact with your database securely.

```php
$users = db('users')->where('status', 'active')->get();
$user = db('users')->find(1);

// Insert
db('users')->insert(['name' => 'John']);

// Update
db('users')->where('id', 1)->update(['name' => 'Jane']);

// Delete
db('users')->where('id', 1)->delete();
```

---

## ⚡ SPA Engine (KiteJS)

KiteJS intercepts clicks and form submissions, fetching content via AJAX for a lightning-fast experience.

```html
<!-- Instant Navigation -->
<a href="/about" kite:navigate="about">About Us</a>

<!-- AJAX Form Submission -->
<form action="/login" method="POST" kite:submit="login">
    @csrf
    <input type="email" name="email">
    <button type="submit">Login</button>
</form>
```

---

## 🛠️ Helper Functions

- `view('name', $data)` - Renders a template
- `route('name')` - Gets named URL
- `redirect('/url')` - Redirect user
- `db()` - Query builder instance
- `session()` - Session manager
- `abort(404)` - Throw HTTP error
- `asset('file.js')` - Load public asset URL
- `csrf_token()` - Get CSRF token value
