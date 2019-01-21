# Fyysikkokilta 2018 WP theme

WordPress theme for Fyysikkokilta website. Based on [UnderStrap](https://understrap.com)

The theme is still quite bloated, but looking forward to clean it up prior to installation!

## Installation & running
Install theme by cloning it into the wp-content/themes folder and activate it from WP.

## Developing With npm, Gulp and SASS

### Installing Dependencies
- Make sure you have installed Node.js and Browser-Sync (optional) on your computer globally
- Then open your terminal and browse to the location of the theme
- Run: `$ npm install`
- This might require python 2, due soma package restrictions

### Running
To work with and compile your Sass files on the fly start:

- `$ gulp watch`

Or, to run with Browser-Sync:

- First change the browser-sync options to reflect your environment in the file `/gulpconfig.json` in the beginning of the file:
```javascript
{
    "browserSyncOptions" : {
        "proxy": "localhost/theme_test/", // <----- CHANGE HERE
        "notify": false
    },
    ...
};
```
- then run: `$ gulp watch-bs`


## Confused by All the CSS and Sass Files?

Some basics about the Sass and CSS files that come with UnderStrap:
- The theme itself uses the `/style.css`file only to identify the theme inside of WordPress. The file is not loaded by the theme and does not include any styles.
- The `/css/theme.css` and its minified little brother `/css/theme.min.css` file(s) provides all styles. It is composed of five different SCSS sets and one variable file at `/sass/theme.scss`.

 ```
 '@import "theme/theme_variables";   1. Add your variables into this file. Also add variables to overwrite Bootstrap or UnderStrap variables here
 '@import "../src/bootstrap-sass/assets/stylesheets/bootstrap";  // 2. All the Bootstrap stuff - Don´t edit this!
 '@import "understrap/understrap"; // 3. Some basic WordPress stylings and needed styles to combine Boostrap and Underscores
 '@import "../src/fontawesome/scss/font-awesome"; // 4. Font Awesome Icon styles
 // Any additional imported files //
 '@import "theme/theme";  // 5. Add your styles into this file
 ```

- Don’t edit the number 2-4 files/filesets listed above or you won’t be able to update Understrap without overwriting your own work!
- Your design goes into: `/sass/theme`. 
  - Add your styles to the `/sass/theme/_theme.scss` file 
  - And your variables to the `/sass/theme/_theme_variables.scss`
  - Or add other .scss files into it and `@import` it into `/sass/theme/_theme.scss`.

## Page Templates
UnderStrap includes several different page template files: (1) blank template, (2) empty template, and (3) full width template.

### Blank Template

The `blank.php` template is useful when working with various page builders and can be used as a starting blank canvas.

### Empty Template

The `empty.php` template displays a header and a footer only. A good starting point for landing pages.

### Full Width Template

The `fullwidthpage.php` template has full width layout without a sidebar.


## License
UnderStrap WordPress Theme, Copyright 2013-2018 Holger Koenemann
UnderStrap is distributed under the terms of the GNU GPL version 2

http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html