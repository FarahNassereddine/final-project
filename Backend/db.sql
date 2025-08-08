-- Ensure you are connected to the correct schema before running this script.

DROP DATABASE IF EXISTS `backend-blog_api`;
CREATE DATABASE `backend-blog_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `backend-blog_api`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  user_id INT,
  INDEX idx_user_id (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  post_id INT,
  user_id INT,
  INDEX idx_post_id (post_id),
  INDEX idx_user_id (user_id),
  FOREIGN KEY (post_id) REFERENCES posts(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);


SELECT * FROM users;
INSERT INTO users (name, email) VALUES
('Amira Nasser', 'amira.nasser@univmail.edu'),
('Rami Haddad', 'rami.haddad@univmail.edu'),
('Leila Abbas', 'leila.abbas@univmail.edu'),
('Tariq El-Masri', 'tariq.masri@univmail.edu'),
('Maya Shami', 'maya.shami@univmail.edu'),
('Ziad Khoury', 'ziad.khoury@univmail.edu'),
('Salma Karam', 'salma.karam@univmail.edu'),
('Fadi Mansour', 'fadi.mansour@univmail.edu'),
('Hiba Jaber', 'hiba.jaber@univmail.edu'),
('Nour Saab', 'nour.saab@univmail.edu');

SELECT* FROM posts;

INSERT INTO posts (title, content, user_id) VALUES 
('Intro to Computer Science', 'Let''s explore the basics of CS for first-year students.', 1),
('Electrical Engineering 101', 'Understanding circuits, voltage, and current.', 2),
('Psychology of Learning', 'How do we retain information effectively?', 3),
('Architecture Through History', 'From Roman arches to modern minimalism.', 4),
('Marketing Strategies That Work', 'Real-world tactics for brand growth.', 5),
('Organic Chemistry Crash Course', 'Reactions, molecules, and lab tips.', 1),
('Civil Engineering Challenges', 'Designing structures for resilience.', 2),
('Political Science Debates', 'Power, governance, and global issues.', 3),
('Mathematics in Nature', 'From Fibonacci to fractals.', 4),
('Medicine & Human Anatomy', 'Understanding the human body''s systems.', 5),
('Visual Arts and Expression', 'Exploring how colors and composition tell human stories.', 3),
('Data Science in Real Life', 'From recommendation systems to pandemic modeling.', 2),
('The Ethics of AI', 'Who''s responsible when algorithms go wrong?', 5),
('Environmental Science 101', 'Climate, ecosystems, and sustainability challenges.', 1),
('Linguistics and Language Evolution', 'How languages grow, shift, and merge across cultures.', 4);

SELECT * FROM comments;

INSERT INTO comments (content, post_id, user_id) VALUES 
('The CS intro helped me prep for my midterm.', 1, 6),
('This voltage breakdown made circuits much simpler.', 2, 7),
('Interesting take on memory formation.', 3, 8),
('Architecture timeline was very useful.', 4, 9),
('Marketing examples felt really fresh.', 5, 10),
('O-Chem mechanisms need more visuals please.', 6, 5),
('Civil design considerations were eye-opening.', 7, 4),
('Global politics explained in a clear way.', 8, 3),
('Fibonacci patterns blow my mind every time.', 9, 2),
('Loved the anatomy diagrams you mentioned.', 10, 1),
('Do you recommend a specific CS textbook?', 1, 3),
('We need a hands-on circuit lab post!', 2, 8),
('Marketing case study next, please?', 5, 6),
('This post made me rethink urban design.', 7, 9),
('Love how you linked anatomy to daily health.', 10, 2),
('CS professors should read this.', 1, 4),
('Could you explain recursion using flowcharts?', 1, 8),
('The Ohm’s Law part was spot-on.', 2, 9),
('Loved the psych studies reference!', 3, 5),
('Which building in Beirut shows modern architecture?', 4, 2),
('What’s the difference between marketing and branding?', 5, 6);
