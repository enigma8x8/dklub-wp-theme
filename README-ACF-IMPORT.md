# ACF Fields Import Instructions

## Overview

This theme includes custom ACF (Advanced Custom Fields) fields for WooCommerce products to support the module-based design from the HTML template.

## Files Included

### 1. Product Fields JSON

- **File**: `acf-json-product-fields.json`
- **Purpose**: Contains only the product-specific ACF fields
- **Usage**: Import this file if you only want the product fields

### 2. Complete ACF Configuration

- **File**: `acf-export-dklubs-updated.json`
- **Purpose**: Contains all ACF fields including product fields, FAQ fields, and homepage fields
- **Usage**: Import this file for a complete ACF setup

## Import Instructions

### Method 1: Automatic Import (Recommended)

The theme automatically loads ACF fields from JSON files. The product fields will be available immediately after theme activation.

### Method 2: Manual Import via WordPress Admin

1. Go to **Custom Fields** > **Tools** in WordPress admin
2. Click on **Import Field Groups**
3. Choose one of the JSON files:
   - `acf-json-product-fields.json` - for product fields only
   - `acf-export-dklubs-updated.json` - for complete setup
4. Click **Import**

## Product Fields Available

### Basic Information

- **Product Image**: Uses the standard WooCommerce Product Image (Featured Image)
- **Product Subtitle**: Short description shown under the product title
- **Product Header Background**: Custom background image for the product header section
- **Product Categories**: Uses standard WooCommerce product categories ("Gatavs modulis" or "Pielāgojams modulis")

### Tab Content

- **Product Description**: Uses standard WooCommerce product description for "Moduļa apraksts" tab
- **Product Integration Tab**: Content for the "Integrācija" tab
- **Product Benefits Tab**: Content for the "Ieguvumi" tab

### Pricing Options

- **Price Period**: Text for price period (e.g., "Mēneša abonements")

### Related Products

- **Show in Related Products**: Toggle to show/hide in related products section

## Usage

### For Product Administrators

1. Create or edit a WooCommerce product
2. Set the **Product Image** (Featured Image) - this will be used as the product icon
3. Assign the product to the appropriate category:
   - "Gatavs modulis" for ready modules
   - "Pielāgojams modulis" for customizable modules
4. Scroll down to find the "Product Fields" section
5. Fill in the required fields:
   - Add a subtitle
   - Upload a header background image (optional)
   - Add content for the Integration and Benefits tabs
   - Set price period
6. Save the product

### For Developers

The fields are automatically integrated into the WooCommerce templates:

- `content-product.php` - Product loop display
- `content-single-product.php` - Single product page

## Template Integration

The ACF fields are automatically used in the WooCommerce templates:

### Product Loop (`content-product.php`)

- Displays product icon, title, subtitle, and pricing
- Shows category type and price period
- Uses custom pricing display logic

### Single Product Page (`content-single-product.php`)

- Shows product header with icon and subtitle
- Displays tabbed content (Description, Integration, Benefits)
- Shows sidebar with purchase options and related products
- Includes FAQ section at the bottom

## Customization

### Adding New Fields

1. Edit the JSON files to add new fields
2. Update the template files to use the new fields
3. Re-import the JSON file

### Modifying Field Behavior

The field logic is handled in the template files:

- `wp-content/themes/dklubs/woocommerce/content-product.php`
- `wp-content/themes/dklubs/woocommerce/content-single-product.php`

### Styling

The templates use Bootstrap classes and custom CSS. Modify the CSS files in `assets/css/` to change the appearance.

## Troubleshooting

### Fields Not Showing

1. Ensure ACF Pro is installed and activated
2. Check that the JSON files are in the correct location
3. Try manually importing the JSON files
4. Clear any caching plugins

### Template Not Working

1. Check that WooCommerce is installed and activated
2. Verify the template files are in the correct WooCommerce override location
3. Check for JavaScript errors in browser console
4. Ensure Bootstrap and other required scripts are loaded

### Related Products Not Showing

1. Check the "Show in Related Products" field is enabled
2. Verify there are other products with the same category type
3. Check the "Related Products Limit" setting

## Support

For issues with:

- **ACF Fields**: Check ACF documentation
- **WooCommerce Templates**: Check WooCommerce template override documentation
- **Theme Integration**: Check the template files in `woocommerce/` directory
