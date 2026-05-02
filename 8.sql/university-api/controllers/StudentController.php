<?php

class StudentController {
    private StudentModel $model;

    public function __construct(StudentModel $model) {
        $this->model = $model;
    }

    public function index(): void {
        $students = $this->model->findAll();
        Response::success($students, 'Students retrieved successfully');
    }

    public function show(int $id): void {
        $student = $this->model->findById($id);
        if (!$student) Response::notFound("Student with ID {$id} not found");
        Response::success($student);
    }

    public function store(): void {
        $data = $this->getBody();
        $this->validateStudent($data, required: true);

        $newId   = $this->model->create($data);
        $student = $this->model->findById($newId);
        Response::created($student);
    }

    public function update(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Student with ID {$id} not found");

        $data = $this->getBody();
        $this->validateStudent($data, required: true);

        $this->model->update($id, $data);
        Response::success($this->model->findById($id), 'Student updated successfully');
    }

    public function patch(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Student with ID {$id} not found");

        $data = $this->getBody();
        if (empty($data)) Response::error('No fields provided to update');

        $this->validateStudent($data, required: false);
        $this->model->patch($id, $data);
        Response::success($this->model->findById($id), 'Student patched successfully');
    }

    public function destroy(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Student with ID {$id} not found");

        $this->model->delete($id);
        Response::success(null, "Student with ID {$id} deleted successfully");
    }

    public function courses(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Student with ID {$id} not found");

        $courses = $this->model->findCoursesByStudent($id);
        Response::success($courses, "Courses for student ID {$id}");
    }

    // ── helpers ────────────────────────────────────────────────────────────────

    private function getBody(): array {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true) ?? [];
    }

    private function validateStudent(array $data, bool $required): void {
        if ($required) {
            foreach (['name', 'age', 'major'] as $field) {
                if (empty($data[$field])) {
                    Response::error("Field '{$field}' is required");
                }
            }
        }

        if (isset($data['age']) && (!is_numeric($data['age']) || $data['age'] < 1)) {
            Response::error("Field 'age' must be a positive number");
        }
    }
}
