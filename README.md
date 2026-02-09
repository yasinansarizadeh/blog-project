# Glassmorph Blog - PHP & Bootstrap

A minimal glassmorphism style blog without database, using flat-file storage.

## Project Structure

- `articles/` – stores article data as `.txt` files
- `css/` – Bootstrap and custom glassmorphism styles
- `js/` – Bootstrap JS and custom animations
- `includes/` – reusable PHP components (header, footer)
- `index.php` – homepage listing all articles
- `view.php` – view single article page
- `create.php` – create new article page
- `edit.php` – edit article page
- `delete.php` – delete article page
- `config.php` – configuration and helper functions

## Features Implemented

- ✅ Glassmorphism UI design
- ✅ Responsive layout with Bootstrap 5
- ✅ Dynamic articles listing from text files
- ✅ Article cards with excerpt, date, author
- ✅ Sort articles by date (newest first)
- ✅ Empty state handling
- ✅ Single article view page
- ✅ Breadcrumb navigation
- ✅ Article content formatting
- ✅ Author information display
- ✅ Create article form with validation
- ✅ Glass-style form inputs
- ✅ Success/error messages
- ✅ Bootstrap Icons integration
- ✅ File-based storage system

## Data Storage Format

Each article is stored as `[timestamp].txt` in `articles/` folder with format: