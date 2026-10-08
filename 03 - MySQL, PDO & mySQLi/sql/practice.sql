-- Read-only queries. Run after schema.sql in php_interview_lab.
SELECT id, name, city FROM students ORDER BY id;
SELECT COUNT(*) AS all_students, COUNT(city) AS known_cities FROM students;
-- Expected: all_students=3, known_cities=2 on a fresh seed.

SELECT city, COUNT(*) AS total
FROM students
WHERE city IS NOT NULL
GROUP BY city
HAVING COUNT(*) >= 1
ORDER BY city;

SELECT s.name, c.title
FROM students AS s
INNER JOIN enrollments AS e ON e.student_id = s.id
INNER JOIN courses AS c ON c.id = e.course_id;
-- Expected: Asha | SQL Basics.

SELECT s.name
FROM students AS s
LEFT JOIN enrollments AS e ON e.student_id = s.id
WHERE e.student_id IS NULL
ORDER BY s.id;
-- Expected: Kabir, Meera.

SELECT s.name
FROM students AS s
WHERE NOT EXISTS (SELECT 1 FROM enrollments AS e WHERE e.student_id = s.id)
ORDER BY s.id;
-- Same anti-join result without duplicating parent rows.

EXPLAIN SELECT id, name FROM students WHERE city = 'Delhi';
-- A tiny seed can legitimately cause a table scan: an index is not always cheaper.

SELECT name FROM students WHERE name LIKE '%a%' ORDER BY id;
-- Matching case depends on the column collation, not on parameter binding.
