# University REST API — PHP 8 Native

REST API sederhana untuk `universitydb` menggunakan PHP 8 native tanpa framework.

---

## Struktur Folder

```
university-api/
├── index.php               ← Entry point utama
├── .htaccess               ← URL rewriting (Apache)
├── config/
│   └── database.php        ← Konfigurasi koneksi PDO
├── middleware/
│   └── Response.php        ← Helper response JSON
├── routes/
│   └── Router.php          ← Simple pattern router
├── models/
│   ├── StudentModel.php
│   ├── CourseModel.php
│   └── EnrollmentModel.php
└── controllers/
    ├── StudentController.php
    ├── CourseController.php
    └── EnrollmentController.php
```

---

## Setup

1. Taruh folder `university-api/` di dalam `htdocs` (XAMPP) atau `www` (Laragon).
2. Import `universitydb.sql` ke MySQL.
3. Sesuaikan kredensial di `config/database.php`:
   ```php
   private string $host     = 'localhost';
   private string $db_name  = 'universitydb';
   private string $username = 'root';
   private string $password = '';
   ```
4. Akses via: `http://localhost/university-api/students`

---

## Endpoint

### Students

| Method | Endpoint                    | Keterangan                     |
|--------|-----------------------------|--------------------------------|
| GET    | /students                   | Ambil semua mahasiswa          |
| POST   | /students                   | Tambah mahasiswa baru          |
| GET    | /students/{id}              | Ambil mahasiswa by ID          |
| PUT    | /students/{id}              | Update penuh mahasiswa         |
| PATCH  | /students/{id}              | Update sebagian mahasiswa      |
| DELETE | /students/{id}              | Hapus mahasiswa                |
| GET    | /students/{id}/courses      | Lihat courses yang diambil     |

### Courses

| Method | Endpoint                    | Keterangan                     |
|--------|-----------------------------|--------------------------------|
| GET    | /courses                    | Ambil semua mata kuliah        |
| POST   | /courses                    | Tambah mata kuliah baru        |
| GET    | /courses/{id}               | Ambil mata kuliah by ID        |
| PUT    | /courses/{id}               | Update penuh mata kuliah       |
| PATCH  | /courses/{id}               | Update sebagian mata kuliah    |
| DELETE | /courses/{id}               | Hapus mata kuliah              |
| GET    | /courses/{id}/students      | Lihat mahasiswa yang enroll    |

### Enrollments

| Method | Endpoint                    | Keterangan                     |
|--------|-----------------------------|--------------------------------|
| GET    | /enrollments                | Ambil semua enrollment         |
| POST   | /enrollments                | Buat enrollment baru           |
| GET    | /enrollments/{id}           | Ambil enrollment by ID         |
| PUT    | /enrollments/{id}           | Update penuh enrollment        |
| PATCH  | /enrollments/{id}           | Update sebagian enrollment     |
| DELETE | /enrollments/{id}           | Hapus enrollment               |

---

## Contoh Request

### POST /students
```json
{
  "name": "Evan",
  "age": 20,
  "major": "Informatics"
}
```

### PUT /students/1
```json
{
  "name": "Alice Updated",
  "age": 21,
  "major": "Computer Science"
}
```

### PATCH /students/1
```json
{
  "age": 21
}
```

### POST /enrollments
```json
{
  "student_id": 1,
  "course_id": 103,
  "grade": "A"
}
```

---

## Format Response

### Success
```json
{
  "status": "success",
  "message": "Students retrieved successfully",
  "data": [ ... ]
}
```

### Error
```json
{
  "status": "error",
  "message": "Student with ID 99 not found",
  "data": null
}
```
