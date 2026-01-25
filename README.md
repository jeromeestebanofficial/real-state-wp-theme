# Estatein Real Estate Theme

Professional WordPress theme for real estate businesses with property listings, team management, and ACF integration. Features custom post types, responsive design, and easy content management.

**UI Design Reference:** [Figma Template](https://www.figma.com/community/file/1314076616839640516)

## Theme Features

### Property Management
- Custom Post Type: Properties with advanced fields
- Property Details: Price, bedrooms, bathrooms, area, gallery
- Property Types: Villa, Apartment, Townhouse, Commercial
- Property Locations: Cities, neighborhoods, regions
- Property Archives: Filterable property listings
- Individual Property Pages: Detailed property showcase with image galleries

### Team Management
- Team Member Profiles with contact information
- Social Media Integration for each team member
- Position & Biography management
- Team Archive Pages

### Services & Testimonials
- Services Management: Showcase your offerings
- Customer Testimonials: With ratings and client info
- Easy Admin Interface for content management

### Design Features
- Responsive Design: Works on all devices
- Modern UI: Clean, professional appearance based on Figma design
- Dark Theme: Elegant color scheme
- Custom CSS: Easy customization
- SEO Optimized: Search engine friendly
- Performance Optimized: Fast loading times

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Advanced Custom Fields (ACF) Free plugin (required)

## Installation

### Step 1: Install Theme

1. Upload the theme folder to `/wp-content/themes/`
2. Go to `WordPress Admin → Appearance → Themes`
3. Activate "Estatein Real Estate Theme"

### Step 2: Install Required Plugins

**Essential Plugin:**
- **Advanced Custom Fields (ACF) Free** - Required for property fields and content management
  - Download: https://wordpress.org/plugins/advanced-custom-fields/

**Recommended Plugins:**
- Contact Form 7 - Property inquiry forms
- Yoast SEO - Search engine optimization
- WP Google Maps - Property location maps

### Step 3: Configure Theme

1. **Create Navigation Menu:**
   - Go to `Appearance → Menus`
   - Create menu with: Home, Properties, About, Team, Services, Contact
   - Assign to "Primary Menu" location

2. **Set Up Property Types & Locations:**
   - Go to `Properties → Property Types`
   - Add types: Villa, Apartment, Townhouse, Commercial
   - Go to `Properties → Locations`

3. **Create Pages:**
   - Create a "Services" page and select "Services Page" template
   - Create other pages as needed

4. **Flush Permalinks:**
   - Go to `Settings → Permalinks`
   - Click "Save Changes"

## Theme Structure

### Template Files
```
├── style.css (Theme header & main styles)
├── functions.php (Theme functionality)
├── index.php (Homepage template)
├── header.php (Site header)
├── footer.php (Site footer)
├── single-property.php (Individual property pages)
├── archive-property.php (Property listings)
├── page-services.php (Services page template)
├── page-properties.php (Properties page template)
└── template-parts/ (Reusable template components)
```

### Custom Post Types
1. **Properties** (`property`)
   - Archives: `/properties/`
   - Single: `/property/property-name/`
   - Taxonomies: `property_type`, `property_location`

2. **Team Members** (`team_member`)
   - Archives: `/team/`
   - Single: `/team-member/name/`

3. **Services** (`service`)
   - Archives: `/service-archive/`
   - Single: `/service/service-name/`

4. **Testimonials** (`testimonial`)
   - Admin only (no public pages)
   - Used in widgets/shortcodes

## Customization

### Colors & Branding
Edit in `/style.css`:
```css
:root {
    --color-primary: #703BF7;
    --color-accent: #A685FA;
    --color-bg-primary: #141414;
    --color-text-primary: #FFFFFF;
}
```

### Logo
1. Go to `Appearance → Customize → Site Identity`
2. Upload your logo image
3. Save & Publish

## Mobile Responsiveness

The theme is fully responsive with breakpoints:
- **Desktop**: 1920px and up
- **Laptop**: 1024px - 1919px
- **Tablet**: 768px - 1023px
- **Mobile**: 767px and below

## Browser Support

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

This theme is released under GPL v2 or later license.

## Credits

- **Framework**: WordPress
- **Fields**: Advanced Custom Fields
- **UI Design**: Based on [Figma Template](https://www.figma.com/community/file/1314076616839640516)
- **Fonts**: Google Fonts (Urbanist)

---

**Version:** 1.0.0  
**Author:** Jerome Esteban
**UI Reference:** [Figma Design](https://www.figma.com/community/file/1314076616839640516)
