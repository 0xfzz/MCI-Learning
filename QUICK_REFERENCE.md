# MCI E-Learning - Quick Reference

## 🚀 Getting Started

```bash
# Install dependencies
composer install
npm install

# Start development
npm run dev
php artisan serve
```

## 📁 Key Files

| File | Purpose |
|------|---------|
| `resources/views/landing.blade.php` | Landing page |
| `resources/views/dashboard.blade.php` | Main dashboard |
| `resources/views/courses/show.blade.php` | Course player |
| `resources/views/layouts/dashboard.blade.php` | Dashboard layout |
| `resources/views/components/sidebar.blade.php` | Navigation sidebar |
| `resources/css/app.css` | Main styles + animations |
| `resources/css/utilities.css` | Custom utility classes |
| `tailwind.config.js` | Tailwind configuration |

## 🎨 Color Palette

```css
/* Primary Colors (Purple) */
purple-500: #8b5cf6
purple-600: #7c3aed (main brand color)
purple-700: #6d28d9

/* Accent Colors */
green-500: #10b981 (success, accent)
pink-500: #ec4899 (gradient accent)
blue-500: #3b82f6 (info)
```

## ✨ Common Animation Classes

```html
<!-- Fade In -->
<div class="animate-fade-in">...</div>

<!-- Slow Spin (20s) -->
<div class="animate-spin-slow">...</div>

<!-- Float Effect -->
<div class="animate-float">...</div>

<!-- Pulse with delay -->
<div class="animate-pulse [animation-delay:0.2s]">...</div>

<!-- Glow Effect -->
<div class="animate-glow">...</div>
```

## 🎯 Common Patterns

### Card with Hover Effect
```html
<div class="bg-white border border-gray-200 rounded-2xl p-6 
            hover:border-purple-500 hover:-translate-y-2 
            hover:shadow-2xl transition-all cursor-pointer">
    Content
</div>
```

### Gradient Button
```html
<button class="px-8 py-4 bg-gradient-to-r from-purple-500 to-green-500 
               rounded-full text-white font-semibold 
               hover:shadow-2xl hover:shadow-purple-500/50 
               transition-all hover:-translate-y-1">
    Button Text
</button>
```

### Gradient Text
```html
<h1 class="text-6xl font-black bg-gradient-to-r 
           from-white via-purple-400 to-green-400 
           bg-clip-text text-transparent">
    Gradient Text
</h1>
```

### Glass Effect
```html
<div class="backdrop-blur-lg bg-gray-900/85 border border-white/10">
    Glass morphism content
</div>
```

## 🛠️ Custom Utilities

```html
<!-- Gradient text -->
<span class="text-gradient-purple-green">Text</span>

<!-- Glass effect -->
<div class="glass-effect">Content</div>

<!-- Hover lift -->
<div class="hover-lift">Lifts on hover</div>

<!-- Card glow -->
<div class="card-glow">Glows on hover</div>

<!-- Loading skeleton -->
<div class="skeleton h-4 w-32 rounded"></div>

<!-- Status badges -->
<span class="badge-success">Success</span>
<span class="badge-warning">Warning</span>
<span class="badge-error">Error</span>

<!-- Tooltip -->
<button class="tooltip" data-tooltip="Help text">?</button>

<!-- Hide scrollbar -->
<div class="scrollbar-hide overflow-y-auto">...</div>

<!-- Line clamp -->
<p class="line-clamp-2">Long text...</p>
```

## 📱 Responsive Breakpoints

```css
sm:  640px   /* Tablet */
md:  768px   /* Tablet landscape */
lg:  1024px  /* Desktop */
xl:  1280px  /* Large desktop */
```

## 🔗 Named Routes

```php
route('home')           // Landing page
route('dashboard')      // Dashboard
route('courses.index')  // Course list
route('courses.show', 1) // Course detail
```

## 🎭 Layout Sections

### Dashboard Layout
```blade
@extends('layouts.dashboard')

@section('search-placeholder', 'Search here...')

@section('content')
    <!-- Main content -->
@endsection

@section('right-sidebar')
    <!-- Optional right sidebar -->
@endsection
```

### App Layout
```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <!-- Page content -->
@endsection

@push('scripts')
    <script>/* JS */</script>
@endpush

@push('styles')
    <style>/* CSS */</style>
@endpush
```

## 🔧 Debugging

```bash
# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Rebuild assets
npm run build
```

## 📚 Documentation

- [Blade Templates Guide](BLADE_TEMPLATES_README.md)
- [Custom CSS Guide](CUSTOM_CSS_GUIDE.md)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)

## 🎨 Design Tokens

```css
/* Spacing Scale */
gap-3 = 0.75rem = 12px
gap-4 = 1rem = 16px
gap-6 = 1.5rem = 24px
gap-8 = 2rem = 32px

/* Border Radius */
rounded-lg = 8px
rounded-xl = 12px
rounded-2xl = 16px
rounded-3xl = 24px
rounded-full = 9999px

/* Shadows */
shadow-lg: Subtle elevation
shadow-xl: Medium elevation
shadow-2xl: Heavy elevation

/* Font Weights */
font-medium: 500
font-semibold: 600
font-bold: 700
font-extrabold: 800
font-black: 900
```

## 🚨 Common Issues

### Styles not updating?
```bash
npm run dev --force
# or
npm run build
```

### Blade syntax errors?
```bash
php artisan view:clear
```

### Routes not found?
```bash
php artisan route:clear
php artisan optimize:clear
```

## 💡 Pro Tips

1. Use `@vite(['resources/css/app.css'])` in layouts
2. Prefix custom classes with project name to avoid conflicts
3. Test animations with `prefers-reduced-motion`
4. Use semantic HTML for accessibility
5. Keep components small and reusable
6. Document complex animations
7. Use Tailwind's arbitrary values: `[animation-delay:0.2s]`
8. Leverage browser DevTools for debugging animations

## 🔗 Quick Links

- Local: http://localhost:8000
- Landing: http://localhost:8000
- Dashboard: http://localhost:8000/dashboard
- Courses: http://localhost:8000/courses
