<?php
declare(strict_types=1);

// ── Autoload ──────────────────────────────────────────────────────────────────
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/middleware/Response.php';
require_once __DIR__ . '/routes/Router.php';
require_once __DIR__ . '/models/StudentModel.php';
require_once __DIR__ . '/models/CourseModel.php';
require_once __DIR__ . '/models/EnrollmentModel.php';
require_once __DIR__ . '/controllers/StudentController.php';
require_once __DIR__ . '/controllers/CourseController.php';
require_once __DIR__ . '/controllers/EnrollmentController.php';

// ── Headers ───────────────────────────────────────────────────────────────────
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ── Bootstrap ─────────────────────────────────────────────────────────────────
$db         = (new Database())->connect();
$router     = new Router();

$students   = new StudentController(new StudentModel($db));
$courses    = new CourseController(new CourseModel($db));
$enrollments = new EnrollmentController(new EnrollmentModel($db));

// ── Routes: Students ──────────────────────────────────────────────────────────
$router->add('GET',    '/students',                fn()     => $students->index());
$router->add('POST',   '/students',                fn()     => $students->store());
$router->add('GET',    '/students/{id}',           fn($id)  => $students->show($id));
$router->add('PUT',    '/students/{id}',           fn($id)  => $students->update($id));
$router->add('PATCH',  '/students/{id}',           fn($id)  => $students->patch($id));
$router->add('DELETE', '/students/{id}',           fn($id)  => $students->destroy($id));
$router->add('GET',    '/students/{id}/courses',   fn($id)  => $students->courses($id));

// ── Routes: Courses ───────────────────────────────────────────────────────────
$router->add('GET',    '/courses',                 fn()     => $courses->index());
$router->add('POST',   '/courses',                 fn()     => $courses->store());
$router->add('GET',    '/courses/{id}',            fn($id)  => $courses->show($id));
$router->add('PUT',    '/courses/{id}',            fn($id)  => $courses->update($id));
$router->add('PATCH',  '/courses/{id}',            fn($id)  => $courses->patch($id));
$router->add('DELETE', '/courses/{id}',            fn($id)  => $courses->destroy($id));
$router->add('GET',    '/courses/{id}/students',   fn($id)  => $courses->students($id));

// ── Routes: Enrollments ───────────────────────────────────────────────────────
$router->add('GET',    '/enrollments',             fn()     => $enrollments->index());
$router->add('POST',   '/enrollments',             fn()     => $enrollments->store());
$router->add('GET',    '/enrollments/{id}',        fn($id)  => $enrollments->show($id));
$router->add('PUT',    '/enrollments/{id}',        fn($id)  => $enrollments->update($id));
$router->add('PATCH',  '/enrollments/{id}',        fn($id)  => $enrollments->patch($id));
$router->add('DELETE', '/enrollments/{id}',        fn($id)  => $enrollments->destroy($id));

// ── Dispatch ──────────────────────────────────────────────────────────────────
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');

if ($basePath !== '' && $basePath !== '/' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

$uri = $uri === '' ? '/' : $uri;
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);
