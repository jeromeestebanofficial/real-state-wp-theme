# Estatein Real Estate Theme

A professional WordPress theme built for real estate businesses, agencies, and property showcase websites.

It includes custom content models for properties, team members, services, testimonials, and contact submissions, plus responsive frontend templates and About/Services/Properties page experiences.

**Design reference:** [Figma Community Template](https://www.figma.com/community/file/1314076616839640516)

## Highlights

- Modern dark UI with responsive layouts for desktop, tablet, and mobile.
- Custom Post Types for `property`, `team_member`, `service`, `testimonial`, and `contact_submission`.
- Property taxonomies for `property_type` and `property_location`.
- Filterable property listing and dedicated single-property detail pages.
- About page sections (journey, values, achievements, process, team, clients).
- Built-in contact/inquiry form handling and admin submission records.
- Theme setup helpers for pages, menus, and homepage bootstrap.

## Requirements

- WordPress `5.0+` (tested up to `6.4`)
- PHP `7.4+`
- Advanced Custom Fields (ACF) Free plugin

## Installation

### Option A: WordPress Admin Upload

1. Zip the theme folder.
2. In WordPress Admin, go to `Appearance -> Themes -> Add New -> Upload Theme`.
3. Upload and activate the theme.
4. Install required plugins when prompted.

### Option B: Manual Install

1. Copy the theme folder to `wp-content/themes/`.
2. Activate `Estatein Real Estate Theme` from `Appearance -> Themes`.
3. Install/activate ACF Free.
4. Go to `Settings -> Permalinks` and click **Save Changes** once.

## Post-Install Setup

1. Create and assign a primary menu in `Appearance -> Menus`.
2. Create core pages (Home, Properties, About, Services, Contact).
3. Set page templates where applicable:
   - `page-properties.php`
   - `page-about.php`
   - `page-services.php`
4. Add Property Types and Property Locations taxonomy terms.
5. Add sample content for properties, team members, and services.

## Project Structure

```text
your-theme/
├── assets/
│   ├── css/
│   └── js/
├── inc/
│   ├── customizer.php
│   ├── setup/
│   │   ├── homepage.php
│   │   ├── menus.php
│   │   └── create-pages.php
│   └── ...
├── template-parts/
│   ├── home/
│   ├── properties/
│   ├── services/
│   └── about/
├── functions.php
├── style.css
├── front-page.php
├── archive-property.php
├── single-property.php
├── page-about.php
├── page-properties.php
└── page-services.php
```

## Core Content Models

### Custom Post Types

- `property` - property listings and details
- `team_member` - team profiles
- `service` - service entries
- `testimonial` - testimonial entries
- `contact_submission` - inquiry records from forms

### Taxonomies

- `property_type` - category/type of property
- `property_location` - location hierarchy for properties

## Styling and Branding

Global design tokens are defined in `style.css` under `:root`:

- Primary colors
- Typography scale
- Spacing system
- Border radius and transitions

For page-level styling, use files under `assets/css/` and `assets/css/components/`.

## Security Notes

- Form inputs are sanitized before storage.
- Nonce verification is used for contact form submissions.
- Safe redirects are used after form handling.
- Submissions are stored as private records.

## Development Notes

- Text domain: `estatein-theme`
- Function prefix: `estatein_theme_`
- Version: `1.0.0`
- Author: Jerome Esteban
- License: GPL v2 or later

## License

This theme is licensed under GNU GPL v2 or later.

