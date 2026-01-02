Prompt: "You are a senior PHP and web frontend developer with expertise in responsive design and legacy codebase modernization. I want to make my SatanArise Heavy Metal webzine website fully responsive and mobile-ready. The site is built with PHP and currently has a fixed 1000px width layout with sidebars. Overall Requirements:
Mobile-first responsive approach
Hamburger menu on mobile (hide horizontal menu)
Hide left and right sidebars on mobile
Full-width content on mobile
Keep original desktop layout at 1024px+
Go section by section to make each content type responsive
Hamburger Menu:
Add a hamburger menu toggle button in templates/top.php
Create JavaScript file (css/responsive-menu.js) to handle menu toggle
Menu should show/hide on click
Close menu when clicking menu items or outside
Show all 8 menu items vertically on mobile
Integrate with sources/ob_page.php
Main Page:
Logo centered and responsive on mobile
Hide top banners (div#top_left, div#top_right) on mobile
Hide Facebook like button on mobile
Language flags repositioned for mobile
News grid (div.notind): 2 columns on mobile, 4 columns on desktop/tablet
Review/news cards (div.novedad, div.novs): full-width on mobile, 2 columns on tablet, 2 columns on desktop
Content Pages - Make each responsive:
Noticias (News articles):
Full-width content container
Responsive images (img.general)
Date positioned statically on mobile
Readable text with proper spacing
Críticas (Reviews):
Album cover (div#cover) centered and responsive
Band logo responsive
Tracklist and lineup full-width
Icons centered on mobile
Remove absolute positioning
Entrevistas (Interviews):
Full-width interview container
Remove margin-left on mobile
Float images (img.esq, img.dret) removed on mobile, display full-width
Questions and answers with responsive padding
Opinión (Metal Report):
Full-width content (div#entrevista)
Centered logo image (div#logoent)
Opinion text responsive (h3.texte_opinio)
Recommendations section (div.recomended) full-width with 2-column items
ShareThis buttons responsive
Crónicas (Chronicles):
Chronicle list items full-width
Single chronicle page (div#critica) full-width
Remove floats from images (img.esq, img.dret) on mobile
Centered image galleries (div.centrar)
Setlist sections responsive
Author signatures centered
Reuse recommendations section styles from opinión
Conciertos (Concerts):
Mobile: Hide left column (Conciertos/div#concerts_left), show only Agenda (div#concerts_right) at full-width
Desktop: Keep original two-column layout (no changes)
Add images to agenda items (currently text-only) - modify sources/ob_conciertos_web.php
Fetch cartell_concert field in SQL query
Wrap agenda items in div.entrada_concert structure
Images: 80px max on mobile, 106px width or 150px height on desktop
Single concert pages responsive
Technical Implementation:
Create css/responsive.css with mobile-first approach
Use @media (max-width: 1023px) for mobile styles
Use @media (min-width: 768px) and (max-width: 1023px) for tablet
Use @media (min-width: 1024px) to restore desktop layout
Modify sources/ob_page.php to include responsive.css and responsive-menu.js
Modify sources/ob_conciertos_web.php for agenda images
All images should use max-width: 100% and height: auto
Remove absolute positioning on mobile
Use box-sizing: border-box
Touch-friendly padding (15px instead of 50px)
Work is being done on the 'feature/responsive' git branch
Important Notes:
Desktop layout should be fully restored at 1024px+ (original widths, sidebars visible, etc.)
Don't create any new documentation files
Use !important where needed to override existing fixed-width CSS
Test that all content types work across breakpoints
Images should scale properly on all devices"