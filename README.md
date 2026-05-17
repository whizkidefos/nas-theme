# NAS WordPress Theme
## National Association of Seadogs — Pyrates Confraternity

A custom WordPress theme built for NAS International, featuring:
- Pyrate-themed dark aesthetic (Red #96050D · Gold #FFDD00)
- Full membership application system with open/close windows
- Decks CPT (branches worldwide — Countries page)
- Projects CPT (with Featured flag for homepage)
- ITT (Intake & Training) password-protected portal
- Newsletter subscription with broadcast capability
- Local AI chatbot ("The Seatiger") — no external API
- Particle hero canvas, scroll animations, accordion quiz

---

## Installation

1. Upload the `nas-theme` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate **NAS Pyrates Confraternity**
3. Database tables will be created automatically on first activation
4. Pages (Home, History, Countries, etc.) are auto-created on activation

---

## Configuration

### Membership Application Window
Go to **Settings → Membership Application** to set:
- Application open/close dates
- Closed message (shown when window is closed)
- Upcoming message (use `{date}` and `{time}` placeholders)
- Notification email address

### Theme Options (Customizer)
**Appearance → Customize → NAS Theme Options:**
- **Social Media** — Facebook, X, Instagram URLs
- **Hero Section** — title, subtitle, CTA button
- **Newsletter** — notification email
- **Contact** — notification email

### Decks (Branches)
Go to **Decks → Add New** and fill in:
- Post title = Country or city name (e.g. "Manchester")
- **Deck Details** metabox: Deck Name (e.g. "Saxon"), city, address, email, phone, year founded
- Assign a **Country** taxonomy term

### Projects
Go to **Projects → Add New** and fill in:
- Title, description, featured image
- **Project Details** metabox: ☑ Featured (shows on homepage), country, status, year, link
- Assign a **Project Category**

### ITT Portal
Go to **NAS → ITT** in the admin menu:
- **Settings** — set page password, write introduction and intake information
- **Interview Questions** — add categorised Q&A pairs
- **Quiz** — add multiple-choice questions with explanations
- The public `/itt` page requires the password you set (admins always have access)

### Chatbot Training
Go to **NAS → Chatbot** in the admin menu:
- Edit the knowledge base text directly
- The bot uses keyword matching against this content
- Add/update any topics you want the bot to answer
- Click "Reset to Defaults" to restore built-in NAS knowledge

### Applications
Go to **NAS → Applications** to:
- Filter by status (pending/approved/rejected/interview) and intake window
- Click **View** to see full application details and update status/notes
- Select a window filter to reveal the **Broadcast** tool — send emails to all applicants in that window

### Newsletter
Go to **NAS → Newsletter** to:
- View all subscribers
- Compose and send a newsletter to all active subscribers
- Unsubscribe individual addresses

---

## Page Templates

Assign these templates via **Page Attributes → Template:**

| Template | Page |
|---|---|
| History | `/history` — combines About, Philosophy, Structure |
| Countries | `/countries` — Decks grid with country filter |
| Join Us | `/join` — Application form (conditional on window) |
| Skull & Crossbones | `/skull-and-crossbones` |
| ITT | `/itt` — Password protected |

---

## Navigation Menus

**Appearance → Menus** — assign menus to:
- **Primary Navigation** — main header nav
- **Footer — About Us**
- **Footer — Our Missions**
- **Footer — News & Events** (add blog categories here)

---

## Blog / News & Events

Standard WordPress posts. Categories pre-registered:
- Press Releases
- Public Articles
- Seminars & Lectures
- NAS in the News

The blog archive is at `/news-events` (set your blog page in **Settings → Reading**).

---

## File Structure

```
nas-theme/
├── style.css                    # Theme header + base variables
├── functions.php                # Core: CPTs, AJAX, admin, meta boxes
├── header.php                   # Site header + nav
├── footer.php                   # Footer + chatbot widget
├── front-page.php               # Homepage
├── index.php                    # Blog archive
├── single.php                   # Single post
├── page.php                     # Default page
├── inc/
│   └── template-loader.php      # Template registration + auto-page creation
├── page-templates/
│   ├── page-history.php         # History (About + Philosophy + Structure)
│   ├── page-countries.php       # Countries / Decks
│   ├── page-join.php            # Join Us + Application form
│   ├── page-skull.php           # Skull & Crossbones
│   └── page-itt.php             # ITT Portal (password protected)
└── assets/
    ├── css/
    │   ├── main.css             # All frontend styles
    │   └── admin.css            # WordPress admin styles
    └── js/
        ├── main.js              # Core JS: nav, canvas, forms, quiz, etc.
        ├── chatbot.js           # Chatbot widget logic
        └── admin.js             # Admin tab switching
```

---

## Fonts Used
- **Cinzel** — Display / headings (Google Fonts)
- **Crimson Pro** — Body text (Google Fonts)
- **Barlow Condensed** — UI labels, nav, buttons (Google Fonts)

---

## Brand Colours
| Name | Hex |
|---|---|
| Pyrate Red (Primary) | `#96050D` |
| NAS Gold (Secondary) | `#FFDD00` |
| NAS Black | `#0a0a0a` |

---

## Admin Menu Structure
**NAS** (custom menu)
- Dashboard — overview stats
- Applications — view/filter/update membership applications
- ITT — interview questions, quiz, intake info, broadcast
- Newsletter — subscribers + compose
- Contacts — contact form messages
- Chatbot — train the knowledge base

**Settings → Membership Application** — window dates + messages

---

*Non Nobis Solum — Not for us alone.*
