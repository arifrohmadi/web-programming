<?php

class CourseModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM courses ORDER BY course_id");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE course_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO courses (course_name, credits) VALUES (:course_name, :credits)"
        );
        $stmt->execute([
            ':course_name' => $data['course_name'],
            ':credits'     => $data['credits'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): int {
        $stmt = $this->db->prepare(
            "UPDATE courses SET course_name = :course_name, credits = :credits WHERE course_id = :id"
        );
        $stmt->execute([
            ':course_name' => $data['course_name'],
            ':credits'     => $data['credits'],
            ':id'          => $id,
        ]);
        return $stmt->rowCount();
    }

    public function patch(int $id, array $data): int {
        $fields = [];
        $params = [':id' => $id];

        foreach (['course_name', 'credits'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }

        if (empty($fields)) return 0;

        $sql  = "UPDATE courses SET " . implode(', ', $fields) . " WHERE course_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete(int $id): int {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE course_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function findStudentsByCourse(int $id): array {
        $stmt = $this->db->prepare("
            SELECT s.student_id, s.name, s.major, e.grade
            FROM enrollments e
            JOIN students s ON e.student_id = s.student_id
            WHERE e.course_id = ?
            ORDER BY s.student_id
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
}
