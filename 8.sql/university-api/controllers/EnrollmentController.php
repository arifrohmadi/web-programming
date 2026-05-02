<?php

class EnrollmentController {
    private EnrollmentModel $model;

    public function __construct(EnrollmentModel $model) {
        $this->model = $model;
    }

    public function index(): void {
        Response::success($this->model->findAll(), 'Enrollments retrieved successfully');
    }

    public function show(int $id): void {
        $enrollment = $this->model->findById($id);
        if (!$enrollment) Response::notFound("Enrollment with ID {$id} not found");
        Response::success($enrollment);
    }

    public function store(): void {
        $data = $this->getBody();
        $this->validate($data, required: true);

        $newId      = $this->model->create($data);
        $enrollment = $this->model->findById($newId);
        Response::created($enrollment);
    }

    public function update(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Enrollment with ID {$id} not found");

        $data = $this->getBody();
        $this->validate($data, required: true);

        $this->model->update($id, $data);
        Response::success($this->model->findById($id), 'Enrollment updated successfully');
    }

    public function patch(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Enrollment with ID {$id} not found");

        $data = $this->getBody();
        if (empty($data)) Response::error('No fields provided to update');

        $this->validate($data, required: false);
        $this->model->patch($id, $data);
        Response::success($this->model->findById($id), 'Enrollment patched successfully');
    }

    public function destroy(int $id): void {
        if (!$this->model->findById($id)) Response::notFound("Enrollment with ID {$id} not found");

        $this->model->delete($id);
        Response::success(null, "Enrollment with ID {$id} deleted successfully");
    }

    // ── helpers ────────────────────────────────────────────────────────────────

    private function getBody(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    private function validate(array $data, bool $required): void {
        if ($required) {
            foreach (['student_id', 'course_id'] as $field) {
                if (empty($data[$field])) {
                    Response::error("Field '{$field}' is required");
                }
            }
        }

        $validGrades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'E', 'F'];
        if (isset($data['grade']) && !in_array(strtoupper($data['grade']), $validGrades, true)) {
            Response::error("Invalid grade value. Allowed: " . implode(', ', $validGrades));
        }
    }
}
