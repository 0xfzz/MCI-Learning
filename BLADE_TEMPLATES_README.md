# MCI E-Learning Platform - Blade Template Structure

## Overview
This project has been converted from static HTML files to Laravel Blade templates using Tailwind CSS for styling.

## File Structure

### Layouts
- **`resources/views/layouts/app.blade.php`** - Base layout for all pages
- **`resources/views/layouts/dashboard.blade.php`** - Dashboard layout with sidebar (extends app.blade.php)

### Components
- **`resources/views/components/sidebar.blade.php`** - Left navigation sidebar for dashboard and course pages

### Pages

#### Landing Page
- **`resources/views/landing.blade.php`** - Main landing page (converted from index.html)
  - Route: `/` (named: `home`)
  - Features: Hero section, features, courses showcase, testimonials, pricing, CTA, footer
  - Fully responsive with Tailwind CSS

#### Dashboard
- **`resources/views/dashboard.blade.php`** - Main dashboard page (converted from dashboard.html)
  - Route: `/dashboard` (named: `dashboard`)
  - Features: Stats cards, continue watching section, mentor table, profile sidebar
  - Uses dashboard layout with left and right sidebars

#### Courses
- **`resources/views/courses/index.blade.php`** - Course listing page
  - Route: `/courses` (named: `courses.index`)
  - Features: Grid of available courses with categories
  
- **`resources/views/courses/show.blade.php`** - Individual course view (converted from course-platform.html)
  - Route: `/courses/{id}` (named: `courses.show`)
  - Features: Video player, breadcrumbs, forum/WhatsApp/download cards, video playlist sidebar
  - Uses dashboard layout with playlist sidebar

## Tailwind CSS Configuration

### Configuration Files
- **`tailwind.config.js`** - Tailwind configuration with custom colors, fonts, and animations
- **`vite.config.js`** - Already configured with Tailwind CSS plugin
- **`resources/css/app.css`** - Main stylesheet with Tailwind imports and custom animations
- **`resources/css/utilities.css`** - Extended utility classes for common patterns

### Custom Theme
- Primary color palette (purple shades)
- Custom font family (Inter)
- Custom animations (fade-in, spin-slow, float, glow, etc.)
- All components use Tailwind utility classes

### Custom CSS & Animations
For animations and effects that cannot be recreated with Tailwind alone, see the **[Custom CSS Guide](CUSTOM_CSS_GUIDE.md)** which includes:
- Custom keyframe animations (fade-in, float, card-pulse, etc.)
- Gradient text utilities
- Glass morphism effects
- Hover animations
- Loading skeletons
- Scrollbar styling
- And much more!

## Routes

```php
// Landing Page
Route::get('/', ...)->name('home');

// Dashboard
Route::get('/dashboard', ...)->name('dashboard');

// Courses
Route::get('/courses', ...)->name('courses.index');
Route::get('/courses/{id}', ...)->name('courses.show');
```

## Key Features

### Responsive Design
- Mobile-first approach
- Breakpoints: `sm`, `md`, `lg`, `xl`
- Hidden sidebars on smaller screens

### Interactive Elements
- Hover effects on all cards and buttons
- Smooth transitions
- Active states for navigation items

### Component Reusability
- Sidebar component shared across pages
- Consistent layout structure
- Blade sections for flexible content areas

## Running the Application

1. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Build assets:**
   ```bash
   npm run dev
   ```

3. **Start Laravel server:**
   ```bash
   php artisan serve
   ```

4. **Access the application:**
   - Landing page: http://localhost:8000
   - Dashboard: http://localhost:8000/dashboard
   - Courses: http://localhost:8000/courses
   - Single course: http://localhost:8000/courses/1

## Original HTML Files

The original HTML files have been preserved in `resources/views/`:
- `index.html` → `landing.blade.php`
- `dashboard.html` → `dashboard.blade.php`
- `course-platform.html` → `courses/show.blade.php`

## Design Changes

### From Custom CSS to Tailwind
- All inline styles removed
- Custom CSS classes replaced with Tailwind utilities
- Consistent design system using Tailwind's color palette
- Better maintainability and smaller CSS bundle

### Layout Improvements
- Grid-based layouts using Tailwind Grid
- Flexbox for component alignment
- Responsive spacing and padding
- Better component organization

## Next Steps

1. **Add Authentication:**
   - Implement user login/registration
   - Protect dashboard routes
   - Add user profile management

2. **Database Integration:**
   - Create Course, Lesson, and User models
   - Implement dynamic data loading
   - Add course enrollment functionality

3. **Interactive Features:**
   - Video progress tracking
   - Course completion status
   - Forum and discussion features
   - WhatsApp group integration

4. **Admin Panel:**
   - Course management
   - User management
   - Analytics dashboard

## Notes

- All emoji icons can be replaced with icon libraries (e.g., Heroicons, Font Awesome)
- Video embeds are placeholder YouTube links
- Demo data is hardcoded - replace with database queries
- JavaScript interactions are minimal - expand as needed
