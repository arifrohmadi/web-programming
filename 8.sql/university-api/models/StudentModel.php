<?php

class StudentModel {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM students ORDER BY student_id");
        return $stmt->fetchAll();
    }

    public function findById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO students (name, age, major) VALUES (:name, :age, :major)"
        );
        $stmt->execute([
            ':name'  => $data['name'],
            ':age'   => $data['age'],
            ':major' => $data['major'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): int {
        $stmt = $this->db->prepare(
            "UPDATE students SET name = :name, age = :age, major = :major WHERE student_id = :id"
        );
        $stmt->execute([
            ':name'  => $data['name'],
            ':age'   => $data['age'],
            ':major' => $data['major'],
            ':id'    => $id,
        ]);
        return $stmt->rowCount();
    }

    public function patch(int $id, array $data): int {
        $fields = [];
        $params = [':id' => $id];

        foreach (['name', 'age', 'major'] as $field) {
            if (isset($data[$field])) {
                $fields[] = "{$field} = :{$field}";
                $params[":{$field}"] = $data[$field];
            }
        }

        if (empty($fields)) return 0;

        $sql  = "UPDATE students SET " . implode(', ', $fields) . " WHERE student_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function delete(int $id): int {
        $stmt = $this->db->prepare("DELETE FROM students WHERE student_id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function findCoursesByStudent(int $id): array {
        $stmt = $this->db->prepare("
            SELECT c.course_id, c.course_name, c.credits, e.grade
            FROM enrollments e
            JOIN courses c ON e.course_id = c.course_id
            WHERE e.student_id = ?
            ORDER BY c.course_id
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
}
