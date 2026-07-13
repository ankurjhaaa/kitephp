<div align="center">
  <h1>🪁 KitePHP</h1>
  <p><b>The Full Stack PHP Micro-Framework</b></p>
  <p><i>Developer experience of Laravel. Speed of a React SPA. Zero heavy setup.</i></p>
</div>

---

KitePHP is a minimalist, lightning-fast PHP micro-framework designed to blur the lines between Backend and Frontend. It comes with built-in TailwindCSS, smart database migrations, a secure query builder, and **KiteJS**—a zero-config Reactive SPA engine.

## ✨ Features

- **KiteJS (Reactive SPA Engine):** Fetch HTML via AJAX, update the DOM without reloads, and add Alpine-like reactivity instantly.
- **Zero-Config Reactivity:** Declare state in HTML with `kite:data`. PHP parses it as default variables, and JS auto-binds it. No setup required.
- **Debounced Live Forms:** Add `kite:live.debounce.300ms` to any form for instant live search without writing a single line of JS.
- **Django-Style Models:** Define your database schemas directly inside your Models. 
- **Auto Migrations:** Run `php kite migrate` and the database structure automatically syncs with your code.
- **Kite Templating Engine:** A fast, secure engine similar to Laravel Blade, with `@if`, `@foreach`, and automatic `<kite-var>` reactivity wrappers.
- **Auto-SEO Engine:** Dynamically injects and swaps Meta/OpenGraph tags during SPA navigation automatically.
- **Built-in Security:** Global CSRF validation and simple route middleware for Authentication.
- **Secure Query Builder:** Fluent PDO prepared statements and built-in Pagination (`->paginate()`).
- **Built-in TailwindCSS:** Designed to look beautiful out of the box.

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

## ⚡ SPA & Reactive Engine (KiteJS)

KiteJS is what makes KitePHP special. It acts as both a Pjax-style SPA navigator and a lightweight AlpineJS-style reactive engine.

### 1. Instant Navigation & Forms
Convert any traditional web page into a Single Page Application instantly.

```html
<!-- Instant Navigation (No full page reload) -->
<a href="/about" kite:navigate>About Us</a>

<!-- AJAX Form Submission -->
<form action="/login" method="POST" kite:submit>
    @csrf
    <input type="email" name="email">
    <button type="submit">Login</button>
</form>
```

### 2. Zero-Config Reactivity & Auto-Binding
Define your state using `kite:data`. KitePHP will extract this state into backend PHP variables automatically, and KiteJS will bind it on the frontend.

```html
<div kite:data="{ count: 0, name: '', showDetails: false }">
    
    <!-- Auto-Bind Inputs: Matches name="name" with state.name -->
    <input type="text" name="name" placeholder="Type your name...">
    
    <!-- Auto-Updating Text: PHP auto-wraps this for KiteJS reactivity -->
    <h1>Hello, {{ $name }}</h1>

    <!-- Client-Side State Toggling -->
    <button kite:click="showDetails = !showDetails">Toggle Details</button>
    
    <!-- Conditional Frontend Rendering -->
    <div kite:show="showDetails">
        <p>This is hidden/shown instantly without asking the server!</p>
    </div>
</div>
```

### 3. Live Forms & Debouncing (HTMX style)
Want a live search bar? Add `kite:live` to any form. KiteJS will track your typing, maintain your cursor focus, and silently submit the form via AJAX when you stop typing.

```html
<form action="/users" method="GET" kite:submit kite:live.debounce.500ms>
    <input type="text" name="search" placeholder="Live search users...">
</form>
```

---

## 🛣️ Routing & Controllers

Routes are simple and fast. They are defined in `route/url.php`.

```php
get('/', 'HomeController@index')->name('home');
post('/users/save', 'UserController@save')->name('users.save');

// Protect routes with built-in Middleware
get('/admin', 'AdminController@index')->middleware('auth');
```

Controllers handle requests via an injected `Request` object. Validation is Laravel-inspired and automatically redirects back with flashed errors if it fails. You also have full access to the `auth()` helper.

```php
namespace App\Controller;
use Kite\Core\Request;

class UserController {
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        
        if (auth()->attempt($credentials)) {
            return redirect(route('admin'));
        }
        
        session()->flash('error', 'Invalid Credentials');
        return redirect('/login');
    }
}
```

---

## 🎨 Views (Kite Engine) & Components

KitePHP uses `.kite.php` extensions. It provides clean syntax, layout extending, and CSRF protection.

### 1. View Directives
```html
@extends('layout')

@seo('title', 'My Dashboard')
@seo('image', 'banner.png')

@section('content')
    <h1>Dashboard</h1>
    
    @if(auth()->check())
        <p>Welcome, {{ auth()->user()->name }}</p>
    @endif
    
    <ul>
    @foreach($items as $item)
        <li>{{ $item }}</li>
    @endforeach
    </ul>
    
    <!-- View Components -->
    @include('components.card', ['title' => 'My Component Title'])

    <form method="POST">
        @csrf
        <input type="text" name="email" value="{{ old('email') }}">
    </form>
@endsection
```

### 2. Auto-SEO Engine
Since KitePHP acts as a Single Page Application, standard Meta tags break. KitePHP fixes this with an Auto-SEO engine.

Simply place `{!! seo()->render() !!}` in your `<head>`.
Whenever you navigate, the engine automatically extracts the `@seo` directives from the new page and effortlessly swaps the DOM's meta tags!


---

## 🪄 Models, Schemas & Query Builder

Unlike other frameworks, schemas are defined directly inside your models (`database/models.php`). No separate migration files to manage.

```php
class User extends Model {
    public static function fields(): array {
        return [
            'name'     => Field::string(['max_length' => 255]),
            'email'    => Field::string(['max_length' => 255, 'unique' => true]),
            'password' => Field::string(['max_length' => 255]),
        ];
    }
}
```

Sync your database automatically:
```bash
php kite migrate
```

Use the secure Query Builder for complex logic:
```php
// Active Record / ORM
$user = User::objects()->find(1);
$posts = $user->posts; // Dynamic relationships

// Fluent Query Builder
$users = db('users')->where('status', 'active')->orderBy('id', 'DESC')->get();

// Pagination built-in
$paginated = db('users')->paginate(10);
```

---

## 🛠️ Helper Functions

- `view('name', $data)` - Render a template
- `route('name', ['id' => 1])` - Get a named URL
- `redirect('/url')` - Redirect user
- `db('table')` - Query builder instance
- `session()` - Session manager
- `abort(404)` - Throw HTTP error
- `asset('file.js')` - Load public asset
- `csrf_token()` - Get CSRF token value
