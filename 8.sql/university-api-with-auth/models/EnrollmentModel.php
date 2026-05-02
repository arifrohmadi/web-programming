<?php

class EnrollmentModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $stmt = $this->db->query("
            SELECT e.enrollment_id, s.name AS student_name, c.course_name, e.grade
            FROM enrollments e
            JOIN students s ON e.student_id = s.student_id
            JOIN courses  c ON e.course_id  = c.course_id
            ORDER BY e.enrollment_id
        ");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("
            SELECT e.enrollment_id, e.student_id, s.name AS student_name,
                   e.course_id, c.course_name, e.grade
            FROM enrollments e
            JOIN students s ON e.student_id = s.student_id
            JOIN courses  c ON e.course_id  = c.course_id
            WHERE e.enrollment_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO enrollments (student_id, course_id, grade) VALUES (:student_id, :course_id, :grade)"
        );
        $stmt->execute([
            ':student_id' => $data['student_id'],
            ':course_id'  => $data['course_id'],
            ':grade'      => $data['grade'] ?? null,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): int {
        $stmt = $this->db->prepare(
            "UPDATE enrollments SET student_id = :student_id, course_id = :course_id, grade = :grade
             WHERE enrollment_id = :id"
        );
        $stmt->execute([
            ':student_id' => $data['student_id'],
            ':course_id'  => $data['course_id'],
            ':grade'      => $data['grade'] ?? null,
            ':id'         => $id,
        ]);
        return $stmt->rowCount();
    }

    public function patch(int $id, array $data): int {
        $fields = [];
        $params = [':id' => $id];

        foreach (['student_id', 'course_id', 'grade'] as $field) {
            if (array_key_exists($field, $data)) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }

        if (empty($fields)) return 0;

        $sql  = "UPDATE enrollments SET " . implode(', ', $fields) . " WHERE enrollment_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete(int $id): int {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE enrollment_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
