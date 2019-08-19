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
INSERT INTO writers ("writer_id", "author") VALUES(0, "Пехов");
--

--selecting authors, who has written no more than 6 books
SELECT author FROM writers WHERE writer_id IN(
	SELECT writer_id FROM book_authors GROUP BY writer_id HAVING COUNT(*) <= 6
);
--
