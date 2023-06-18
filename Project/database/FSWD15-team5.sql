-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2022 at 10:44 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fswd15-team5`
--
CREATE DATABASE IF NOT EXISTS `fswd15-team5` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fswd15-team5`;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `fk_mentee_id` int(11) NOT NULL,
  `fk_mentor_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `fk_mentee_id`, `fk_mentor_id`, `status`, `date`) VALUES
(1, 2, 2, 0, '2022-04-13 14:57:21'),
(2, 3, 2, 0, '2022-04-13 15:11:31'),
(3, 3, 1, 0, '2022-04-16 23:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `mentees`
--

CREATE TABLE `mentees` (
  `id` int(10) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentees`
--

INSERT INTO `mentees` (`id`, `fk_user_id`, `fk_mentor_id`) VALUES
(1, 2, 1),
(2, 3, 1),
(3, 4, NULL),
(4, 14, NULL),
(5, 18, NULL),
(6, 20, NULL),
(7, 22, NULL),
(8, 27, NULL),
(9, 29, NULL),
(10, 30, NULL),
(11, 33, NULL),
(12, 35, NULL),
(13, 36, NULL),
(14, 37, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

CREATE TABLE `mentors` (
  `id` int(10) NOT NULL,
  `fk_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentors`
--

INSERT INTO `mentors` (`id`, `fk_user_id`) VALUES
(1, 1),
(2, 5),
(3, 15),
(4, 16),
(5, 17),
(6, 19),
(7, 21),
(8, 23),
(9, 24),
(10, 25),
(11, 26),
(12, 28),
(13, 31),
(14, 32),
(15, 34),
(16, 38);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(14, 'Accounting'),
(65, 'Acting'),
(29, 'Analytics'),
(8, 'Betting'),
(21, 'Branding'),
(61, 'C#'),
(62, 'C++'),
(57, 'CEO Coaching'),
(13, 'Communication'),
(12, 'Creativity'),
(6, 'Crypto'),
(5, 'CSS'),
(33, 'Cyber Security'),
(1, 'Data Science'),
(55, 'Deep Learning'),
(18, 'Diagrams'),
(32, 'Firewalls'),
(4, 'HTML'),
(64, 'Interview'),
(9, 'IT'),
(2, 'JavaScript'),
(28, 'Linux'),
(20, 'Machine Learning'),
(16, 'Management'),
(7, 'Marketing'),
(59, 'Math'),
(11, 'Music'),
(15, 'Negotiation'),
(31, 'Networking'),
(3, 'PHP'),
(60, 'Physics'),
(10, 'Piano'),
(58, 'Portfolio'),
(19, 'Python'),
(17, 'Resilience'),
(66, 'Resume'),
(25, 'Sales'),
(27, 'Software Development'),
(30, 'Software Engineering'),
(67, 'Startup'),
(63, 'Strategy'),
(26, 'User Interface'),
(22, 'UX Design'),
(56, 'Web Design'),
(24, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_platforms`
--

CREATE TABLE `social_media_platforms` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social_media_platforms`
--

INSERT INTO `social_media_platforms` (`id`, `name`, `website`) VALUES
(1, 'twitter', 'https://www.twitter.com/'),
(2, 'facebook', 'https:/www.facebook.com/'),
(3, 'linkedIn', 'https://www.linkedin.com/'),
(4, 'instagram', 'https://www.instagram.com/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `about` varchar(2048) DEFAULT NULL,
  `role` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `location`, `password`, `picture`, `website`, `occupation`, `about`, `role`) VALUES
(1, 'richurley@ecallen.com', 'Douglas', 'Conner', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'first.jpg', 'https://connerduuglas.com', 'Head of IT at IBM', 'I am a Data Scientist with 7+ years of rich industry experience currently working in Google on the Google Maps team. Me and my team works on building counter abusive models to keep the Geo surface free from abuse. I completed my Masters from UIUC in CS with a specialisation in Data Science and Machine Learning.  I can help you with learning and executing data science projects, build a career in data science, build data products, create ETL pipelines, build dashboards, interpret, deploy, maintain ML models in production. In addition to my monthly mentorship, i also offer one-off sessions for 1:1 calls, interview preparation, resume feedback. Feel free to reach out and we can chat about how we can work together to help you achieve you career goals.', 'user'),
(2, 'liweiwei111@cggup.com', 'Christopher', 'Rockwell', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62610d8dab15c.jpg', '', '', 'I am a software developer with a passion to build products. At the moment, Apart from my full-time job I spend most of the time building an org. for providing opportunities to scholars product is listed here. Moreover, I also love to contribute to open-source software, my contributions & works are well reflected on GitHub.  I am willing to mentor in client/server-side technologies especially React & Node and all the libraries that couple with them. I can also assist with the development of APIs especially in Django & database designing in relational/Non-relational DBs. Moreover, if you need any guidance & Mentorship in terms of contributing to open-source software please reach me :)', 'user'),
(3, 'axel4242@silnmy.com', 'Niklas', 'Mayer', 'Germany', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62610e352d86d.jpg', '', '', 'Being a software engineer became a super power in my life after I realized that I wasnt dependent on anyone else to make my ideas a reality. Its hard to think of anything more invigorating!  I came down with a bug for programming at a young age, and it has been one of my passions ever since. My early years of learning have been complemented by years of working in early stage startups, resulting in concrete expertise that I love sharing with others.', 'user'),
(4, 'tom@joe.com', 'Maria', 'Edison', 'United Kingdom', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62610ed5ccf92.jpg', '', '', 'Hi! Thank you for visiting my mentorship service page. I’m excited to work with you and help you navigate the data science field. Please feel free to reach out to chat about how we can best work together to achieve your goals! In addition to my monthly mentorship, I also offer one-off sessions for 1x1 calls, interview preparation, or resume + cover letter feedback.', 'user'),
(5, 'jesus@jesus.com', 'Tina', 'Zimmer', 'Austria', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261101e0a15d.jpg', '', '', 'Senior technical leader with 20+ years of experience ranging from software development, software architect, product management, interviewing to technical program management. Whether you are looking forward to significantly increase your chances when interviewing for big companies (FAANG) or receiving mentoring to give direction and boost your career, I am here for you.', 'user'),
(6, 'abc@abc.com', 'Peter', 'Klein', 'Russia', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62611089d147e.jpg', '', '', 'Hi!  I am Andrew, Senior Software Engineer in Amazon Web Services (AWS). I have more than 10 years of experience building complex large-scale distributed web applications as well as an experience leading the team of engineers.', 'user'),
(7, 'aaabc@aaa.com', 'Michael', 'Kogler', 'Austria', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261113638139.jpg', '', '', '', 'user'),
(8, 'test@bcd.de', 'Jason', 'Meere', 'France', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62611184173cb.jpg', '', '', 'Hello, I am Aaditya, a research scholar from India. My research work is centered around autonomous vehicles and I am here to mentor anyone with whatever I can. The main moto for me being here is to learn by teaching and sharing.', 'user'),
(9, 'jan@jan.com', 'Will', 'Slapus', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261126d8cb77.jpg', '', '', 'I am currently a Machine Learning (ML) Engineer at Duality Technologies, where I work on encrypted ML through Homomorphic Encryption (HE).  Roles I have held in the past include CTO, Sr. ML Engineer, and Applied ML Scientist.  My research interests are Deep RL, encrypted ML, and privacy-preserving machine learning.  In my spare time, I use (and research) Deep Reinforcement Learning to trade digital assets, and I advise junior ML Engineers and Data Scientists.  Whatever time is left I spend bouldering, or aspiring to become a professional chef.', 'user'),
(10, 'jan@tan.com', 'Nina', 'Berry', 'Switzerland', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '62611373b4037.jpg', '', '', 'As a Product Leader and Senior Product Manager with a MBA, I have worked in both big corporates and start ups. I am passionate about solving the most valuable customer problems through products and delivering the best possible user experience.', 'user'),
(11, 'kate@xray.com', 'Kate', 'Nutisd', 'Austria', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261143c6cc7f.jpg', 'https://mastersindatascience.com/', 'Senior Data Scientist', 'Kate is a Data Science for Social Good fellow and has over six years of experience solving problems using data in the public service. Combining her passion for education, data, and tech, she was a recipient of the KDD Impact Program award for bringing data science into a high school curriculum. She is also the #VizforSocialGood local chapter leader for Singapore and runs a data science blog called Data Double Confirm that was recognised as 2018 Top 100 Data Science Resources on MastersInDataScience.com. She was previously an instructor with General Assembly and is based in Singapore.', 'user'),
(12, 'jan@tln.cd', 'Jan', 'Sog', 'Spain', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626114857b118.jpg', '', '', '', 'user'),
(13, 'email@email.at', 'Jushua', 'Mercer', 'Ireland', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626114c6d9590.jpg', '', '', 'Trying to be my best self ever single day! :)', 'user'),
(14, 'email@emaia.at', 'Stephanie', 'Nate', 'South Korea', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626114ff7ee81.jpg', '', '', '', 'user'),
(15, 'email@orf.at', 'Zao', 'Naho', 'Japan', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261153447e6a.jpg', '', '', 'Hello all! :D  I am currently VP of research in the Oncology group at Lunit, Seoul, where I lead the AI research team in the same department. I can provide mentorship in Artificial Intelligence, Computer Vision and Medical Image Analysis, scientific programming in Python, AI research in Academia and Industry, from the hands-on and leadership perspective.  I have a background in Biomedical Engineering and PhD in Computer Science, both obtained at the University of Minho, Portugal. My research was at the intersection of medical imaging and AI, and resulted in several impactful publications, with a total number of +5500 citations.', 'user'),
(16, 'late@night.com', 'Thomas', 'Night', 'Canada', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626115550a4d0.jpg', '', 'Head of Security at MonkeyApps', 'I am a versatile Program Manager with a proven track record of building and leading large scale Agile/Digital Transformations. Strong technology risk leader skilled in risk assessment, governance and mitigation strategies. Skilled at developing and supporting controls and policies as well as strategic programs targeted to technology risk reduction.', 'user'),
(17, 'ariel@ariel.com', 'Ariel', 'Helwani', 'Israel', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261159198c09.jpg', '', '', 'About me: I’m Alla, co-founder and CPTO of Munich-based startup RepairFix. Over 12 years in technology I gathered experience in launching products at the different stages, and building and leading product and engineering teams. I would love to help you solve challenges related to the product, startup, or team leadership. I value fast results, a growth mindset, and never-ending curiosity.', 'user'),
(18, 'ariel@ariel.de', 'Annette', 'Weiß', 'Germany', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626115d69afe9.jpg', '', '', '', 'user'),
(19, 'ariel@ariel.at', 'Jennifer', 'Tenos', 'Greece', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626116c71196f.jpg', '', '', 'Jennifer Tenos is the CEO and founder of the award-winning ROYBI® Robot – the world’s first AI-powered smart toy to teach children language and STEM skills. It also has been named one of TIME Magazine’s Best Inventions in Education, on the 2019 CNBC Upstart 100 list as one of the world’s most promising startups, and on Fast Company’s 2019 World-Changing Ideas. Jennifer is also a Board Member at the Consumer Technology Association, Small Business Council, and member of Forbes Technology Council.', 'user'),
(20, 'son@monkey.com', 'Nethan', 'son', 'Finnland', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626116e872da1.jpg', '', '', '', 'user'),
(21, 'son@door.com', 'Samantha', 'son', 'Sweden', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261174278eb3.jpg', '', '', 'If you are interested in switching career or growing in the product area - I&#039;d love to help!  As a marketing technology leader with over 7 years of experience, I have switched from being a strategy consultant, to an innovation manager, to a product owner. I can help you find your path, achieve your professional goals and reach the next step of your career.', 'user'),
(22, 'face@book.com', 'Mustafa', 'Ükzum', 'Turkey', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261177007ceb.jpg', '', '', '', 'user'),
(23, 'cf@sks.com', 'Charlie', 'Brown', 'Sweden', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626117d99e61f.jpg', '', '', 'When I started my career I had lots of questions, sometimes I was confused which direction to take, which skills to pick up. After a while I found someone who gave me direction and goals, who saw the future of my career and helped me reach my goals faster by taking the right path.  Now, I am here to be that person for many other engineers who needs it. This is a paid program, which means you and I will need to put the effort and make your dreams come true. I did lots of volunteering. mentorship, but mostly my mentees are not that serious since they get it for free. Here I deal with engineers who really want to change and revolutionize their career path.', 'user'),
(24, 'cf@sks.coma', 'Ronaldo', 'Nagos', 'Brazil', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '6261184b9d81f.jpg', '', 'Senior Data Scientist at Google', 'Data Scientist with 10+ years of experience scaling data at top tier Silicon Valley companies. I’ve led projects spanning from Machine Learning, Data Engineering, to A/B Testing and Data Visualization. My professional experience has equipped me with an understanding of a) How to leverage data for different functions and projects b) Different types of Data Science challenges c) What makes a great data scientist.', 'user'),
(25, 'cf@sks.comaa', 'Richard', 'Baumann', 'Switzerland', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626118b14bb1c.jpg', '', '', 'I am a security professional with experience in audit, compliance, and sales engineering/solutions architecture. I currently work at Google Cloud as a Customer/Sales Engineer focused on Security &amp; Compliance, where I help organizations understand and achieve cloud security. Previously, I worked at Amazon Web Services and JPMorgan Chase &amp; Co. focused on audit and compliance with ISO 27001 and HITRUST being my primary frameworks of expertise.', 'user'),
(26, 'cf@sks.comaas', 'Siri', 'Fruit', 'Peru', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626119105c19a.jpg', '', '', 'I am currently a Software Engineer at UDig. I received my degree in Computer Science from JMU in May 2019. My study of finance, combined with a membership in the Madison Investment Fund, was instrumental in developing my business and problem-solving skills. These strengths helped me land a position as a Cybersecurity Analyst at Booz Allen Hamilton. I have participated in many types of projects across different industries, from Finance to Computer Science as well as Blockchain. Altogether, I feel that because I have such a unique skill set, I can help people that don’t necessarily know where to start their planning or aren’t sure what languages/platforms to use.', 'user'),
(27, 'test@google.com', 'Istvan', 'Sziget', 'Hungary', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '626119371d14f.jpg', '', '', '', 'user'),
(28, 'gigachad@gmail.com', 'Giga', 'Chad', 'Russia', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ec704b18f4.jpg', 'chadders.com', 'Photo model for all your favorite brands', 'I was the first person on the moon. I was the first person on mars. A living meme. A living legend. I am what you always wanted to be. Human perfection taken form. And I am here on mentor tree to help you achieve your dreams, to become the first in your c', 'user'),
(29, 'netti.m@gmail.com', 'Nettie', 'Markham', 'England', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ec84c8bd9d.jpg', '', 'Employee at Walmart', 'I want to fulfill my dreams of becoming a software developer and I&#039;m hoping that I can find the perfect mentor to help me with that here on mentor tree. Other than that i usually just love playing video games and talking about them.', 'user'),
(30, 'ittybitty@spider.com', 'Peter', 'Parker', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ec96357f5d.jpg', '', 'Photographer at The Daily Bugle', 'I&#039;m a freelance photographer at The Daily Bugle, but my true passion in life is science and helping other people! I want to become a physicist and work on ways to help people with disabilities improve their life. With science!', 'user'),
(31, 'ade.fer@adefer.com', 'Adelaide', 'Ferreira', 'Germany', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ecbaae9b27.jpg', 'www.adefer.com', 'CEO at Adefer Inc', 'I used to stack shelves at Walmart for 20 cents an hour and after saving up money for 200 years i was finally able to found my company which focuses on supplying the every day person with dark artifacts that will enable you to have a longer, if not infini', 'user'),
(32, 'senator@muscles.com', 'Steven', 'Armstrong', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ecca53a798.png', 'thesenator.com', 'Senator of the United States of America', 'Steven Armstrong was a United States Senator representing the U.S. state of Colorado, as well as a candidate for the 2020 United States presidential election. He was also the benefactor for World Marshal Inc., its de facto CEO, and its most powerful warri', 'user'),
(33, 'Rennie@ruben.com', 'Ruben', 'Rennie', 'Austria', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ecd2c5b3b9.jpg', '', '', 'Follow your inner moonlight; don’t hide the madness. To be yourself in a world that is constantly trying to make you something else is the greatest accomplishment. Always be yourself. At the end of the day, that’s all you’ve really got; when you strip eve', 'user'),
(34, 'c.arias@gmx.at', 'Cody', 'Arias', 'Austria', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ecdb3a795e.jpg', 'arias.com', 'Manager at Central Consulting', 'I am a veteran who became a web developer after my military service. A few years later, I got into business analysis and project management. Eventually, I found my niche and became an Agilist. I call myself an Agilist because I don&#039;t limit myself to ', 'user'),
(35, 'darcie@gmail.com', 'Darcie', 'Walter', 'Wales', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ece960c2cb.jpg', '', '', 'Just here to learn.', 'user'),
(36, 'phillyd@efranco.com', 'Philip', 'DeFranco', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ed2fcb7a93.jpg', 'https://beautifulbastard.com/', 'Content Creator', 'Philip James DeFranco (born Philip James Franchini Jr. born December 1, 1985), commonly known by his online nickname PhillyD, is an American news commentator and YouTube personality. He is best known for The Philip DeFranco Show, a news commentary show ce', 'user'),
(37, 'webb.r@gmail.com', 'Rory', 'Webb', 'France', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ed48edd659.jpg', '', 'Dreamer at the Government', 'I&#039;m a life long learner!', 'user'),
(38, 'sinsjonny@mail.com', 'Jonny', 'Sins', 'USA', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '625ed5f793c9d.jpg', 'jonnysins.com', 'The most talented person', 'I&#039;m an engineer, a doctor, a dentist, karate master, school teacher, pizza delivery guy, plumber, astronaut, etc... You name it, i&#039;ve done it. People have called me the most talented person on the planet, but really I  just like learning all typ', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(10) NOT NULL,
  `fk_mentee_id` int(11) NOT NULL,
  `fk_mentor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_reviews`
--

INSERT INTO `user_reviews` (`id`, `fk_mentee_id`, `fk_mentor_id`, `date`, `subject`, `details`, `rating`) VALUES
(1, 1, 1, '2022-04-13', 'Great experience!', 'dummy text', 5),
(2, 2, 1, '2022-04-14', 'I wish he had more patience.', 'dummy text', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE `user_skills` (
  `fk_skill_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`fk_skill_id`, `fk_user_id`) VALUES
(9, 1),
(2, 1),
(28, 1),
(20, 1),
(11, 1),
(3, 1),
(60, 1),
(58, 1),
(25, 1),
(27, 1),
(56, 1),
(1, 2),
(2, 2),
(3, 2),
(32, 3),
(3, 3),
(19, 3),
(65, 5),
(29, 5),
(1, 5),
(11, 5),
(27, 5),
(56, 5),
(24, 5),
(61, 8),
(62, 8),
(5, 8),
(4, 8),
(2, 8),
(3, 8),
(19, 8),
(5, 9),
(1, 9),
(55, 9),
(4, 9),
(2, 9),
(20, 9),
(3, 9),
(19, 9),
(27, 9),
(14, 10),
(21, 10),
(57, 10),
(13, 10),
(16, 10),
(7, 10),
(27, 10),
(30, 10),
(33, 11),
(1, 11),
(2, 11),
(20, 11),
(16, 11),
(19, 11),
(67, 11),
(65, 15),
(8, 15),
(21, 15),
(32, 15),
(4, 15),
(64, 15),
(9, 15),
(2, 15),
(28, 15),
(31, 15),
(3, 15),
(17, 15),
(67, 15),
(56, 15),
(65, 16),
(8, 16),
(12, 16),
(33, 16),
(9, 16),
(28, 16),
(31, 16),
(3, 16),
(56, 16),
(24, 16),
(57, 17),
(13, 17),
(12, 17),
(64, 17),
(16, 17),
(15, 17),
(31, 17),
(67, 17),
(14, 19),
(29, 19),
(21, 19),
(57, 19),
(13, 19),
(18, 19),
(16, 19),
(7, 19),
(31, 19),
(67, 19),
(14, 21),
(29, 21),
(57, 21),
(13, 21),
(64, 21),
(11, 21),
(26, 21),
(5, 23),
(1, 23),
(64, 23),
(2, 23),
(3, 23),
(19, 23),
(27, 23),
(30, 23),
(26, 23),
(29, 24),
(5, 24),
(1, 24),
(4, 24),
(2, 24),
(20, 24),
(16, 24),
(3, 24),
(19, 24),
(27, 24),
(30, 24),
(8, 25),
(13, 25),
(6, 25),
(33, 25),
(1, 25),
(55, 25),
(61, 26),
(62, 26),
(2, 26);

-- --------------------------------------------------------

--
-- Table structure for table `user_social_media`
--

CREATE TABLE `user_social_media` (
  `fk_user_id` int(11) NOT NULL,
  `fk_platform_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_social_media`
--

INSERT INTO `user_social_media` (`fk_user_id`, `fk_platform_id`, `username`) VALUES
(1, 1, 'monkeyballs'),
(1, 2, 'real_monkeyballs'),
(9, 1, 'slapuswilliam'),
(21, 1, 'legrain'),
(21, 2, 'legrain'),
(21, 3, 'legrain'),
(23, 1, 'CharlieBrown'),
(23, 2, 'BrownCharlie'),
(25, 1, 'thedataguy'),
(25, 2, 'thedataguy'),
(25, 3, 'thedataguy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_fk_mentor_id_foreign` (`fk_mentor_id`),
  ADD KEY `applications_fk_mentee_id_foreign` (`fk_mentee_id`);

--
-- Indexes for table `mentees`
--
ALTER TABLE `mentees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentees_fk_mentor_id_foreign` (`fk_mentor_id`),
  ADD KEY `mentees_fk_user_id_foreign` (`fk_user_id`);

--
-- Indexes for table `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mantors_fk_user_id_foreign` (`fk_user_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `social_media_platforms`
--
ALTER TABLE `social_media_platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_reviews_fk_mentor_id_foreign` (`fk_mentor_id`),
  ADD KEY `user_reviews_fk_mentee_id_foreign` (`fk_mentee_id`);

--
-- Indexes for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD KEY `user_skills_fk_skill_id` (`fk_skill_id`),
  ADD KEY `user_skills_fk_user_id` (`fk_user_id`);

--
-- Indexes for table `user_social_media`
--
ALTER TABLE `user_social_media`
  ADD KEY `user_social_media_fk_user_id_foreign` (`fk_user_id`),
  ADD KEY `user_social_media_fk_platform_id_foreign` (`fk_platform_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mentees`
--
ALTER TABLE `mentees`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `social_media_platforms`
--
ALTER TABLE `social_media_platforms`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_fk_skill_id` FOREIGN KEY (`fk_skill_id`) REFERENCES `skills` (`id`),
  ADD CONSTRAINT `user_skills_fk_user_id` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
