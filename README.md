# 🚨 Edusafe - Backend

This is the **backend repository** for the Web Application: *Pelaporan Kekerasan Terhadap Wanita di Kampus*.  
Built using **Laravel**, the backend provides the API and business logic for managing reports, users, berita, and edukasi.

---

## 👥 Roles & Permissions

- **Mahasiswa**
  - 📝 Register and login  
  - 📢 Submit incident reports  
- **Kaprodi**
  - 📂 Process incident reports  
  - ✅ Registered by Admin only  
- **Admin**
  - 🔐 Manage system users  
  - ➕➖✏️ CRUD **Berita (News)**  
  - ➕➖✏️ CRUD **Edukasi (Educational Content)**  
  - ➕➖✏️ CRUD **Mahasiswa & Kaprodi**  
- **User (Guest)**
  - 📖 Read **Berita & Edukasi** only  

---

## 🛠️ Tech Stack

- [Laravel](https://laravel.com/) – PHP framework  
- [MySQL](https://www.mysql.com/) – Database  
- [Migrations & Seeders](https://laravel.com/docs/migrations) – Database structure  

---

## 🚀 Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/Keshinryan/Edusafe-BackEnd.git
cd Edusafe-Backend
```

2. Install dependencies:

```bash
composer install
```

3. Copy `.env` file and configure:

```bash
cp .env.example .env
```

4. Generate app key:

```bash
php artisan key:generate
```

5. Setup database in `.env`, then run migrations:

```bash
php artisan migrate --seed
```

6. Run development server:

```bash
php artisan serve
```

The backend will run at:  
👉 `http://localhost:8000`

---

## 📂 Project Structure

```
pelaporan-backend/
│── app/
│   ├── Http/Controllers/    # Controllers for Auth, Reports, Berita, Edukasi
│   ├── Models/              # Eloquent models (Mahasiswa, Kaprodi, Admin, Report)
│── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Default seed data
│── routes/
│   ├── api.php              # API routes
│   └── web.php              # Web routes
│── .env                     # Environment variables
│── composer.json            # Dependencies
│── README.md
```

---

## 🔑 API Endpoints (Examples)

### Auth
- `POST /api/register` – Mahasiswa registration  
- `POST /api/login` – Login  

### Reports
- `POST /api/pelaporan` – Submit report (Mahasiswa)  
- `GET /api/pelaporan` – View reports (Kaprodi/Admin)  
- `PUT /api/pelaporan/{id}` – Process/update report (Kaprodi)  

### Berita & Edukasi
- `GET /api/berita` – View berita  
- `POST /api/berita` – Create berita (Admin)  
- `PUT /api/berita/{id}` – Update berita (Admin)  
- `DELETE /api/berita/{id}` – Delete berita (Admin)  

- `GET /api/edukasi` – View edukasi  
- `POST /api/edukasi` – Create edukasi (Admin)  
- `PUT /api/edukasi/{id}` – Update edukasi (Admin)  
- `DELETE /api/edukasi/{id}` – Delete edukasi (Admin)  


## 🔗 Frontend

This project connects to the frontend built with **Vue.js**:  
👉 [Edusafe Frontend](https://github.com/Keshinryan/Edusafe-Frontend)

---

## 👨‍💻 Author

Developed for **Edusafe** by Jason Patrick  
Frontend: Vue.js | Backend: Laravel

