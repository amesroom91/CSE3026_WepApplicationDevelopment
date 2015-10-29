//Problem 1
DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `student_id` 	int(10)		NOT NULL,
  `name` 		varchar(10)	NOT NULL,
  `year`		smallint(4)	NOT NULL	DEFAULT 1,
  `dept_no`		int(10)		NOT NULL,
  `major`		varchar(20),
  PRIMARY KEY (`student_id`)
);

DROP TABLE IF EXISTS `department`;

CREATE TABLE `department` (
  `dept_no`		  int(10) 	  NOT NULL	AUTO_INCREMENT,
  `dept_name` 	varchar(20)	NOT NULL	UNIQUE,
  `office`		  varchar(20)	NOT NULL,
  `office_tel`	varchar(13),
  PRIMARY KEY (`dept_no`)
);

ALTER TABLE student MODIFY major varchar(40);
ALTER TABLE student ADD gender int(10);
ALTER TABLE department MODIFY dept_name varchar(40);
ALTER TABLE department MODIFY office varchar(30);
ALTER TABLE DROP student gender;


//Problem 2
INSERT INTO student VALUES
(20070002, 'James Bond', 3, 4, 'Business Administration'),
(20060001, 'Queenie', 4, 4, 'Business Administration'),
(20030001, 'Reonardo', 4, 2, 'Electronic Engineering'),
(20040003, 'Julia', 3, 2, 'Electronic Engineering'),
(20060002, 'Roosevelt', 3, 1, 'Computer Science'),
(20100002, 'Fearne', 3, 4, 'Business Administration'),
(20110001, 'Chloe', 2, 1, 'Computer Science'),
(20080003, 'Amy', 4, 3, 'Law'),
(20040002, 'Selina', 4, 5, 'English Literature'),
(20070001, 'Ellen', 4, 4, 'Business Administration'),
(20100001, 'Kathy', 3, 4, 'Business Administration'),
(20110002, 'Lucy', 2, 2, 'Electronic Engineering'),
(20030002, 'Michelle', 5, 1, 'Computer Science'),
(20070003, 'April', 4, 3, 'Law'),
(20070005, 'Alicia', 2, 5, 'English Literature'),
(20100003, 'Yullia', 3, 1, 'Computer Science'),
(20070007, 'Ashlee', 2, 4, 'Business Administration');

INSERT INTO department (dept_name, office, office_tel) VALUES
('Computer Science', 'Engineering building', '02-3290-0123'),
('Electronic Engineering', 'Engineering building', '02-3290-2345'),
('Law', 'Law building', '02-3290-7896'),
( 'Business Administration', 'Administration building', '02-3290-1112'),
('English Literature', 'Literature building', '02-3290-4412');


//Problem 3
[1]
UPDATE department 
SET dept_name = 'Electronic and Electrical Engineering'
WHERE dept_name = 'Electronic engineering';

UPDATE student
SET major = 'Electronic and Electrical Engineering'
WHERE major = 'Electronic engineering';

[2]
INSERT INTO department (dept_name, office, office_tel)
VALUES ('Education', 'Education Building', '02-3290-2347');

[3]
UPDATE student
SET dept_no = 6, major="Education"
WHERE name="Chloe";

[4]
DELETE FROM student
WHERE name = "Michelle";

[5]
DELETE FROM student
WHERE name = "Fearne";


//Problem 4
[1]
SELECT name FROM student
WHERE major LIKE "Computer%";

[2]
SELECT student_id, year, major FROM student;

[3]
SELECT name FROM student
WHERE year > 3;

[4]
SELECT name FROM student
WHERE year = 1 or year = 2;

[5]
SELECT name 
FROM student s
JOIN department d ON s.dept_no = d.dept_no
WHERE dept_name = "Business Administration";

//Problem 5
[1]
SELECT student_id, name
FROM student
WHERE student_id LIKE "%2007%";

[2]
SELECT student_id, name
FROM student
ORDER BY student_id;

