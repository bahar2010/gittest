# Photographer Pro - WordPress Theme

A beautiful, modern WordPress theme designed specifically for photographers to showcase their work with stunning galleries, sliders, and portfolio features.

## Features

### 🎨 **Design & Layout**
- **Responsive Design**: Fully responsive and mobile-friendly
- **Modern UI**: Clean, minimalist design focused on photography
- **Full-screen Homepage Slider**: Eye-catching hero section with image slideshow
- **Professional Color Scheme**: Elegant dark and red color palette
- **Custom Typography**: Beautiful Inter font family integration

### 📸 **Photography Features**
- **Album Management**: Custom post type for organizing photo collections
- **Gallery Grids**: Masonry-style photo layouts with hover effects
- **Lightbox Gallery**: Full-screen image viewing with navigation
- **Album Categories**: Organize albums by type (Wedding, Portrait, etc.)
- **Featured Albums**: Highlight specific albums on homepage
- **Photo Metadata**: Display photo counts, dates, and categories

### 🛠 **Functionality**
- **WordPress Customizer Integration**: Easy theme customization
- **Custom Post Types**: Built-in Album post type with custom fields
- **Navigation Menus**: Primary and footer menu locations
- **Widget Areas**: Footer widget sections
- **SEO Ready**: Optimized for search engines
- **Loading Animations**: Smooth transitions and hover effects

### 📱 **Mobile Experience**
- **Touch-friendly Navigation**: Mobile hamburger menu
- **Responsive Images**: Optimized for all screen sizes
- **Fast Loading**: Optimized CSS and JavaScript
- **Touch Gestures**: Swipe support for galleries

## Installation

### Method 1: Direct Upload
1. Download the theme files
2. Compress the `photographer-theme` folder into a ZIP file
3. Go to WordPress Admin → Appearance → Themes
4. Click "Add New" → "Upload Theme"
5. Select your ZIP file and click "Install Now"
6. Activate the theme

### Method 2: FTP Upload
1. Upload the `photographer-theme` folder to `/wp-content/themes/`
2. Go to WordPress Admin → Appearance → Themes
3. Find "Photographer Pro" and click "Activate"

## Setup Guide

### 1. Initial Configuration
After activating the theme:
- Go to **Appearance → Customize** to configure theme settings
- Navigate to **Photography Settings** panel for theme-specific options

### 2. Create Essential Pages
The theme automatically creates these pages on activation:
- **Albums** - Displays all photo albums
- **About** - About the photographer
- **Contact** - Contact information

### 3. Configure Menus
- Go to **Appearance → Menus**
- Create a new menu and assign it to "Primary Menu" location
- Add pages: Home, Albums, About, Services, Contact

### 4. Add Your Photos
- Go to **Photo Albums → Add New** in WordPress admin
- Upload images using WordPress gallery
- Set featured image for album cover
- Configure album metadata (photo count, featured status)

## Theme Customization

### Customizer Settings

#### **Homepage Settings**
- About section title and description
- About section image
- Portfolio section title

#### **Contact Information**
- Email address
- Phone number
- Physical address

#### **Social Media Links**
- Instagram URL
- Facebook URL
- Twitter URL
- Pinterest URL
- LinkedIn URL

#### **Footer Settings**
- Footer description text
- Copyright text

#### **Albums Page Settings**
- Page title and description

### Custom Post Types

#### **Albums**
- **Title**: Album name
- **Content**: Album description
- **Featured Image**: Album cover photo
- **Gallery**: Insert WordPress gallery for album photos
- **Custom Fields**:
  - Featured (checkbox): Display on homepage
  - Photo Count (number): Number of photos in album
  - Album Date (date): When album was created

#### **Album Categories**
Organize albums by type:
- Wedding Photography
- Portrait Sessions
- Nature & Landscapes
- Event Photography
- Street Photography
- Family Sessions

## File Structure

```
photographer-theme/
├── style.css              # Main stylesheet
├── index.php              # Homepage template
├── header.php             # Header template
├── footer.php             # Footer template
├── functions.php          # Theme functions
├── page-albums.php        # Albums page template
├── single-album.php       # Single album template
├── assets/
│   └── images/            # Default theme images
└── README.md              # This file
```

## Template Files

- **`index.php`**: Homepage with slider and featured albums
- **`page-albums.php`**: Albums listing page (Template: Albums Page)
- **`single-album.php`**: Individual album display
- **`header.php`**: Site header with navigation
- **`footer.php`**: Site footer with contact info and social links

## JavaScript Features

### Homepage Slider
- Automatic slideshow (5-second intervals)
- Navigation arrows and dots
- Pause on hover
- Touch/swipe support

### Lightbox Gallery
- Full-screen image viewing
- Keyboard navigation (arrow keys, escape)
- Photo counter
- Previous/next navigation

### Mobile Menu
- Responsive hamburger menu
- Smooth toggle animations

## CSS Classes Reference

### Layout Classes
- `.container`: Main content wrapper (max-width: 1200px)
- `.hero-slider`: Homepage slider section
- `.albums-grid`: Album grid layout
- `.photo-grid`: Photo gallery grid

### Interactive Elements
- `.cta-button`: Call-to-action buttons
- `.album-card`: Album preview cards
- `.photo-item`: Individual photo items
- `.lightbox`: Full-screen photo viewer

### Navigation
- `.site-header`: Main header
- `.main-navigation`: Primary menu
- `.mobile-menu-toggle`: Mobile menu button

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- iOS Safari (latest)
- Android Chrome (latest)

## Performance Features

- **Optimized CSS**: Efficient styling with minimal bloat
- **Compressed Images**: WebP support where available
- **Lazy Loading**: Native browser lazy loading for images
- **Minimal JavaScript**: Only essential scripts loaded
- **Google Fonts**: Preconnect for faster font loading

## SEO Features

- **Semantic HTML**: Proper heading structure and markup
- **Meta Tags**: Open Graph and Twitter Cards ready
- **Image Alt Tags**: Automatic alt text support
- **Schema Markup**: Ready for structured data
- **Fast Loading**: Optimized for Core Web Vitals

## Customization Tips

### Adding Your Branding
1. Upload your logo: **Customize → Site Identity → Logo**
2. Change site title: **Customize → Site Identity → Site Title**
3. Update colors: Modify CSS variables in `style.css`

### Adding More Album Types
1. Go to **Photo Albums → Categories**
2. Add new categories as needed
3. Assign categories when creating albums

### Modifying the Homepage Slider
Edit the `$slider_images` array in `index.php` to:
- Change slide images
- Update slide titles and descriptions
- Modify call-to-action buttons

## Support

For theme support and customization:
- Check WordPress documentation for general WordPress help
- Review theme files for customization examples
- Test changes in a staging environment first

## License

This theme is distributed under the GPL v2 or later license.

## Credits

- **Font**: Inter font family from Google Fonts
- **Icons**: Font Awesome 6.4.0
- **Framework**: Built with modern CSS Grid and Flexbox
- **Compatibility**: WordPress 5.0+ required

---

**Version**: 1.0.0  
**Author**: Custom Theme  
**WordPress Required**: 5.0 or higher  
**PHP Required**: 7.4 or higher