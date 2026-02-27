CB Mishra Portfolio WordPress Theme
=====================================

## Installation

1. Upload the `cbmishra-theme` folder to `/wp-content/themes/`
2. Activate the theme in **Appearance > Themes**
3. Go to **CB Mishra Settings** in the admin sidebar to configure all content

## Setup Guide

### Step 1: Configure Theme Settings
Go to **CB Mishra Settings** and fill in:
- Hero section text and stats
- Contact email, LinkedIn URL, YouTube URL
- YouTube intro video embed URL
- Footer description and copyright

### Step 2: Create Required Pages
Create these pages and assign them the correct templates:
- **Hire Me** → Template: "Hire Me"
- **Book Appointment** → Template: "Book Appointment"
- **Blogs** → Template: "Blog Archive" (slug must be `blogs`)

Then set the page IDs in **CB Mishra Settings** under "Pages".

Set your **Front Page** to a static page:
- Go to **Settings > Reading**
- Set "Your homepage displays" to "A static page"
- Assign your home page (any page, content comes from front-page.php)

### Step 3: Add Content via Custom Post Types
The theme adds these custom post types in the admin:

- **Expertise** — Add "What I Do" service cards
  - Set title, write description in content editor
  - Add emoji icon in the "Expertise Details" meta box
  - Use "Menu Order" for sorting (lower = first)

- **Experience** — Add work history entries
  - Fill in Date Range, Company, Role in meta box
  - Add highlights as "Title: Description" pairs (one per line)
  - Use "Menu Order" for chronological sorting (1 = most recent)

- **Portfolio** — Add project showcase items
  - Write description in the excerpt field
  - Fill in icon, category label, and tech tags in meta box

- **Tech Stack** — Add technology categories
  - Set category number and items (comma-separated) in meta box

### Step 4: Blog Posts
Write blog posts as standard WordPress posts.
- Add featured images for best appearance
- Assign categories for proper display

### Step 5: Blog Archive URL Rewrite
Add this to your `.htaccess` or handle via WordPress rewrite rules:
The "Blogs" page with slug `blogs` and template "Blog Archive" will automatically work.

## PWA (Progressive Web App)
The theme includes full PWA support:
- Service Worker for offline caching
- Web App Manifest (auto-served at /manifest.json)
- Apple Touch Icons

To install as PWA, visit the site on mobile and use "Add to Home Screen".

## Responsive Breakpoints
- Mobile: < 480px
- Tablet: < 768px  
- Desktop: > 1024px
- Large: > 1280px

## Dark/Light Mode
Users can toggle between dark and light mode via the moon/sun button in the header.
Preference is saved in localStorage.

## Theme Customizer
Go to **Appearance > Customize** to change the site name shown in the logo.

## Security Features
- XML-RPC disabled
- WordPress version hidden from output
- All form submissions sanitized and validated
- CSRF protection via WordPress nonces

## Dependencies
- No jQuery required (vanilla JS only)
- Google Fonts loaded via CDN
- No external CSS frameworks

## Browser Support
- Chrome/Edge/Firefox/Safari (latest 2 versions)
- iOS Safari 14+
- Android Chrome 80+
