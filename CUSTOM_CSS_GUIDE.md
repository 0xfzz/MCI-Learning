# Custom CSS & Animation Guide

## Overview
This document explains all custom CSS animations and utilities that cannot be recreated with Tailwind CSS alone.

## File Structure

### 1. `resources/css/app.css`
Main stylesheet with core animations and configurations.

### 2. `resources/css/utilities.css`
Extended utility classes for common patterns.

---

## Custom Animations

### Defined in `app.css` and `tailwind.config.js`

#### 1. **Slow Spin Animation**
```css
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
```
**Usage:** `class="animate-spin-slow"`
**Purpose:** Slow rotating background decorations
**Duration:** 20 seconds

#### 2. **Fade In**
```css
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
```
**Usage:** `class="animate-fade-in"`
**Purpose:** Smooth entrance animation from bottom
**Duration:** 1 second

#### 3. **Fade In Up**
```css
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
```
**Usage:** `class="animate-fade-in-up"`
**Purpose:** Similar to fadeIn, alternate naming
**Duration:** 1 second

#### 4. **Fade In Right**
```css
@keyframes fadeInRight {
    from { opacity: 0; transform: translateX(60px); }
    to { opacity: 1; transform: translateX(0); }
}
```
**Usage:** `class="animate-fade-in-right"`
**Purpose:** Entrance animation from the right
**Duration:** 1 second

#### 5. **Float Animation**
```css
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-25px) rotate(2deg); }
}
```
**Usage:** `class="animate-float"`
**Purpose:** Floating effect for dashboard mockups
**Duration:** 4 seconds, infinite loop

#### 6. **Card Pulse**
```css
@keyframes cardPulse {
    0%, 100% { opacity: 0.6; border-color: rgba(167, 139, 250, 0.2); }
    50% { opacity: 1; border-color: rgba(16, 185, 129, 0.4); }
}
```
**Usage:** `class="animate-card-pulse"`
**Purpose:** Pulsing border effect for mockup cards
**Duration:** 2 seconds, infinite loop

#### 7. **Glow Effect**
```css
@keyframes glow {
    0%, 100% { box-shadow: 0 0 10px rgba(167, 139, 250, 0.3); }
    50% { box-shadow: 0 0 25px rgba(167, 139, 250, 0.6); }
}
```
**Usage:** `class="animate-glow"`
**Purpose:** Glowing shadow effect
**Duration:** 3 seconds, infinite loop

---

## Animation Delays

Use arbitrary values with Tailwind for animation delays:

```html
<div class="animate-pulse [animation-delay:0.2s]">...</div>
<div class="animate-pulse [animation-delay:0.4s]">...</div>
<div class="animate-pulse [animation-delay:3s]">...</div>
```

Or use predefined classes from `app.css`:
- `.animation-delay-100` - 0.1s
- `.animation-delay-200` - 0.2s
- `.animation-delay-300` - 0.3s
- `.animation-delay-400` - 0.4s
- `.animation-delay-500` - 0.5s
- `.animation-delay-600` - 0.6s
- `.animation-delay-3s` - 3s

---

## Scrollbar Styling

### Default Scrollbar
```css
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-thumb {
    background: #d4d4d4;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a3a3a3;
}
```

### Dark Scrollbar
```html
<div class="dark-scrollbar overflow-y-auto">...</div>
```

### Hidden Scrollbar
```html
<div class="scrollbar-hide overflow-y-auto">...</div>
```

---

## Custom Utilities (from `utilities.css`)

### 1. Gradient Text
```html
<h1 class="text-gradient-purple-green">Gradient Text</h1>
<h2 class="text-gradient-white-purple">White to Purple</h2>
```

### 2. Glass Morphism
```html
<div class="glass-effect">Light glass effect</div>
<div class="glass-effect-dark">Dark glass effect</div>
```

### 3. Hover Lift
```html
<div class="hover-lift">Lifts on hover</div>
```

