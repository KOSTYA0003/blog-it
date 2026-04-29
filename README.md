# 📚 IT-Blog

## 📖 Project Description

IT-Blog is an educational blog project with a full-fledged user, article, and comment management system. The project demonstrates the capabilities of Laravel in building multi-level systems with a role-based access model.

## 🚀 Main Features

### 👥 Users and Roles

- **User** — can read articles and leave comments
- **Author** — can create articles, edit them, and submit them for moderation
- **Moderator** — can approve or reject articles with a comment
- **Administrator** — full access: user management, role management, banning

### 📝 Articles

- Create, edit, delete articles
- Statuses: draft, under review, published, rejected
- Article categories
- Short description and full text
- Publication date

### 💬 Comments

- Nested comments (replies to replies)
- Ability to reply to any comment
- Delete own comments

### 🛡️ Moderation

- Queue of articles pending review
- Approve/reject with a reason
- Moderator's feedback visible to the author

### 👑 Administration

- User management
- Role assignment
- Ban / unban users
- Delete users

## 🛠️ Technology Stack

| Technology | Purpose |
|------------|---------|
| Laravel 10 | Main PHP framework |
| MySQL | Relational database |
| Tailwind CSS | Modern UI styling |
| Alpine.js | Lightweight client-side interactivity |
| Livewire | Reactive components (Full-stack Laravel) |
| Vite | Frontend asset bundling |
| Docker | Development environment containerization |


## 🖼️ Interface

### Home Page
![Main Page](screenshots/main.png)

### Viewing an article and comments
![Article](screenshots/article_with_comments.png)

### Author's Dashboard
![My Articles](screenshots/my_articles.png)

### Admin Panel
![Admin Panel](screenshots/admin_panel.png)


## 📦 Installation and Setup (Docker)
This is the recommended way to run the project. No local PHP/MySQL installation is required.

    1. Clone the project and set up the environment:

```bash
    git clone https://github.com/KOSTYA0003/blog-it.git
```

```bash
    cd blog-it
```

```bash
    cp .env.example .env # For Windows CMD use: copy .env.example .env
```

    Make sure the database settings in .env match Docker: DB_HOST=db, DB_PASSWORD=root

    2. Start the containers:

```bash
    docker-compose up -d --build
```

    3. Install dependencies and configure the application:

```bash
    docker exec -it it-blog-app composer install
```

```bash
    docker exec -it it-blog-app php artisan key:generate
```

```bash
    docker exec -it it-blog-app npm install --force
```

```bash
    docker exec -it it-blog-app npm run build
```

    4. Run migrations and seed the database:

```bash
    docker exec -it it-blog-app php artisan migrate:fresh --seed
```

   
**Access the application:**
- Website: [http://localhost:8000](http://localhost:8000)
- Database  (phpMyAdmin): [http://localhost:8081](http://localhost:8081)



## 👤 Test Users

After running `php artisan migrate:fresh --seed`, the following accounts will be available:


| Email |  Password |  Role |
| :--- | :--- | :--- |
| **user@example.com** | `password` | User |
| **author@example.com** | `password` | Author |
| **moderator@example.com** | `password` | Moderator |
| **admin@example.com** | `password` | Administrator |

## 📄 License
MIT
