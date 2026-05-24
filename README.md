# Lumina - Online Exhibition Platform

Lumina is a premium, full-stack web application designed for hosting and participating in immersive virtual art exhibitions. Built with a focus on dark-mode aesthetics and glassmorphic UI, it bridges the gap between digital artists and global art enthusiasts.

**Live Demo:** [https://onlineexhibitionplatform-production.up.railway.app](https://onlineexhibitionplatform-production.up.railway.app)

*(Note: The live demo uses an ephemeral file system. Uploaded images are temporary, but seeded artworks and all database metrics remain persistent).*

## 🌟 Key Features

### Role-Based Access Control
- **Visitors:** Browse live exhibitions, register to attend, interact with art via likes and comments, and receive live notifications.
- **Artists (Hosts):** Dedicated dashboard to create and host new exhibitions, upload multiple artworks, and track real-time engagement analytics via interactive charts.
- **Administrators:** Centralized moderation panel to manage users, feature specific exhibitions to the homepage, and monitor overall platform growth.

### Immersive & Interactive Experience
- **360° Virtual Galleries:** Powered by Pannellum, allowing attendees to explore virtual rooms.
- **Interactive Lightboxes:** Click any artwork to view details, like the piece, and engage in comment threads with other attendees.
- **Lumina AI Assistant:** A built-in, context-aware chatbot powered by the Groq API (Llama 3 model) to assist users with navigation and art history inquiries.

## 🛠 Tech Stack

- **Backend:** Laravel 11 (PHP)
- **Database:** MySQL (Hosted on Railway)
- **Frontend:** Blade Templating, Vanilla CSS (CSS Variables, Glassmorphism)
- **Asset Bundler:** Vite
- **Integrations:** 
  - Chart.js (Data Analytics)
  - Pannellum (360° Panorama Viewer)
  - Groq API (AI Chatbot Integration)
- **Deployment:** Railway PaaS (Nixpacks)

## 🚀 Local Development Setup

If you wish to run this project locally:

1. Clone the repository:
   ```bash
   git clone https://github.com/shruti-ghoshhhh/Online_Exhibition_Platform.git
   cd Online_Exhibition_Platform
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Ensure you configure your local `DB_CONNECTION` (SQLite or MySQL) and add your `GROQ_API_KEY` for the AI Assistant.*

4. Build frontend assets and run migrations:
   ```bash
   npm run build
   php artisan migrate:fresh --seed
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```