### 4. Card Glow Hover
```html
<div class="card-glow">Glows on hover</div>
```

### 5. Gradient Border
```html
<div class="gradient-border rounded-xl p-6">Content with gradient border</div>
```

### 6. Scroll Reveal
```html
<div class="reveal">Reveals when scrolling into view</div>
```

Add JavaScript to activate:
```javascript
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
});

document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
```

### 7. Button Ripple
```html
<button class="btn-ripple">Click for ripple effect</button>
```

### 8. Skeleton Loading
```html
<div class="skeleton h-4 w-32 rounded"></div>
<div class="skeleton-dark h-4 w-32 rounded"></div>
```

### 9. Status Badges
```html
<span class="badge-success">Success</span>
<span class="badge-warning">Warning</span>
<span class="badge-error">Error</span>
<span class="badge-info">Info</span>
```

### 10. Progress Bar
```html
<div class="progress-bar">
    <div class="progress-bar-fill" style="width: 65%"></div>
</div>
```

### 11. Tooltip
```html
<button class="tooltip" data-tooltip="This is a tooltip">Hover me</button>
```

### 12. Notification Dot
```html
<button class="relative notification-dot">
    🔔
</button>
```

### 13. Loading Spinner
```html
<div class="spinner w-8 h-8"></div>
```

### 14. Pulse Dot
```html
<div class="w-3 h-3 bg-green-500 rounded-full pulse-dot"></div>
```

### 15. Line Clamp
```html
<p class="line-clamp-2">Long text that will be truncated to 2 lines...</p>
<p class="line-clamp-3">Long text that will be truncated to 3 lines...</p>
```

### 16. Gradient Overlays
```html
<div class="overlay-gradient-bottom">Content with bottom gradient</div>
<div class="overlay-gradient-top">Content with top gradient</div>
```

---

## Smooth Scrolling

Enabled globally:
```css
html {
    scroll-behavior: smooth;
}
```

All anchor links will scroll smoothly.

---

## Focus Visible (Accessibility)

Automatically applied to all interactive elements:
```css
*:focus-visible {
    outline: 2px solid #7c3aed;
    outline-offset: 2px;
}
```

---

## Category Toggle Animation

Special animation for video playlist categories:
```css
.category-section .video-list {
    transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
}
```

Used in `courses/show.blade.php` for collapsible video lists.

---

## Print Styles

Optimized for printing:
```css
@media print {
    nav, aside, .no-print {
        display: none !important;
    }
}
```

Add `.no-print` class to elements you don't want printed.

---

## Browser Compatibility

### Backdrop Blur Fallback
For browsers that don't support `backdrop-filter`:
```css
@supports not (backdrop-filter: blur(20px)) {
    .backdrop-blur-lg {
        background-color: rgba(17, 24, 39, 0.95) !important;
    }
}
```

---

## Best Practices

1. **Use Tailwind First**: Only use custom CSS when Tailwind can't achieve the effect
2. **Animation Performance**: Use `transform` and `opacity` for best performance
3. **Accessibility**: Always include focus states and keyboard navigation
4. **Testing**: Test animations on different devices and browsers
5. **Reduce Motion**: Consider adding `prefers-reduced-motion` media queries

---

## Adding New Animations

1. **Define in `tailwind.config.js`** for reusability:
```javascript
keyframes: {
    'my-animation': {
        '0%': { /* ... */ },
        '100%': { /* ... */ }
    }
},
animation: {
    'my-anim': 'my-animation 1s ease-in-out'
}
```

2. **Or add to `app.css`** for complex animations:
```css
@keyframes my-complex-animation {
    /* ... */
}

.animate-my-complex {
    animation: my-complex-animation 2s infinite;
}
```

---

## Resources

- Tailwind CSS Animation: https://tailwindcss.com/docs/animation
- CSS Animations: https://developer.mozilla.org/en-US/docs/Web/CSS/animation
- Web Animations API: https://developer.mozilla.org/en-US/docs/Web/API/Web_Animations_API
