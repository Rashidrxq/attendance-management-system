
# 📅 Attendance Management System

A simple web-based application to **mark and view attendance** for users (students, employees, etc.). Built with HTML, CSS, JavaScript, PHP, and SQLite, this system supports user authentication, attendance marking, and viewing history — with an optional admin dashboard.

---

## 🚀 Features

- 🔐 **User Authentication**
  - Secure registration and login system.
  - Passwords hashed using `bcrypt` or a secure method.
- ✅ **Attendance Tracking**
  - Users can mark attendance (e.g., "Present").
  - View daily attendance history.
- 📊 **Admin Panel (Optional)**
  - View attendance of all users.
---

## 🛠️ Tech Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: SQLite (or JSON-based storage)
- **Hosting**: Firebase / Vercel / XAMPP (for local testing)

---

## 📂 Project Structure

```plaintext
/atm
│
├── index.html               # Homepage/Login
├── register.html            # Registration Page
├── student.html             # Student Dashboard
├── teacher.html             # Admin Dashboard (optional)
├── style.css                # Stylesheet
├── script.js                # Frontend logic
│
├── /backend
│   ├── /api
│   │   ├── login.php        # Login API
│   │   ├── register.php     # Registration API
│   │   ├── attendance.php   # Attendance API (POST/GET)
│   │   └── ...              # Additional endpoints if needed
│   └── /db
│       └── db.php           # SQLite DB connection
│
└── /data (if using JSON)    # JSON-based data storage (optional)
```

---

## 📌 API Endpoints

| Method | Endpoint             | Description                          |
|--------|----------------------|--------------------------------------|
| POST   | `/login`             | Authenticates user                   |
| POST   | `/attendance`        | Marks today's attendance             |
| GET    | `/attendance`        | Fetches logged-in user's attendance  |
| GET    | `/attendance/{id}`   | Fetches specific user's attendance   |

---

## 🧱 Database Schema

### `users` Table
| Field      | Type     |
|------------|----------|
| id         | INTEGER  |
| username   | TEXT     |
| password   | TEXT     |

### `attendance` Table
| Field      | Type     |
|------------|----------|
| id         | INTEGER  |
| user_id    | INTEGER  |
| date       | TEXT     |
| status     | TEXT     |

---

## 🔧 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/attendance-system.git
cd attendance-system
```

### 2. Set Up PHP Server
- Use **XAMPP** or any PHP server.
- Place the project inside `htdocs` (for XAMPP).
- Enable SQLite3 in `php.ini` (uncomment: `extension=sqlite3`).

### 3. Start the Server
Visit `http://localhost/atm/index.html` in your browser.


##4. Registration
type the details in form and submit 

#### 4. login users 
role student 
userId = st1
password= 456
etc...


---

## 🌐 Hosting Instructions

You must host your project on **Firebase**, **Vercel**, or a similar platform. Follow these steps:

1. Host frontend (HTML/CSS/JS) on Firebase/Vercel.
2. Host backend PHP APIs using a platform like **000webhost**, **InfinityFree**, or any custom domain with PHP hosting.
3. Link the frontend to backend API URLs.

> ⚠️ Note: Submissions without a hosted link will be disqualified.

---

## 📄 Submission Requirements

- ✅ GitHub Repository Link (with code and README)
- ✅ Hosted Project Link
- ✅ Basic Documentation (README + DB structure + usage guide)

---

## 📧 Contact

If you need help, feel free to reach out.