[3]
SELECT major, avg(year) avgYear
FROM student
GROUP BY major
HAVING avg(year) > 3;

[4]
SELECT student_id, name
FROM student
WHERE major = "Business Administration" and student_id LIKE "%2007%"
LIMIT 2;


//Problem 6
[1]
SELECT role 
FROM roles r
JOIN movies m ON r.movie_id = m.id
where m.name="PI";

[2]
SELECT first_name, last_name
FROM actors a
JOIN roles r ON a.id = r.actor_id 
JOIN movies m ON r.movie_id = m.id
WHERE m.name = 'PI';

[3]
SELECT first_name, last_name
FROM actors a 
JOIN roles r ON a.id = r.actor_id
JOIN movies m ON r.movie_id = m.id
WHERE m.name='Kill Bill: Vol. 2' and last_name in (
SELECT last_name
FROM actors a
JOIN roles r ON a.id = r.actor_id
JOIN movies m ON r.movie_id = m.id
WHERE m.name='Kill Bill: Vol. 1'
);

[4]
SELECT first_name, last_name
FROM actors a
JOIN roles r On a.id = r.actor_id
GROUP BY r.actor_id
ORDER BY count(actor_id) DESC
LIMIT 7;

[5]
SELECT genre
FROM movies_genres
GROUP BY genre
ORDER BY count(genre) DESC
LIMIT 3;

[6]
SELECT first_name, last_name
FROM movies_genres mg
JOIN movies_directors md ON mg.movie_id = md.movie_id
JOIN directors d ON d.id = md.director_id
WHERE mg.genre = 'THriller'
GROUP BY director_id
ORDER BY count(director_id) DESC
LIMIT 1;
 


//Problem 7
[1]
SELECT grade
FROM grades g
JOIN courses c ON c.id = g.course_id
WHERE c.name = "Computer Science 143";

[2]
SELECT s.name, grade
FROM grades g
JOIN courses c ON c.id = g.course_id
JOIN students s ON s.id = g.student_id
WHERE c.name = "Computer Science 143" and g.grade < "B-";

[3]
SELECT s.name, c.name, g.grade
FROM grades g
JOIN courses c ON c.id = g.course_id
JOIN students s ON s.id = g.student_id
WHERE g.grade <= 'B-';

[4]
SELECT c.name
FROM courses c
JOIN grades g ON c.id = g.course_id
JOIN students s on s.id = g.student_id
GROUP BY c.name
HAVING count(c.name) >= 2;

//EXTRA Problem
[1]
SELECT name
FROM movies
WHERE year = 1995;

[2]
SELECT count(*)
FROM movies m
JOIN roles r ON r.movie_id = m.id
WHERE name = "Lost in Translation";

[3]
SELECT a.first_name, a.last_name
FROM movies m
JOIN roles r ON r.movie_id = m.id
JOIN actors a ON a.id = r.actor_id
WHERE name='Lost in Translation';

[4]
SELECT d.first_name, d.last_name
FROM directors d
JOIN movies_directors md ON d.id = md.director_id
JOIN movies m ON m.id = md.movie_id
WHERE m.name='Fight Club';

[5]
SELECT count(*)
FROM directors d
JOIN movies_directors md ON d.id = md.director_id
JOIN movies m ON m.id = md.movie_id
WHERE d.first_name='Clint' and d.last_name='Eastwood';

[6]
SELECT d.first_name, d.last_name
FROM directors d
JOIN movies_directors md ON d.id = md.director_id
JOIN movies_genres mg ON mg.movie_id = md.movie_id
WHERE mg.genre = 'horror' 
GROUP BY md.director_id 
HAVING count(md.director_id) >= 1; 

[7]
SELECT DISTINCT a.first_name, a.last_name
FROM directors d
JOIN movies_directors md ON d.id = md.director_id
NATURAL JOIN roles r
JOIN actors a on a.id = r.actor_id
WHERE d.first_name='Christopher' and d.last_name='Nolan';
