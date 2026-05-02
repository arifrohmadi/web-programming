<?php

class CourseController {
    private CourseModel $model;

    public function __construct(CourseModel $model) {
        $this->model = $model;
    }

    public function index(): void {
        Response::success($this->model->findAll(), 'Courses retrieved successfully');
    }

    public function show(int $id): void {
        $course = $this->model->findById($id);
        if (!$course) Response::notFound("Course with ID {$id} not found");
        Response::success($course);
    }

    public function store(): void {
        $data = $this->getBody();
        $this->validateCourse($data, required: true);

        $newId  = $this->model->create($data);
        $course = $this->model->findById($newId);
        Response::created($course);
    }

    public function update(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Course with ID {$id} not found");

        $data = $this->getBody();
        $this->validateCourse($data, required: true);

        $this->model->update($id, $data);
        Response::success($this->model->findById($id), 'Course updated successfully');
    }

    public function patch(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Course with ID {$id} not found");

        $data = $this->getBody();
        if (empty($data)) Response::error('No fields provided to update');

        $this->validateCourse($data, required: false);
        $this->model->patch($id, $data);
        Response::success($this->model->findById($id), 'Course patched successfully');
    }

    public function destroy(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Course with ID {$id} not found");

        $this->model->delete($id);
        Response::success(null, "Course with ID {$id} deleted successfully");
    }

    public function students(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Course with ID {$id} not found");

        $students = $this->model->findStudentsByCourse($id);
        Response::success($students, "Students enrolled in course ID {$id}");
    }

    // ── helpers ────────────────────────────────────────────────────────────────

    private function getBody(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    private function validateCourse(array $data, bool $required): void {
        if ($required) {
            foreach (['course_name', 'credits'] as $field) {
                if (empty($data[$field])) {
                    Response::error("Field '{$field}' is required");
                }
            }
        }

        if (isset($data['credits']) && (!is_numeric($data['credits']) || $data['credits'] < 1)) {
            Response::error("Field 'credits' must be a positive number");
        }
    }
}
