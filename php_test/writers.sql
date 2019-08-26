-- defining tables
CREATE TABLE writers(
	writer_id INT,
	author VARCHAR(255)
);
CREATE TABLE books(
	book_id INT,
	book_name VARCHAR(255)
);
CREATE TABLE book_authors( --links writers and books table
	link_id INT,
	writer_id INT,
	book_id INT
);
--

-- load values
INSERT INTO writers (writer_id, author) VALUES
	(0, "Пехов"),
	(1, "Достоевский"),
	(2, "Лавкрафт"),
	(3, "Бычкова");
INSERT INTO books (book_id, book_name) VALUES
	(0, "Крадущийся в тени"),
	(1, "Джанга с тенями"),
	(2, "Вьюга теней"),
	(3, "Преступление и наказание"),
	(4, "Заклинатели"),
	(5, "Ловушка для духа"),
	(6, "Зов Ктулху"),
	(7, "Ужас Данвича")
	(8, "Ловцы удачи"),
	(9, "Особый почтовый)";
INSERT INTO book_authors (link_id, writer_id, book_id) VALUES
	(0, 0, 0),
	(1, 0, 1),
	(2, 0, 2),
	(3, 0, 4),
	(4, 3, 4),
	(5, 0, 5),
	(6, 3, 5)
	(7, 2, 6),
	(8, 2, 7),
	(9, 0, 8),
	(10, 0, 9);
--

--selecting authors, who has written no more than 6 books
SELECT author FROM writers WHERE writer_id IN(
	SELECT writer_id FROM book_authors GROUP BY writer_id HAVING COUNT(*) <= 6
);
--
