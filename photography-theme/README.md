# Photography Portfolio WordPress Theme

A clean and modern WordPress theme designed specifically for photographers to showcase their work with beautiful galleries, sliders, and portfolio features.

## Features

- **Homepage Slider**: Beautiful full-screen image slider with customizable slides (up to 5 images)
- **Album/Gallery System**: Custom post type for creating photo albums with gallery functionality
- **Lightbox**: Built-in lightbox for viewing full-size images
- **Responsive Design**: Fully responsive and mobile-friendly
- **Customizer Options**: Easy-to-use theme customizer for slider images and social media links
- **Album Categories**: Organize albums by categories
- **Social Media Integration**: Add links to your social profiles
- **SEO Friendly**: Clean code structure optimized for search engines
- **Translation Ready**: Fully translatable with included .pot file

## Installation

1. Download the theme files
2. In your WordPress admin panel, go to Appearance > Themes
3. Click "Add New" and then "Upload Theme"
4. Choose the theme zip file and click "Install Now"
5. Once installed, click "Activate"

## Setup Instructions

### 1. Homepage Slider Setup
- Go to Appearance > Customize > Photography Settings
- Upload up to 5 slider images
- Add titles and descriptions for each slide
- Images will automatically rotate on the homepage

### 2. Creating Albums
- Go to Albums > Add New in your WordPress admin
- Add a title and description for your album
- Set a featured image (this will be the album cover)
- Use the "Album Gallery" meta box to add multiple images to the album
- Assign categories if desired
- Publish the album

### 3. Menu Setup
- Go to Appearance > Menus
- Create a new menu
- Add pages, albums, and categories to your menu
- Assign the menu to "Primary Menu" location

### 4. Social Media Links
- Go to Appearance > Customize > Photography Settings
- Add URLs for your social media profiles
- Supported networks: Facebook, Instagram, Twitter, YouTube, Pinterest, LinkedIn

## Theme Structure

```
photography-theme/
├── assets/
│   └── js/
│       ├── slider.js      # Homepage slider functionality
│       ├── gallery.js     # Gallery and lightbox features
│       └── main.js        # General theme JavaScript
├── style.css              # Main stylesheet
├── index.php              # Main template file
├── functions.php          # Theme functions and features
├── header.php             # Site header template
├── footer.php             # Site footer template
├── front-page.php         # Homepage template
├── archive-album.php      # Album archive page
├── single-album.php       # Single album template
└── screenshot.png         # Theme screenshot

```

## Customization

### Adding Custom CSS
You can add custom CSS through:
- Appearance > Customize > Additional CSS
- Or create a child theme for more extensive modifications

### Child Theme
To create a child theme:
1. Create a new folder in wp-content/themes/
2. Create style.css with:
```css
/*
Theme Name: Photography Portfolio Child
Template: photography-theme
*/
```
3. Create functions.php to enqueue parent styles

## Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher
- MySQL 5.6 or higher

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Credits

- Google Fonts (Inter, Playfair Display)
- Font Awesome Icons
- jQuery (included with WordPress)

## License

This theme is licensed under GPL v2 or later.

## Support

For support, please visit [your-support-url] or email [your-email]

## Changelog

### Version 1.0.0
- Initial release
- Homepage slider
- Album post type
- Gallery functionality
- Lightbox feature
- Responsive design
- Theme customizer options