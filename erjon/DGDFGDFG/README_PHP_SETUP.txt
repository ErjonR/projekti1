# PHP Conversion - Quick Start

This project has been converted to use PHP includes.

## Files added
- header.php / footer.php — shared layout
- config.php — MySQL connection (edit credentials)
- contact.php — PHP contact form

## Converted pages
All .html pages (except contact.html) now have .php counterparts using header/footer.

## How to run locally
1) Install PHP (if not installed).
2) From the project folder, run:
   php -S localhost:8000
3) Open http://localhost:8000/index.php in your browser.

## Notes
- Internal links inside pages were updated from .html to .php when possible.
- Original .html files are kept in case you want to compare.
