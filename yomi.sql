-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2023 at 06:49 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yomi`
--

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `LEVENSHTEIN`$$
CREATE DEFINER=`root`@`` FUNCTION `LEVENSHTEIN` (`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS INT  BEGIN
    DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
    DECLARE s1_char CHAR;
    DECLARE cv0, cv1 VARBINARY(256);
    SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
    IF s1 = s2 THEN
        RETURN 0;
    ELSEIF s1_len = 0 THEN
        RETURN s2_len;
    ELSEIF s2_len = 0 THEN
        RETURN s1_len;
    ELSE
        WHILE j <= s2_len DO
            SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
        END WHILE;
        WHILE i <= s1_len DO
            SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
            WHILE j <= s2_len DO
                SET c = c + 1;
                IF s1_char = SUBSTRING(s2, j, 1) THEN SET cost = 0; ELSE SET cost = 1; END IF;
                SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
                IF c > c_temp THEN SET c = c_temp; END IF;
                SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
                IF c > c_temp THEN SET c = c_temp; END IF;
                SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
            END WHILE;
            SET cv1 = cv0, i = i + 1;
        END WHILE;
    END IF;
    RETURN c;
END$$

DROP FUNCTION IF EXISTS `LEVENSHTEIN_RATIO`$$
CREATE DEFINER=`root`@`` FUNCTION `LEVENSHTEIN_RATIO` (`s1` VARCHAR(255), `s2` VARCHAR(255)) RETURNS INT  BEGIN
    DECLARE s1_len, s2_len, max_len INT;
    SET s1_len = LENGTH(s1), s2_len = LENGTH(s2);
    IF s1_len > s2_len THEN SET max_len = s1_len; ELSE SET max_len = s2_len; END IF;
    RETURN ROUND((1 - LEVENSHTEIN(s1, s2) / max_len) * 100);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `floor_unit` varchar(255) NOT NULL,
  `town_city` varchar(255) NOT NULL,
  `state_region` varchar(255) NOT NULL,
  `postcode` varchar(5) NOT NULL,
  `username` varchar(25) NOT NULL,
  `mode` varchar(10) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `fullname`, `phone_number`, `street`, `floor_unit`, `town_city`, `state_region`, `postcode`, `username`, `mode`) VALUES
(1, 'Abdullah Taqiuddin', '1129139740', '108 Jalan Pandan Indah 18', '', 'Pandan Indah', 'WP Kuala Lumpur', '55100', 'udinrhman', ''),
(5, 'Abdul Rahman', '1129139740', 'Jalan Cendekiawan 1', 'Floor 5, C2-05-08', 'Kajang', 'Selangor', '43009', 'udinrhman', 'default'),
(11, 'Muhammad Syawal', '1114901740', 'Jalan Panglima Bukit Gantang Wahab', '', 'Ipoh', 'Perak', '30000', 'syawal', 'default'),
(10, 'Udin', '23423523900', 'asdwsqwe', '123432', 'qweqwe', 'WP Labuan', '55100', 'shinoa', 'default'),
(12, 'Nik Muhd Asyraf', '1111939672', 'Jalan Pandan Ilmu', '', 'Pandan Indah', 'WP Kuala Lumpur', '56100', 'nikasyraf', 'default'),
(13, 'Muhammad Hakim Bin Pakhari', '12444486', 'Jalan Udaco ', '', 'Hulu Langat', 'Selangor', '43100', 'muhdhakim', 'default'),
(15, 'Farah Ismail', '12270333', '493 Jalan Tuaran', '', 'Kota Kinabalu', 'Sabah', '88990', 'farah', 'default'),
(16, 'Farah Ismail', '12270333', 'Jalan Lintas', '', 'Kota Kinabalu', 'Sabah', '88805', 'farah', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `mangaln_id` int NOT NULL,
  `cover` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alternative_title` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` int NOT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `mangaln_id`, `cover`, `title`, `alternative_title`, `volume`, `price`, `quantity`, `subtotal`, `username`) VALUES
(70, 36, '4087-SeireiGensouki.jpg', 'Seirei Gensouki', 'Seirei Gensouki: Spirit Chronicles', 'Volume 1', 45, 1, 45, 'syawal'),
(71, 45, '9325-pumpkinnight.jpg', 'Pumpkin Night', 'Pumpkin Night', 'Volume 1', 40, 1, 40, 'syawal'),
(74, 17, '4097-TheEminenceinShadow.jpg', 'Kage no Jitsuryokusha ni Naritakute!', 'The Eminence in Shadow', 'Volume 1', 44, 1, 44, 'adamzafran');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `mangaln_id` int NOT NULL,
  `username` varchar(25) NOT NULL,
  `user_comment` varchar(500) NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `mangaln_id`, `username`, `user_comment`, `comment_date`) VALUES
(10, 1, 'farah', 'The visuals are so appealing but I like that the story doesn\'t take itself overly seriously. There\'s still wonder and overconfidence and comedy in what the characters do and it\'s reflected in lightening up the art style in those moments and I think it works really well. The idea behind vampires is also really solid, the idea of true names and putting a bit of science into the nature of the beast is really cool, certainly an interesting take on it.', '2023-01-10 13:15:01'),
(12, 34, 'muhdhakim', 'The early chapters kinda gave me promise neverland vibes', '2023-01-06 16:24:49'),
(13, 41, 'syawal', 'Great characters, humor, and development, with lovely romance leading the way. You don\'t have to be in your school years to enjoy this one. I\'m a 32 y.o. man, and love this stuff', '2023-01-08 11:38:48'),
(14, 41, 'udinrhman', 'Anyone who hasn\'t read the manga, strap in. You guys are in for one hell of a ride, and you won\'t regret a single second of it.', '2023-01-11 11:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `donation_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `yomi_tokens` int NOT NULL,
  PRIMARY KEY (`donation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `username`, `yomi_tokens`) VALUES
(111, 'udinrhman', 10),
(10, 'udinrhman', 20),
(107, 'muhdhakim', 250),
(103, 'syawal', 100),
(82, 'farah', 10),
(81, 'farah', 20),
(80, 'udinrhman', 10),
(79, 'udinrhman', 10),
(108, 'nikasyraf', 200),
(112, 'udinrhman', 10),
(75, 'udinrhman', 10),
(74, 'udinrhman', 10);

-- --------------------------------------------------------

--
-- Table structure for table `mangaln`
--

DROP TABLE IF EXISTS `mangaln`;
CREATE TABLE IF NOT EXISTS `mangaln` (
  `mangaln_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `title` varchar(500) NOT NULL,
  `alternative_title` varchar(500) NOT NULL,
  `type` varchar(25) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `synopsis` varchar(2000) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `total_volume` int NOT NULL,
  `release_year` varchar(255) NOT NULL,
  `publication` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `admin_review` varchar(2000) NOT NULL,
  `admin_rating` int NOT NULL,
  `mangaln_date` datetime NOT NULL,
  PRIMARY KEY (`mangaln_id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mangaln`
--

INSERT INTO `mangaln` (`mangaln_id`, `username`, `title`, `alternative_title`, `type`, `cover`, `synopsis`, `author`, `genre`, `total_volume`, `release_year`, `publication`, `price`, `admin_review`, `admin_rating`, `mangaln_date`) VALUES
(1, 'admin', 'Vanitas no Carte', 'The Case Study of Vanitas', 'Manga', '7047-VanitasNoCarte.jpg', 'Paris, late 19th century. Vanitas is a human who works as a doctor for vampires and wishes to save them. He uses a magical book called The Vanitas Grimoire to dispel an evil curse that corrupts vampires and turns them into blood-sucking monsters. Butâ€¦this very same book is rumoured to be the cursed tome that gives birth to vampires on nights when the blue moon is full. Noe is a vampire on the hunt for The Grimoire. Who, really, is Dr Vanitas? What are the secrets that he holds, and what fate do those secrets spell for the vampire species?', 'Mochizuki Jun', 'Action,Drama,Mystery,Supernatural,Vampire', 10, '2015 to ?', 'Publishing', 40, 'Vanitas no Carte pulls you in right from the first chapter. A lot of mysteries and action are presented that you have to keep reading the next and the next and the next chapters in order to find the answers or at least, try to figure it out on your own. And knowing Mochizuki, I\'m sure she\'ll blow our minds away with how intricate she\'s able to weave everything together. Every chapter moves the plot forward. The pacing is neither too fast nor too slow. Each chapter, we learn something new and also find ourselves asking new questions.\r\n\r\nMochizuki\'s take on vampires for this story is also really unique. But to avoid spoiling the story, all I can say is that don\'t expect too much bloodsucking.', 5, '2022-11-27 23:49:35'),
(2, 'admin', 'Tokyo Ghoul', 'Tokyo Kushu', 'Manga', '5654-TokyoGhoul.jpg', 'Strange murders are happening in Tokyo. Due to liquid evidence at the scene, the police conclude the attacks are the results of \'eater\' type ghouls. College buddies Kaneki and Hide come up with the idea that ghouls are imitating humans so that\'s why they haven\'t ever seen one. Little did they know that their theory may very well become reality.', 'Ishida Sui', 'Action,Drama,Fantasy,Horror,Psychological,Thriller,Tragedy', 14, '2011 to Sep 18, 2014', 'Finished', 44, 'A grotesque and melancholic journey into the psychology of \"Ghouls\": humans that eat other humans. Also contains some excellent fight scenes and characterization. The more recent chapters are some of the best manga work I\'ve ever seen and the author\'s creepy (in a good way) art style compliments the content in a magnificent way; It gives it a strange finesse. Very highly recommended.', 5, '2022-11-19 00:29:43'),
(3, 'admin', 'D.Gray-man', 'D.Gray-man', 'Manga', '2933-dgrayman.jpg', 'Losing a loved one is so painful that one may sometimes wish to be able to resurrect them - a weakness that the enigmatic Millennium Earl exploits. To make his mechanical weapons known as \"Akuma,\" he uses the souls of the dead that are called back. Once a soul is placed in an Akuma, it is trapped forever, and the only way to save them is to exorcise them from their vessel using the Anti-Akuma weapon, \"Innocence.\"\r\nAfter spending three years as the disciple of General Cross, Allen Walker is sent to the Black Order - an organization comprised of those willing to fight Akuma and the Millennium Earl - to become an official Exorcist. With an arm as his Innocence and a cursed eye that can see the suffering souls within an Akuma, it\'s up to Allen and his fellow Exorcists to stop the Millennium Earl\'s ultimate plot: one that can lead to the destruction of the world.', 'Hoshino Katsura', 'Action,Adventure,Comedy,Drama,Fantasy,Mystery', 27, '2004 to ?', 'Publishing', 44, 'I\'ve been enthralled by the plot of D.Gray-Man ever since I first started reading it. Every issue leaves me wanting more. The story\'s characters are endearing, and the imaginativeness of the world in which they live is amazing. My imagination has also been sparked by the story that Katsura Hoshino has written. Both the plot and the characters of D.Gray-man are captivating. In certain instances, the characters had me laughing aloud before the battle scenes pulled me back into the drama of the plot. The story of D.Gray-Man is a complicated one, and only gets more so as the series progresses. As of the current place of the manga, there are still many unanswered questions, which I hope to see answered by the time it finishes. However despite the confusing nature of the story at points, it still is really good whether you can understand what\'s happening or not.', 4, '2022-11-27 23:49:27'),
(4, 'admin', 'Isekai Shikkaku', 'Disqualified from Otherworldliness', 'Manga', '9032-IsekaiShikkaku.jpg', 'In June 13th 1948, author Osamu Dazai was about to commit suicide with Shizuko Oota, but was then summoned into another world instead. Now he wants to find the reincarnation of his lover, so he can commit suicide with her.', 'Noda Hiroshi', 'Adventure,Comedy,Drama,Fantasy,Isekai', 7, '2019 to ?', 'Publishing', 44, 'To be honest, I\'ve just been binge reading the countless generic isekais that are out there- so when I jumped into Isekai Shikkaku, I really was not expecting much, other than your typical isekai with a gimmick thrown in.\r\n\r\nAnd indeed while this story does start out like many others- it starts to show its own unique style later on, not really focusing the actual fight scenes or the level progression aspects of Isekai but instead on the \"stories\" of characters in this world and in some cases how they may continue to unfold, all the while being careful not to take itself too seriously...', 3, '2022-11-27 23:49:18'),
(5, 'admin', 'Kuro no Shoukanshi', 'Black Summoner', 'Manga', '9312-KuroNoShoukanshi.jpg', 'Losing his memories as a compensation for a transfer to another world, the curtains of the story of Kelvin rise. While steadily getting stronger, he adds new subordinates by mastering his skills in hope to get powerful enough to summon his Angel Follower who he has supposedly fallen in love previous to the memory loss, but by the time he noticed it, he had obtained overwhelming power...', 'Mayoi Tofu', 'Action,Adventure,Fantasy,Isekai', 13, '2018 to ?', 'Publishing', 44, 'The story is nothing we haven\'t seen before. Classic Isekai story. OP MC. ETC ETC ETC.\r\n\r\nHowever, this is a fun one. It doesn\'t try to be anything revolutionary, and the MC is a TOTAL BATTLE MANIAC. He traded his memories for double growth, and has wound up making a summoning pact with the goddess of the world. Its a fun Isekai but nothing revolutionary. The story has no real plot at this point. Mostly classic \'HERO MUST SAVE THE WORLD\'. But our MC is not the hero, he is just an adventurer. So its more so MC wanders around in another world looking to power up and looks for fights.', 3, '2022-11-27 23:49:10'),
(17, 'admin', 'Kage no Jitsuryokusha ni Naritakute!', 'The Eminence in Shadow', 'Light Novel', '4097-TheEminenceinShadow.jpg', 'Just like how everyone adores heroes in their childhood, a certain boy adored those who hid in the shadows. One day, after living the mediocre life of a side character while undergoing frenzied training by night, he reincarnates in a different world and gains ultimate power. The young man who is only playing at being a secretive powerhouse, his misunderstanding subordinates, and a struggling, giant, shadowy organizationâ€¦\r\n\r\nThis is the story of a boy who adored shadowy manipulations who might possibly reign over the dark side of another world.', 'Aizawa Daisuke', 'Action,Comedy,Drama,Fantasy,Isekai', 5, '2018 to ?', 'Publishing', 44, 'This story at first glance seems to be your typical fantasy read. However, there is much more to it that meets the eye. The story is intriguing, with the general \"MC Wants To Hide Their Power\" being remade to a new tier/level of storytelling. It exhibits its indivisuality and uniqueness through its art and characters.\r\n\r\nThe story is based around the MC\'s group, \"Shadow Garden\", which is sort of a vigilante group seeking to protect peace. The series has a fair share of action and comedy-the comedy part is that people think the MC is a mastermind genius; while in fact he does things randomly at times and has no particular reason for it.\r\n\r\nThis series is certainly worth every second of your time and is an excellent masterpiece. The story, art and characters all heavily compliment one another and advances the story to a whole new level that I have never seen before. Excellent storytelling in every panel.', 5, '2022-11-27 23:49:01'),
(18, 'admin', '86', '86â€”Eighty-Six', 'Light Novel', '6718-86.jpg', 'The Republic of San Magnolia has long been under attack from the neighboring Giadian Empire\'s army of unmanned drones known as the Legion. After years of painstaking research, the Republic finally developed autonomous drones of their own, turning the one-sided struggle into a war without casualtiesâ€”or at least, that\'s what the government claims.\r\n\r\nIn truth, there is no such thing as a bloodless war. Beyond the fortified walls protecting the eighty-five Republic territories lies the \"nonexistent\" Eighty-Sixth Sector. The young men and women of this forsaken land are branded the Eighty-Six and, stripped of their humanity, pilot the \"unmanned\" weapons into battleâ€¦', 'Asato Asato', 'Action,Drama,Mecha,Romance,Sci-fi,Tragedy', 12, '2017 to ?', 'Publishing', 44, '86 Eighty Six (86 for short) is a light novel that has surprised me in quite a few ways.\r\n\r\n86 perfectly depicts the brutality of war, how fragile, insignificant and disposable human lives are on the battlefield; how soldiers have to strip away their humanity to continue fighting; how war can completely break a person\'s soul. Often times, soldiers sacrifice themselves in order for their comrades to advance, and they expect death to arrive at their doorstep any time. Such is the life of the 86.\r\n\r\n86 Eighty six is up there with some of the better of the mech genre, its dark tone and amazing main characters really help this a really enjoyable read, hopefully before the series ends they can give some development to the lesser focused side characters and wrap the series up in a satisfying manner.', 5, '2022-11-27 23:48:52'),
(19, 'admin', 'Kuro no Juudan', 'Black Bullet', 'Light Novel', '5398-BlackBullet.jpg', 'In near future, mankind has been defeated by the viral parasites named \"Gastrea.\" They have been exiled into a small territory and live in despair, side by side with terror. In this world trapped in darkness-Rentaro, a boy living near Tokyo and a member of the \"Civil Security\" - an organization specializing in fighting against the Gastrea - is used to accomplishing dangerous tasks. His partner is Enju, a precocious young girl. They fight using their peculiar powers until one day, they receive a special assignment from the government. This top secret mission is to prevent the destruction of Tokyoâ€¦\r\n\r\nSet in a near future, this thrilling heroic-action storyâ€¦ starts now!', 'Kanzaki Shiden', 'Action,Drama,Horror,Mystery,Sci-fi,Tragedy', 7, '2011 to 2014', 'Finished', 44, 'This light novel piqued my interest greatly. The action-packed fight scenes in the plot kept me engaged. Slow-exposition books normally make me nod off, but this one didn\'t seem to bother me. I was constantly on the edge of my bed anticipating what the main character or the supporting cast would do. The only flaw is that it appeared as though they hurried the ending. Like the final boss of a game comes during the tutorial.', 3, '2022-11-27 23:48:44'),
(20, 'admin', 'Tantei wa Mou, Shindeiru.', 'The Detective Is Already Dead', 'Light Novel', '5658-TheDetectiveIsAlreadyDead.jpg', 'â€‹Kimihiko Kimizuka has always been a magnet for trouble and intrigue. For as long as he can remember, heâ€™s been stumbling across murder scenes or receiving mysterious attache cases to transport.\r\n\r\nWhen he met Siesta, a brilliant detective fighting a secret war against an organization of pseudohumans, he couldnâ€™t resist the call to become her assistant and join her on an epic journey across the world.\r\n\r\nâ€¦Until a year ago, that is. Now heâ€™s returned to a life that is normal and tepid by comparison, knowing the adventure must be over.\r\nAfter all, the detective is already dead.', 'Nigojuu', 'Comedy,Drama,Mystery,Romance,School', 7, '2019 to ?', 'Publishing', 44, 'Aside from a few parts when it was a little difficult for me to follow because it alternated between the points of view of different characters, the plot was really engaging. The plot had me kind of sad but happy in the end no spoilers so I won\'t say any more about it. It\'s an incredible experience being relayed to the audience, managing to pull in elements from various works but still carving an identity for itself. It works brilliantly when humor, serious, dramatic moments, shifting points of view, and flashbacks are skillfully combined.', 4, '2022-11-27 23:48:36'),
(21, 'admin', 'Mieruko-chan', 'The Girl Who Sees ', 'Manga', '5122-Mierukochan.jpg', 'Miko Yotsuya is a typical high school student whose life turns upside down when she suddenly starts to see gruesome and hideous monsters. Despite being completely terrified, Miko carries on with her daily life, pretending not to notice the horrors that surround her. She must endure the fear in order to keep herself and her friend Hana Yurikawa out of danger, even if that means coming face to face with the absolute worst. Blending both comedy and horror, Mieruko-chan tells the story of a girl who tries to deal with the paranormal by acting indifferent toward it.', 'Izumi Tomoki', 'Comedy,Horror,Mystery,Psychological,Slice of Life,Supernatural', 8, '2018 to ?', 'Publishing', 44, 'The story revolves around a girl named Miko who is able to see terrifying and disgusting monsters that no one else can see. Although this story seems generic, it really isn\'t. Instead of the MC fighting the monsters and becoming some op hero, Miko puts on a poker face and attempts to ignore them. The story develops and gets very intense, it\'s not just a collection of standalone chapters. The story gets more fleshed out and introduces very interesting characters that leaves you on the edge of your seat wondering what kind of development will come next. The art is beautiful, the characters are very funny and lovable, and the manga as a whole is fantastic and absolutely worth the read.', 3, '2022-11-27 23:48:13'),
(22, 'admin', 'Yofukashi no Uta', 'Call of the Night', 'Manga', '2777-YofukashiNoUta.jpg', 'Unable to sleep or find true satisfaction in his daily life, Yamori Kou begins wandering the night streets. He encounters a strange girl who offers to help soothe his insomnia by sleeping beside him, but it is not merely a one-way exchangeâ€¦', 'Kotoyama', 'Comedy,Slice of Life,Supernatural,Vampire', 13, '2019 to ?', 'Publishing', 44, 'I\'ll start off by saying that this manga is by no means for everyone. The themes it mainly focuses on are not for everyone, being a romcom about vampires, with underlying commentary on daily life and society. The commentary does come from the perspective of a 13 year old drop out, but even still, his unwillingness to live a normal, everyday life can be relatable to a lot of people. It has a very cliched trope of \'trying to fall in love\' with another person, but this manga in my opinion processes this trope fairly well. The introduced characters are all fully developed with their own arcs and some of them packing unexpected turns to the story.', 4, '2022-11-27 23:48:04'),
(23, 'admin', 'Boushoku no Berserk: Ore dake Level to Iu Gainen wo Toppa suru', 'Berserk of Gluttony', 'Light Novel', '8462-BerserkOfGluttony.jpg', 'In this world, there are two types of people. Those Who have powerful \"skills\", and those who don\'t. People born with powerful skills, exterminate monsters to level up and become successful, while people without them, become failures, who are treated harshly by society. Follow the story of Fate, a guy who works as a gatekeeper, and whose only skill is gluttony, a skill that only makes him hungry.', 'Isshiki Ichika', 'Action,Adventure,Drama,Fantasy', 7, '2017 to ?', 'Publishing', 45, 'The premise for characters that undergo a life-changing transformation from weak to overpowered has always excited me, Berserk of Gluttony is no exception. MC, Fate Graphite is a commoner that serves under abusive Holy Knights by taking shifts gate-keeping and earning (supposedly slightly above 2 silvers per year ~ I\'d estimate around USD$150-200.00) His powers mysteriously awaken and are enhanced when he finds a \'broken\' sword dubbed \'Greed\'. Fate begins his journey helping his master survive the treacherous lands of a war-torn kingdom.\r\n\r\nThe author really thinks things through and builds interesting characters. The story can shine through, which really means something. I think that if your looking for a gritty fantasy story, then you just struck gold, or maybe silver, in any case, it will be enjoyable.', 3, '2022-11-27 23:47:54'),
(24, 'admin', 'Tensei Kizoku no Isekai Boukenroku: Jichou wo Shiranai Kamigami no Shito', 'Chronicles of an Aristocrat Reborn in Another World', 'Manga', '1749-TenseiKizoku.jpg', 'Shiina Kazuya, our protagonist who was killed by a stranger when he tried to protect his childhood friend\'s little sister, was reincarnated into a world of sword and magic as Cain von Silford, the third son of an aristocrat.\r\n\r\nCain grew up being surrounded by gods that don\'t know self-restraint, the upper stratum of royalty, and manipulative girls.\r\n\r\nThis is a classic fantasy about a slightly two-faced, slightly clumsy, and careless young man who, with the excessive divine blessings received from the gods, overcomes any obstacle that come his way while hiding his unbelievable status.', 'Yashu', 'Action,Adventure,Fantasy,Isekai,Romance', 8, '2018 to ?', 'Publishing', 45, 'This story is a fairly average overpowered isekai story. The guy is born into a noble family, has exceptional powers both bestowed from the gods and learned himself from his own effort and previous life knowledge. He constantly surprises everyone with how amazing he is and how much he breaks common sense despite trying to restrain himself. So far itâ€™s not really anything special or groundbreaking itâ€™s a fairly ordinary isekai. That said if isekai is your thing and/or guilty pleasure like it is mine this will still be a fun read. It was a really fun experience (and good diversion from my stress of writing a paper) that really kind of sums this up itâ€™s just fun. itâ€™s something you can read to unwind and just sort of go through the flow and almost shut your Brain off and just relax.', 4, '2022-11-27 23:47:46'),
(25, 'admin', 'Yozakura-san Chi no Daisakusen', 'Mission: Yozakura Family', 'Manga', '8167-YozakuraFamily.jpg', 'Taiyo Asano is a super shy high school student and the only person he can talk to is his childhood friend, Mutsumi Yozakura. It turns out that Mutsumi is the daughter of the ultimate spy family! Even worse, Mutsumi is being harassed by her overprotective, nightmare of a brother, Kyoichiro. What drastic steps will Taiyo have to take to save Mutsumi?! A spy family comedy - the mission begins!', 'Gondaira Hitsuji', 'Action,Comedy,Romance', 15, '2019 to ?', 'Publishing', 45, 'It\'s got good laughs and a decent amount of romance that fits perfectly. The action and art in this manga are also pretty great, albeit pretty typical of a shonen manga.\r\n\r\nThe manga is not about the male protagonist trying to save the female protagonist from her family. It\'s not that simple. This manga has an actual plot, although it does take a few dozen chapters to really get introduced. Additionally it\'s not like her family is absolutely terrible and needs to be saved. The family members are all very important and are really about the only consistent characters in the story. Each member of the family cares very deeply for each other.\r\n\r\nAll in all this manga has been a great read for me so far, so don\'t be dissuaded by the boring synopsis that makes this comedic, romantic and action packed manga seem like some repetitive Slice-of-life.', 4, '2022-11-27 23:47:39'),
(26, 'admin', 'Spy Kyoushitsu', 'Spy Classroom', 'Light Novel', '4512-SpyClassroom.jpg', 'A world where wars are fought with spies. With a mission success rate of 100%, the remarkable, yet rather difficult to deal with, spy Klaus is being tasked with an almost impossible mission by the agency, harboring an insane 90% chance of failure and deathâ€¦which for some reason involves eight inexperienced girls?!', 'Takemachi', 'Action,Comedy,Mystery,Romance', 7, '2020 to ?', 'Publishing', 50, 'The structure of the story is amazing. It dictated the pacing and understanding of the story, and when you finish, you will be â€œOh, so thatâ€™s what it was about.â€, and something â€œclickâ€ on your head. So you go check if you didnâ€™t miss something, and you definitely missed, but is passed unnoticed. And thatâ€™s the time when you realize how good it was. Canâ€™t talk too much because it is a huge spoiler, but go read it! \r\n\r\nIf you want a refreshing and enjoyable light novel, with a light read and good content, Spy Kyoushitsu is perfect for you! The characters are great, the pacing is good, the plot and storytelling are amazing, and the theme is what really shines!', 5, '2022-11-27 23:47:15'),
(27, 'admin', 'Kawaii dake ja Nai Shikimori-san', 'Shikimori\'s Not Just a Cutie', 'Manga', '3259-ShikimoriNotJustaACutie.jpg', 'Daily life of a herbivore, unlucky boyfriend and his amazing and sometimes intimidating girlfriend.', ' Maki Keigo', 'Comedy,Romance,School,Slice of Life', 14, '2019 to ?', 'Publishing', 40, 'The characters are also just fun loving, nice people and there is almost zero drama. A slice of life, romance in its purest form. The story? Watch as these two young love birds go through high school life as Shikimori helps Izumi through the troubled bad luck. They have a perfect relationship. Perfect friends. Perfect parents. No drama.\r\n\r\nThe art is amazing though. Like... Really amazing. The art is so good I can not stress this enough. The detail and character designs are so damn amazing. No joke here. I just really appreciate the level of effort and talent behind literally every panel.\r\n\r\nSome may enjoy it more than me and that is fine. Others might not. That is fine too. Read it and form your own opinion.', 4, '2022-11-27 23:47:03'),
(28, 'admin', 'Lv999 no Murabito', 'The Villager of Level 999', 'Manga', '3064-LV999NoMurabito.jpg', 'In this world, the concept of levels exist. Other than those who live off defeating monsters, most people are only around Level 1 to 5. What\'s more, not just anyone can go out to hunt monsters; it\'s heavily influenced by one\'s role appointed by God. There are eight such eligible roles: warriors, fighters, clerics, magicians, rogues, merchants, hunters, and sorcerers. Those blessed with extraordinary power are divided into three types: royalty, heroes, and sages. But for the majority of the population, they have no such powers and live by farming or running shops. Towns are developed by those with the weakest role: villagers. \r\n\r\nFor the powerless villagers going out to hunt monsters is equivalent to committing suicide. But one day, a certain two-year-old child given the role of villager notices something: once you defeat a monsterâ€¦ you can earn great wealth.', 'Hoshitsuki Koneko', 'Action,Adventure,Comedy,Drama,Fantasy,Romance,Slice of Life', 12, '2017 to ?', 'Publishing', 40, 'Honestly, it\'s good. It\'s nothing spectacular, but it\'s good. It\'s not any deal breaker for the isekai genre, but it kinda gets close to it. You\'re in for a big surprise at chapter 43, that\'s for sure.\r\n\r\nNow, when we see those series with level system, classes, attributes, floating menu above characters, the in-series characters take it as a granted never questioning why things are that way. The MC is suspicious of that system, he wants to know how in the blazes this suddenly began, who did this, who made humans and demons fight and more.\r\n\r\nThis guy realizes that the classes system provides some benefits to each class, he exploits it and reaches Lv.999 (as the titles suggests) and discovers something, a clue to figuring out this world. Ff you are curious then I hope that you will give this manga a try. The first bunch of chapters aren\'t very ground-breaking, but I still hope that you will give it a chance and take the gamble that chapters 14 and onwards will be the game changers.', 4, '2022-11-27 23:46:56'),
(29, 'admin', 'Death March kara Hajimaru Isekai Kyousoukyoku', 'Death March to the Parallel World Rhapsody', 'Light Novel', '3024-DeathMarch.jpg', '29-year-old programmer Suzuki Ichirou finds himself transported into a fantasy RPG. Within the game, he\'s a 15-year-old named Satuu. At first he thinks he\'s dreaming, but his experiences seem very real. Due to a powerful ability he possesses with limited use, he ends up wiping out an army of lizard men and becomes a high leveled adventurer. Satuu decides to hide his level, and plans to live peacefully and meet new people. However, developments in the game\'s story, such as the return of a demon king, may cause a nuisance to Satuu\'s plans.', 'Ainana Hiro', 'Action,Adventure,Drama,Fantasy,Isekai,Slice of Life', 26, '2014 to ?', 'Publishing', 40, 'I would describe Death March as a Slice of life novel of another world. Nothing much really happens from the main male character going to tea parties with nobles, to going on a desperate multi-day quest for the sacred ingredient, pickles. The side stories include the main character nonchalantly killing off demon lords and dragon gods, and the like. Of course while killing demon lords seems uneventful to the overpowered main character, side characters and the world itself become greatly affected by such \"trivial\" actions. This causes several events to unfold simultaneously, building up to some interesting situations throughout the story.\r\n\r\nSlice of life style stories aren\'t for everyone as they are slow paced. Especially with the lacking overarching story, if you are looking for something high powered, this is definitely not the story for you. For the casual-type story reader, this would be of more interest.', 4, '2022-11-27 23:46:46'),
(30, 'admin', 'D-Frag!', 'D-FRAGMENTS!', 'Manga', '3668-D-frag.jpg', 'Kazama Kenji likes to believe he is something of a delinquent. Moreover, others seem to like to agree that he is. Of course, Kenji\'s gang finds their way to a group of four not-so-normal girls - Chitose, Sakura, Minami and Roka - and all at once, whatever reputation he may have, is nothing compared to the outrageous behavior of the girls. Shanghaied into joining their club, what will happen to his everyday life from that point on?', 'Haruno Tomoya', 'Comedy,Romance,School,Slice of Life', 16, '2008 to ?', 'Publishing', 30, 'I personally enjoyed D-frag a lot; It made me laugh throughout the whole duration with hilarious and absurd situations, as well as the wide assortment of characters. There were naturally some gags that got old or were predictable, besides of having no story direction whatsoever: this was nevertheless a small drawback. So if you are interested in reading a comedy manga, or just are searching for something to read, D-frag may be something for you. Just don\'t expect any deep characters or story.', 5, '2022-11-27 23:46:38'),
(31, 'admin', 'Naka no Hito Genome [Jikkyouchuu]', 'Nakanohito Genome [Jikkyouchuu]', 'Manga', '1012-NakaNoHitoGenome.jpg', 'Iride Akatsuki has unlocked hidden content in the game he\'s playing (Naka no Hito Genome), and it turns out that this content is a real-life game! He soon wakes up to find that he has been kidnapped and taken to a strange place, along with a number of other teammates. Each of them specializes in a certain sort of game, like cultivation games, fighting games, puzzle games, etc. A llama-headed \'teacher\' gathers them after level 1 is cleared to explain how the game will proceed. Will this group of gamers succeed, and make it back to their real lives?', 'Osora', 'Adventure,Comedy,Mystery,Psychological,Supernatural', 10, '2014 to ?', 'Hiatus', 30, ' The characters are tasked to complete games in order to gain views to reach their 1 hundred million view goal. Each game is different and potentially leaves their lives in danger. There is a sense of danger with everything not just with the games but with each other as well as each of them has a secret that may even be connected to the whole game history. The games are never the same that it\'s interesting to see how they push through each one. The games themselves are relatively simple but there is often a twist to them.\r\n\r\nOverall I think the best part would be that even though it does have it\'s comedic parts they still have have a dark aspect to it where they can never really ensure that they really know what is happening.', 4, '2022-11-27 23:46:30'),
(32, 'admin', 'Mairimashita! Iruma-kun', 'Welcome to Demon School! Iruma-kun', 'Manga', '2540-MairimashitaIruma-kun.jpg', 'Iruma Suzuki, fourteen years old, canâ€™t say no to any request. His irresponsible parents make him work dangerous job after dangerous job to support them, and then one day they sell him to a demon! But, much to his surprise, the demon wants to adopt Iruma as his grandson? Unable to refuse his request, Iruma becomes the grandson of the great demon Sullivan. His new doting demon grandfather enrolls him in Demon School Babyls â€“ where Sullivan is coincidentally the principal. Thus begins Iruma-kun\'s extraordinary school life among the otherworldly, meeting many colorful demons, taking on daunting challenges, and facing his true self as he rises to become someone great.\r\n\r\nCozy magical slice of life with occasional urban terrorism.', 'Osamu Nishi', 'Action,Comedy,Fantasy,Isekai,School', 29, '2017 to ?', 'Publishing', 45, 'Mairimashita Iruma-kun! is a fun school-life style comedy. The art style is somewhat simplistic, the comedy lighthearted and innocent, and the characters are bold and likable. The story is comprised of short arcs, episodic in nature, and there is little to no overarching plot. Characters still maintain the development they received during said arcs, however, so all good. \r\n\r\nOverall, a well-rounded manga driven by excellent characters and lighthearted humor that works well in the fantasy, school life and comedy genres. Recommend for a light read, lots of potential for the future.', 5, '2022-11-27 23:46:20'),
(33, 'admin', 'Youkoso Jitsuryoku Shijou Shugi no Kyoushitsu e', 'Classroom of the Elite', 'Light Novel', '3014-cote.jpg', 'Kodo Ikusei Senior High School, a leading prestigious school with state-of-the-art facilities where nearly 100% of students go on to university or find employment. The students there have the freedom to wear any hairstyle and bring any personal effects they desire. Kodo Ikusei is a paradise-like school, but the truth is that only the most superior of students receive favorable treatment. The protagonist Kiyotaka Ayanokoji is a student of D-class, which is where the school dumps its \"inferior\" students in order to ridicule them. For a certain reason, Kiyotaka was careless on his entrance examination, and was put in D-class. After meeting Suzune Horikita and Kikyo Kushida, two other students in his class, Kiyotaka\'s situation begins to change.', 'Kinugasa Shougo', 'Drama,School,Thriller', 14, '2015 to 2019', 'Finished', 50, 'This truly feels like a battle between the best of the best, It fits the themes of the series very well, and I am glad it has never backed down on it while also not romanticizing it. Those aspects fulfill their roles in the story then leave when the time is right. This aspect allows you see every part of a character, with real stakes you will see the most desperate side and the most perfect side to most characters. The rules and environment are very clearly laid out, it shows real world building and the authors cares about witting a good story. Every test has a full page break down of it rules, the technology, school structure is clearly shown and explained as the environment itself changes. \r\n\r\nFor a high schools, setting there is a lot of depth in this world. Each and very plot per volume is very different from the rest and always pairs characters up in interesting ways. There is no black and white here, you find characters being absolute villains doing whatever devious methods they can to win and in the next volume our characters are forced to team up with them. You learn so much about so many people, the place feels alive. \r\n\r\nThe interactions between characters make up most of the non-testing plot, yet it never gets old because each one of them has a defined confident personality that clashes with others. The dialogue is meant to be read in-between the lines to figure out what the characters hidden plan is. Entire characters will completely shift personalities or be removed from the series for a long while because it makes sense in universe. It shows really character progression, the main cast is almost an entire different cast from the first volumes which is amazing. Overall this series is deceptively complex and is just a great story first and foremost.', 5, '2022-11-27 23:46:11'),
(34, 'admin', 'Owari no Seraph', 'Seraph of the End: Vampire Reign', 'Manga', '6575-SeraphOfTheEnd.jpg', 'One day, a mysterious virus appeared on Earth which killed every infected human over the age of 13. At the same time, vampires emerged from the world\'s dark recesses and enslaved mankind. Enter Hyakuya Yuuichirou, a young boy, who along with the rest of the children from his orphanage, are treated as livestock by the vampires. Even in captivity, Yuuichirou dreams big. He dreams of killing vampires. He dreams of killing them all.', 'Furuya Daisuke, Kagami Takaya', 'Action,Mystery,Psychological,Supernatural,Thriller,Vampire', 28, '2012 to ?', 'Publishing', 45, 'First of all I want to mention how GORGEOUS the art is. I cannot emphasize it enough. For the story, there was the clichÃ© concept of teenagers fighting against vampires in a disease ridden world, and also seeking for revenge and general character development. But in spite of that concept being clichÃ©, somehow the characters we meet really make it turn into something fun to read.\r\n\r\nWhat I like about this manga has to be how well the story was thought out, the chapters began generically â€” vampires are evil, humans are good, that sort of stuff. But the more you read, the more you dive into the truth of the universe and the beginning of the true apocalypse. We understand that in this universe, there is no good side and there is no evil side. And that humans can be equally as wicked as vampires, vice versa. Itâ€™s a story about how everyone in this world are trying to fight for something thinking itâ€™s for the benefit of their people, when in reality, it just leads to more destructiveness. People claim that itâ€™s very generic, but the amount of plot twists it has makes me get so hooked onto.', 5, '2023-01-10 16:56:01'),
(35, 'admin', 'Otome Game Sekai wa Mob ni Kibishii Sekai desu', 'Trapped in a Dating Sim: The World of Otome Game is Tough for Mobs', 'Light Novel', '4067-mobuseka.jpg', 'Leon, a former Japanese worker, was reincarnated into an â€œotome gameâ€ world, and despaired at how it was a world where females hold dominance over males. It was as if men were just livestock that served as stepping stones for females in this world. The only exceptions were the gameâ€™s romantic targets, a group of handsome men led by the crown prince. In these bizarre circumstances, Leon held one weapon: his knowledge from his previous world, where his brazen sister had forced him to complete this game. This is a story about his adventure to survive and thrive in this world.', 'Mishima Yomu', 'Action,Adventure,Comedy,Fantasy,Isekai,Mecha,Romance,Slice of Life', 11, '2018 to ?', 'Publishing', 50, 'First I just wanna say, if you\'re looking for a fresh take on the \"reincarnated as the villainess\" genre, then this light novel is for you. Magic, mechas, interesting MC, love interests, etc. go read it, it\'s surprisingly good. I think this might be a hidden gem. In a way this series is truly a LIGHT novel, it\'s both light-hearted and casual without being deep or meaningfully dramatic, at least to me. Simply fun to read with some comedic moments that had me laugh a few times and enjoy myself.\r\n\r\nThe interactions between Leon and the rest of the character are the best part of the series. The deeply antagonistic mentality of Leon are what make the series worth giving a try.', 4, '2022-11-27 23:45:51'),
(36, 'admin', 'Seirei Gensouki', 'Seirei Gensouki: Spirit Chronicles', 'Light Novel', '4087-SeireiGensouki.jpg', 'Amakawa Haruto is a young man who died before reuniting with his childhood friend who disappeared five years ago. Rio is a boy living in the slums who wants revenge for his mother who was murdered in front of him when he was five years old.\r\n\r\nEarth and another world. Two people with completely different backgrounds and values. For some reason, the memories and personality of Haruto who should\'ve died is resurrected in Rio\'s body. As the two are confused over their memories and personalities fusing together, Rio decides to live in this new world.\r\n\r\nAlong with Haruto\'s memories, Rio awakens an unknown \"special power,\" and it seems that if he uses it well, he can live a better life. But before that, Rio encounters a kidnapping that turns out to be of a princess of the Bertram Kingdom that he lives in.\r\n\r\nAfter saving the princess, Rio is given a scholarship at the Royal Academy, a school for the rich and powerful. Being a poor orphan in a school of nobles turns out to be an extremely detestable place to be.', 'Kitayama Yuri', 'Action,Adventure,Drama,Fantasy,Isekai,Romance', 22, '2015 to ?', 'Publishing', 45, 'The best part about this novel is that multiple different plots are going on simultaneously. there is always something occurring and something to anticipate. Together with the isekai/fantasy setup makes this very enjoyable and I can praise this highly as isekai. The story develops rather fast too.', 3, '2022-11-27 23:45:41'),
(37, 'admin', 'Dungeon ni Deai wo Motomeru no wa Machigatteiru Darou ka', 'Is It Wrong to Try to Pick Up Girls in a Dungeon?', 'Light Novel', '2434-DanMachi.jpg', 'Bell Cranel is just trying to find his way in the world. Of course, in his case, the â€œworldâ€ is an enormous dungeon filled with monsters below a city run by gods and goddesses with way too much time on their hands. Heâ€™s got big dreams but not much more when a roll on the random encounter die brings him face-to-face with the girl of his dreamsâ€”but whatâ€™s an amateur adventurer got to offer a brilliant swords woman? And what if the lonely goddess who sponsors his solo adventuring gets jealous?', 'Oomori Fujino', 'Action,Adventure,Comedy,Drama,Fantasy,Romance', 17, '2013 to ?', 'Publishing', 45, 'The author manages to make you go through those emotions and makes the scenarios feel like he writes them, imagining each scenario is easy because of the descriptions he gives of the moments they live, both the description of the environment and the actions taken by the characters are easy to understand and imagine.\r\n\r\nIt also has a great backstory, which I personally think is fabulous. If you avoid spoilers you can\'t stop being surprised and the more you read the more you scale the story it presents. With many plot twists and teachings that can be transmitted (values, thoughts, etc.), full of funny, sad and happy moments. A reading that I find entertaining and profitable.', 4, '2022-11-27 23:45:31'),
(38, 'admin', 'Assassin de Aru Ore no Sutetasu ga Yuusha Yori mo Akiraka ni Tsuyoi Nodaga', 'My Status as an Assassin Obviously Exceeds the Heroâ€™s', 'Light Novel', '1066-assassinstatus.jpg', 'Oda Akira, a high school student who excels in erasing his presence, was summoned along with his classmates to another world. In this world of sword and magic, Akira and his classmates were asked to become heroes and bring down the demon king. Having a bad feeling about the king and the princess who asked them, Akira uses his special skills to sneak into the king\'s library, in hopes of discovering the truth. Whether to help or abandon his classmates who knew nothing, it all depended on Akira.', 'Akai Matsuri', 'Action,Adventure,Fantasy,Isekai', 4, '2017 to ?', 'Publishing', 40, 'This is one of the few Isekais where Overpowered MC is handled pretty well.\r\nNot just completely focusing on the MC but also around him, not going to the \"cliche\" path as the others but still manage to be interesting.\r\n\r\nThe story revolves around our MC named Akira who got summoned along with his 2nd Year classmate. But even if they were summoned, only one will be get the title \"Hero\". Our MC didn\'t manage to get a hold of it but instead given an \"Assassin\" class. I assure you that this one isn\'t the same as the most Isekai stories.', 3, '2022-11-10 17:13:15'),
(60, 'admin', 'Yuujin Character no Ore ga Motemakuru Wake Nai Darou?', 'There\'s no way a side character like me could be popular, right?', 'Light Novel', '9334-yuujinChara.jpg', 'I\'m Yuuki Tomoki, a normal second-year student in high school. Perfectly normal, if not for the fact that everyone avoids me like the plague because I look like I\'m out for blood. The only exception is the typical novel protagonist chad Haruma Ike. But one day, his sister Touka confessed to me! This chick just met me yesterday, what\'s she going on about?! In any case, I decided to be her fake boyfriend on account of my friendship with Haruma. But now even Haruma\'s idol-tier childhood friend and a smoking hot teacher is getting involved with me?! Hold up, this ain\'t a romcom wet dream! I mean, there\'s no way a sidekick like me could be popular, right?', 'Sekaiichi', 'Comedy,Romance,School,Slice of Life', 3, '2019 to ?', 'Publishing', 50, 'This light novel is written in first person perspective, so it is quite intense when you are reading it. You might feel involved in the light novel depending on how deeply you read it. Each chapter is interesting. I never felt bored in any chapter. The characters are really good. I really like the protagonist\'s personality. He is quite perceptive and not too dense which makes it enjoyable to read. You can go for this light novel if you are looking for an easy read or a light hearted light novel or if you like romance. This would definitely not be a waste of your time.', 3, '2022-11-27 22:57:34'),
(40, 'admin', 'Otonari no Tenshi-sama ni Itsunomanika Dame Ningen ni Sareteita Ken', 'The Angel Next Door Spoils Me Rotten', 'Light Novel', '6527-AngelNextDoor.jpeg', 'Amane Fujimiyaâ€™s neighbor in the apartment he lives in is the schoolâ€™s number one lovable angel: Excellent and with a level of beauty that can only be described as angelic â€“ Mahiru Shiina. Amane, an ordinary student who doesnâ€™t stand out, is her neighbour, but until now, they didnâ€™t interact with each other. After meeting the soggy angel in the rain:\r\n\r\nâ€œIâ€™m returning what I borrowed. By the way, clean up your room. Itâ€™s filthy.â€\r\nâ€œNone of your business.â€\r\n\r\nA relationship with a slightly sharp-tongued angel begins, starting with handing over an umbrella. From catching a cold and having someone take care of you, to making a meal for someone because they neglected their health, to joint work (cleaning rooms)â€¦\'', 'Saeki-san', 'Comedy,Romance,School,Slice of Life', 6, '2019 to ?', 'Publishing', 45, 'Simple yet great storytelling. this LN did great with its narrations, dialogues, and choice of words which makes you able to picture the situations that the author wanted to portray and feel the emotions that the author wanted you to feel.\r\nKudos to the author Saeki-san.\r\n\r\nIf you enjoy slow, calm, and wholesome romance that emphasizes the relationship between the main characters (without unnecessary conflicts by third parties), then this is definitely for you. Beware of the possibility of diabetes caused by cuteness overload though.', 4, '2022-11-10 21:56:57'),
(41, 'admin', 'Horimiya', 'Hori-san and Miyamura-kun', 'Manga', '2834-horimiya.jpg', 'Kyoko Hori is your average teenage girlâ€¦ who has a side she wants no one else to ever discover. Then there\'s her classmate Izumi Miyamura, your average glasses-wearing boy â€” who\'s also a totally different person outside of school. When the two unexpectedly meet, they discover each other\'s secrets, and a friendship is born.', 'Hero', 'Comedy,Romance,School,Slice of Life', 16, '2011 to 2021', 'Finished', 45, 'Truly, this manga is a character-driven story. The pacing is slow and sweet, guaranteeing a thorough look at the characters and building up the relationships of the cast, especially that of the two leads. Just when you think your heart can take on whatever happens next, the new chapter will taunt you, tease you and ultimately make your heart swell with the joy of budding love.', 4, '2022-11-10 21:57:21'),
(42, 'admin', 'Kuzumi-kun, Kuuki Yometemasu ka?', 'Kuzumi-kun, Can\'t You Read the Room?', 'Manga', '2421-kuzumikun.jpg', 'Erika Sakura is the school\'s most popular female high schooler, and only met with envious gazes since she is out of everyone\'s league. However, she is recently interested in a certain male high schooler who can\'t read between the lines, Kuzumi. While having a relationship between the two is out of the question, her unrequited love will soon change in this romantic comedy. Follow this new inevitably heart pounding, out-of-contact short love comedy!', 'Mosuko', 'Comedy,Romance,School,Slice of Life', 8, '2015 to 2019', 'Finished', 40, 'The great thing the author did was that he didn\'t stretch things too much, the pacing was just right as they moved from one phase of the story to other. Every single character was likable and every single scene was paced perfectly. It was an absolute delight from start to finish. The occasional comedy was also done brilliantly, earning a healthy chuckle from me. I do recommend this to anyone looking for a lighter and interesting story at the same time, but most importantly to those who are fan of romance/comedy genre who are looking what to read next.', 3, '2022-11-10 22:07:44'),
(43, 'admin', 'Tanaka-kun wa Itsumo Kedaruge', 'Tanaka-kun Is Always Listless', 'Manga', '7299-tanaka.jpg', 'If there is one thing that Tanaka wants more than anything, it is a quiet, uneventful day. With the help of his caring and reliable best friend Oota, as well as various other classmates, Tanaka strives to spend his high school days in the most peaceful way possible. Whether it be sleeping in the perfect spot at school or idly staring out of a window, his friends can count on finding him trying to live life as listlessly as possible. With the constant threat of everyday annoyances surrounding him, Tanaka uses every chance he has to avoid high-energy situations and just lie down for a good nap.', 'Uda Nozomi', 'Comedy,School,Slice of Life', 13, '2013 to 2019', 'Finished', 40, 'This manga was enjoyable overall if you\'re looking for a fun, wholesome slice of life read which can fill up some leisure time on a weeknight or weekend. The characters are unique and add color to the overall comedy and plot of the story, and the comedy itself is incredibly consistent, wholesome and engaging. If you\'re someone who wants a fun, enjoyable read and loves slice of life, look no further. The chapters are fast yet engaging with each hosting its own short story that adds to the overall series, and are independent of each other while others start its story right from the previous one.', 3, '2022-11-10 22:16:50');
INSERT INTO `mangaln` (`mangaln_id`, `username`, `title`, `alternative_title`, `type`, `cover`, `synopsis`, `author`, `genre`, `total_volume`, `release_year`, `publication`, `price`, `admin_review`, `admin_rating`, `mangaln_date`) VALUES
(44, 'admin', 'Nozomanu Fushi no Boukensha', 'The Unwanted Undead Adventurer', 'Light Novel', '1704-unwanted.jpg', 'Rentt Faina, a twenty-five-year-old adventurer, has been hacking away at monsters for a decade. However, without much talent for the job, Rentt finds himself stuck hunting slimes and goblins for meager amounts of coin every day. Little does he know, all this is about to change when he comes across a seemingly undiscovered path in the Labyrinth of the Moon\'s Reflection. What awaits him at the end of the path, however, is neither treasure nor riches, but a legendary dragon that wastes no time swallowing him whole! Waking up a short time later, Rentt finds himself not quite dead, but not very alive eitherâ€”he is nothing more than a pile of bones! Armed with nothing but his trusty sword, tool belt, and ghoulish new looks, Rentt sets off on his quest as a newly reborn Skeleton to achieve Existential Evolution, hoping to one day return to civilization with a more human form.', 'Okano Yuu', 'Action,Adventure,Fantasy,Mystery', 10, '2017 to ?', 'Publishing', 50, 'The story itself progresses quite slowly, but I find that this isn\'t a problem for me. The pacing is consistent and the author introduces new, interesting characters and tidbits about the world on a regular basis. It\'s slow, but certainly not boring. A great deal of the story revolves around Rentt dealing with his new condition and interacting with the various people he knew in life. Of course, there are action parts as he gets stronger and stronger as the story progresses, but these action scenes are there to serve the story and not just because the author wanted more meaningless action scenes. The worldbuilding is done well, with new information being provided to the reader frequently. I understand that this might be a bit too \"boring\" for some readers, but it really works well to keep some people entertained. I would recommend you check it out if you\'re interested.', 4, '2022-11-10 22:30:15'),
(45, 'admin', 'Pumpkin Night', 'Pumpkin Night', 'Manga', '9325-pumpkinnight.jpg', 'Having suffered vicious bullying in junior high, schoolgirl Naoko Kirino was admitted to a mental hospital. A few years later, she kills all of the medical staff and escapes. Now, as Naoko wanders around town wearing a disfigured pumpkin head, all that occupies her mind is exacting revenge against those who cruelly wronged her. It is time for revenge. Nobody can escape; \"Pumpkin Night\" seeks to kill them all.', 'Hokazono Masaya', 'Action,Drama,Horror,Psychological,Thriller,Tragedy', 7, '2016 to ?', 'Publishing', 40, 'If you\'re looking for some quick manga with good art and amazing death scenes, this is definitely the one. However, if you\'re extremely hung up on characters and story, this one might bore you. However, the comedic translation and the mangaka\'s amazing sense of political humor is just incredible, and will either have you on the floor laughing or shaking your head in disappointment. Pumpkin Night is a 50/50 hit-or-miss, and I think that it\'s only for certain people, mostly those who don\'t care about a shallow story or borderline retarded characters.', 4, '2022-11-19 00:31:35'),
(46, 'admin', 'Tsuki to Laika to Nosferatu', 'Irina: The Vampire Cosmonaut', 'Light Novel', '6396-tsukinolaika.jpg', 'In an alternate version of the 1960s, two global superpowers have emerged after a savage war: the Zirnitra Union and the United Kingdom of Arnack. East and West are locked in a fierce race to send the first crewed flight into outer space, leading the Union to develop a secret agenda: the Nosferatu Project, which aims to use vampires as spaceflight test subjects. Similar to humans but feared and reviled, vampires are assumed to make the perfect \"guinea pigs\" for such a dangerous task. Lev Leps, a Union soldier and aspiring cosmonaut, is tasked with overseeing vampire Irina Luminesk aka N44, who has been chosen for the operationâ€“and he can\'t quite detach his feelings from the vampire girl as planned. Faced with pressure and peril, will either of them manage to fly into the cosmos?', 'Makino Keisuke', 'Comedy,Drama,Fantasy,Romance,Sci-fi,Vampire', 7, '2016 to 2021', 'Finished', 50, 'This is a hard sci-fi series that while taking some extreme liberties in certain areas does follow the events of the space race with a remarkable degree of accuracy. If you are space buff who is well versed in events then you will get an extra kick out of seeing the similarities between the anime and the real Vostok space program. Saying that these accurate subtleties are not key to the plot so people less versed can still enjoy the story for what it is. It is a cute romance, but being set in such an underused setting allows it to distinguish itself from most romantic dramas out there. Do give it a shot if you want something different in your romances, or if you\'re itching for some early Cold War historical fiction.', 3, '2022-11-10 23:03:40'),
(47, 'admin', 'Jitsu wa Watashi wa', 'Actually, I Amâ€¦', 'Manga', '9223-jitsuwa.jpg', 'Meet Kuromine Asahi, \"the man who can\'t lie.\" On the way home, he learns an important secret. His crush, Shiragami Youko, is actually a vampire! Can Asahi actually keep her secret?\r\n\r\nIt\'s a fun, clumsy, one-of-a kind vampire romantic comedy!', 'Masuda Eiji', 'Comedy,Fantasy,Romance,School,Vampire', 22, '2013 to 2017', 'Finished', 30, 'Its main focus is ridiculous comedy, which relies a lot on funny reaction faces and creepy smiles. Every chapter gives reader meme-worthy material and many scenes can make readers facepalm while grinning due to their sheer absurdity. At the same time it actually tells a really interesting story with nicely integrated romance, some feels and even some plot twists that had proper foreshadowing.\r\n\r\nArt in this manga changed a lot during its course. In the early chapters it lookedâ€¦ pretty bad. Characters had weird faces. Luckily, It quickly picked up, characters started looking â€œsofterâ€ and more funny, so donâ€™t get discouraged by that. In the later chapters art is very good and there are a lot of beautiful scenes and effects.\r\n\r\nThe story is funny, it was crazy and it was beautiful. Itâ€™s way too long to read it all at once, but as long as you donâ€™t try doing that, Iâ€™m sure this manga can be enjoyed by most readers. I honestly recommend it to anyone who enjoys random and absurd comedy.', 3, '2022-11-10 23:15:48'),
(48, 'admin', 'Tomodachi Game', 'Friends Games', 'Manga', '9818-tomodachiGame.jpg', 'Katagiri Yuichi believes that friends are more important than money, but he also knows the hardships of not having enough funds. He works hard to save up in order to go on the high school trip, because he has promised his four best friends that they will all go together. However, after the class\'s money is all collected, it is stolen! Suspicion falls on two of Yuichi\'s friends, Sawaragi Shiho and Shibe Makoto.\r\n\r\nSoon afterward, the five of them are kidnapped, and wake up in a strange room with a character from a short-lived anime. Apparently, one of them has entered them into a \"friendship game\" in order to take care of their massive debt. But who was it, and why did they have such a debt? Could they have stolen the money from class to pay for entry into the game? Katagiri and his best friends will have to succeed in psychological games that will test or destroy their faith in one another.\r\n\r\n', 'Yamaguchi Mikoto', 'Drama,Mystery,Psychological,School', 21, '2013 to ?', 'Publishing', 45, 'The story simply just flows nicely and it makes you want to keep reading. The plot is tense enough to make you want to know more and even try to figure out the tricks yourself. Each strategy that the MC employs seems plausible, yet the utter nonchalance of his sometimes horrible actions give you a small sense of horror. In each arc there is a clear goal, a climax, and a very satisfying resolution. The story keeps you on the edge of your seat and makes you want to stay up all night to read it, it makes sure you would never want to drop it. Give it a try and you\'ll find yourself immersed in it in no time.', 4, '2022-11-10 23:44:53'),
(49, 'admin', 'Tokyo Ghoul:re', 'Tokyo Kushu:re', 'Manga', '3851-TokyoGhoulRE.jpg', 'Two years have passed since the CCG\'s raid on Anteiku. Although the atmosphere in Tokyo has changed drastically due to the increased influence of the CCG, ghouls continue to pose a problem as they have begun taking caution, especially the terrorist organization Aogiri Tree, who acknowledge the CCG\'s growing threat to their existence.\r\n\r\nThe creation of a special team, known as the Quinx Squad, may provide the CCG with the push they need to exterminate Tokyo\'s unwanted residents. As humans who have undergone surgery in order to make use of the special abilities of ghouls, they participate in operations to eradicate the dangerous creatures. The leader of this group, Haise Sasaki, is a half-ghoul, half-human who has been trained by famed special class investigator, Kishou Arima. However, there\'s more to this young man than meets the eye, as unknown memories claw at his mind, slowly reminding him of the person he used to be.', 'Ishida Sui', 'Action,Drama,Fantasy,Horror,Psychological,Thriller,Tragedy', 16, '2014 to 2018', 'Finished', 45, 'The story continues after some time when the first left of and things can be pretty confusing. New setting, new characters and goals. What happened? Its just part of the beauty of Tokyo Ghoul, everything is vague and is yet to be unveiled by you. Many more mysteries to uncover, motives to discuss and of course outcome to see. Gradually things built up one after another and everything starts to make more and more sense. Literally like a puzzle, you are collecting fragments for the final picture and this time the more you collect the more you have to do again afterwards. While it may not have as much symbolism as in the first one it is still one of a kind. The Tokyo Ghoul series has truly been a phenomenal story and I\'m so bittersweet that it\'s came to an end. I recommend this manga but while I do recommend it I also suggest that those who decide to read this manga take their time and focus when reading so they have a clear understanding of what\'s going on.', 5, '2022-11-19 00:30:12'),
(50, 'admin', 'Deaimon', 'Kyoto & Wagashi & Family', 'Manga', '3542-deaimon.jpg', 'Nagomu Irino returns to his Kyoto home for the first time in ten years when his father is hospitalized. Nagomu is eager to take over Ryokushou, the family\'s Japanese sweet shop, but he\'s instead asked to be a father figure to Itsuka Yukihira, the girl everyone calls the successor.', 'Asano Rin', 'Comedy,Slice of Life', 14, '2016 to ?', 'Publishing', 40, 'It\'s a story about a family-found scenario, blended with the delicacies of wagashi, or Japanese confectionary sweets, and it\'s an enjoyable read since it embodies both \"comfort within your own home\" and the genuine loving kindness of a well-knit family-oriented relationship. Despite this, I believe Deaimon to be a hidden gem that has been and continues to be overlooked and underrated significantly for a manga that, in all honesty, didn\'t receive the appreciation it truly deserves.', 3, '2022-11-12 20:01:33'),
(51, 'admin', '-Hitogatana-', '-ãƒ’ãƒˆã‚¬ã‚¿ãƒŠ-', 'Manga', '1527-hitogatana.jpg', 'In a world where it is possible to transfer human souls into objects, manned combat androids named \"Katana\" are used to commit heinous crimes and cause uncontrolled chaos. In response, the government creates the Anti-Katana Combat Division (AKCD) to maintain law and order. One member of the organization is Togusa, a human-Katana hybrid from the 8th Squad of the AKCD. Fighting against human and Katana enemies alike, Togusa must come to terms with his existence as a hybrid while unraveling the true nature and history of these androids.', 'Onigunsou', 'Action,Drama,Mecha,Psychological,Sci-fi', 11, '2009 to 2020', 'Finished', 30, 'Hitogana has an autonomous idea of what it is and what is wants to be. All a manga needs to be great is confidence, and in Hitogatana\'s case, there is so much confidence behind every page, so much style in its character designs, and so much energy in every fight sequence. The story itself is, to be fair, very arc-based and linear, but it\'s bound to catch you off guard at least once, and it\'s nothing weighed against a cast of palpable characters and the truly touching moments they can ignite. A lot of manga live and die going to great lengths to be different, but Onigunsou knows how to impress his/her readers without needing to bother. With the explosive popularity of ground-breaking battle shounens like Chainsaw Man and Kaiju 8, it\'s easy to view Hitogatana as an underachiever and write it off, but if \"Bleach with Cyborgs\" is simply too cool of a concept for you to pass up, then the path of life has led you to the right place.', 3, '2022-11-14 23:36:16'),
(52, 'admin', 'Kubo-san wa Mob wo Yurusanai', 'Kubo Won\'t Let Me Be Invisible', 'Manga', '1338-kubosan.jpg', 'High school student Junta Shiraishi has a simple goalâ€”to live a fulfilling youth. However, achieving this goal appears to be harder than expected, as everyone in his surroundings often fails to notice him due to his lack of presence. In fact, Shiraishi\'s lack of presence is so severe that people think his seat in class is always empty, and mistakenly assume that he often skips school. There is even a weird rumor spreading around in class, claiming that those who successfully spot Shiraishi will be blessed with good fortune for the day.\r\n\r\nSo far, the only person who notices his existence is Nagisa Kubo, the girl seated next to him. Unfortunately for him though, Kubo likes to tease him on a daily basis and often puts him into unprecedented and nerve-wracking situations. However, as Kubo\'s playful antics continue to involve the reluctant Shiraishi, he may soon discover that his youth might not be as boring as he initially thought.', 'Yukimori Nene', 'Comedy,Romance,School,Slice of Life', 10, '2019 to ?', 'Publishing', 40, 'To set it straight - it\'s nothing special. In fact, if you were expecting much of a story at all, this\'d probably be quite underwhelming. But it is, in essence, a slice of life, and if we\'re talking that much, then not only does its storyline suffice, it\'s even quite appropriate. Regardless, you can\'t help but agree it\'s pretty damn cute. It\'s the usual, a mix of flirting teasing and wholesomeness overall. Actually, the wholesomeness might be the story\'s strongest point, every chapter is either super cute or super wholesome. Story developments seem to happen at a reasonable pace so far, so that\'s a plus. If you\'re already thinking of reading it, give it shot, you\'ll almost surely like it.', 3, '2022-11-18 22:30:19'),
(53, 'admin', 'MoMo: The Blood Taker', 'MoMo -the blood taker-', 'Manga', '8387-MomoTheBloodTaker.jpg', 'In Tokyo, suspicious cases are occurring where the victims have all of their blood drained from them. Mikogami Keigo, a detective who also wants revenge for his lover who was killed 10 years ago, pursues the culprit, the \"Man with two faces.\" What is the identity of the silver-haired girl who observes him...?', 'Sugito Akira', 'Action,Comedy,Drama,Horror,Mystery,Psychological,Thriller', 9, '2019 to 2021', 'Finished', 45, 'Nothing new, nothing unique. This manga has your clichÃ© vampire killing demon slaying plot with a sad back story and a fueled by the taste of revenge. It has its own fair share of twist and turns, cliffhangers, and sudden plot twists however it does not contribute much more than that. The pacing of the manga was pretty fast.\r\n\r\nIt an edgy art vibe and the style fits very well with the story and genre helping it contribute in a helpful way. Lots of shading, textures, etc. Definitely one best art. Some parts of the manga made me feel sick from the sheer amount of blood. This however, did not stop me from enjoying the series. Its safe to say this manga isn\'t for the weakest of the heart.\r\n\r\nFor people who are not intimidated by blood, I would generally recommend it.', 3, '2022-11-18 22:45:03'),
(54, 'admin', 'Ajin', 'Ajin: Demi-Human', 'Manga', '1094-ajin.jpg', 'The story follows a high school student named Kei Nagai, who is caught in a traffic accident, dies, but immediately revives and learns he is not human, but an Ajin, a mysterious creature that cannot die. Scared, he runs away from humans but is helped by his friend Kai, who joins him in his flee from civilization. He then becomes involved in a conflict between human and Ajin and must choose a side.', 'Sakurai Gamon, Miura Tsuina', 'Action,Adventure,Drama,Horror,Mystery,Psychological,Sci-fi,Tragedy', 17, '2012 to 2021', 'Finished', 50, 'A psychological character-driven action manga with underlying elements of horror, Ajin is surely not a story for everyone. But for those with suitable leaning it may very well come nothing short of a masterpiece.\r\n\r\nAjin presents what would most likely happen in the current real world if people with superpowers were discovered. A huge struggle among different powerful entities to weaponize/exploit them for their own benefit. The pacing of the story is great, and the arcs don\'t feel repetitive at all. So unlike other manga, the story is constantly moving forward, and the events feel fresh in your mind.\r\n\r\nThe art style is also great. You can see clearly the evolution of the artist\'s style throughout the story, as it changes from a more cartoony, stereotypical character designs to a semi-realistic art style that gives the manga it\'s own separate identity. The 2 paged panels adds to giving the story a dramatic effect, which adds to the enjoyment of the reader. \r\n\r\nOverall, Ajin is a great read, and if you enjoy complex multifaceted characters and complex plots , then you\'ll likely love Ajin too.', 4, '2022-11-19 00:30:29'),
(55, 'admin', 'Yakusoku no Neverland', 'The Promised Neverland', 'Manga', '7284-ThePromisedNeverland.jpg', 'At Grace Field House, life couldn\'t be better for the orphans! Though they have no parents, together with the other kids and a kind \"Mama\" who cares for them, they form one big, happy family. No child is ever overlooked, especially since they are all adopted by the age of 12. Their daily lives involve rigorous tests, but afterwards, they are allowed to play outside.\r\n\r\nThere is only one rule they must obey: do not leave the orphanage. But one day, two top-scoring orphans, Emma and Norman, venture past the gate and unearth the horrifying reality behind their entire existence: they are all livestock, and their orphanage is a farm to cultivate food for a mysterious race of demons. With only a few months left to pull off an escape plan, the children must somehow change their predetermined fate.', 'Shirai Kaiu', 'Action,Adventure,Comedy,Drama,Horror,Mystery,Psychological,Slice of Life,Thriller', 20, '2016 to 2020', 'Finished', 40, 'It\'s a simplistic story that reels you in with a cute synopsis then haunts your nightmares for days.\r\nThe character designs are memorable and the series managed to show as much background detail as it did. The real standout are of course the demons. No demon looks the same and the way they are drawn is both horrifying as well as artistic.', 4, '2022-11-18 23:12:12'),
(56, 'admin', 'Kaijuu 8-gou', 'Kaiju No. 8', 'Manga', '7278-kaijuu8.jpg', 'Grotesque, Godzilla-like monsters called \"kaijuu\" have been appearing around Japan for many years. To combat these beasts, an elite military unit known as the Defense Corps risks their lives daily to protect civilians. Once a creature is killed, \"sweepers\"â€”working under the Professional Kaijuu Cleaner Corporationâ€”are left to dispose of its remains.\r\n\r\nKafka Hibino, a 32-year-old man, is unsatisfied with his job as a sweeper. From a young age, he has aspired to join the Defense Corps and kill kaijuus for a living. After a few failed attempts, however, he gave up on his dreams and resigned himself to the mediocrity that provided a decent paycheck. Nevertheless, when an ambitious, 18-year-old recruit named Leno Ichikawa joins his cleaning team, Kafka is once again reminded of his desire to join the military.\r\n\r\nFollowing a chain of unfortunate events and an interaction with the junior sweeper, Kafka encounters a parasite-type kaijuu that forces its way in through his mouthâ€”turning him into a humanoid monster. With his newfound powers, Kafka aims to give his lifelong dream a final try.', 'Matsumoto Naoya', 'Action,Comedy,Drama,Horror,Sci-fi,Supernatural', 8, '2020 to ?', 'Publishing', 50, 'First off story. The story is quite simple as a man who aspires to be part of the Defense Force where he is trying to be on par with his childhood friend with who he had made a promise with. The MC itself is not overpowered but instead very knowledegable. This could be sounding like your basic average shounen which, in big lines, it is. However the story does a perfect job to adapt certain aspects to make this \'\'average story\'\' more justice and interesting.\r\n\r\nOverall. it\'s a great series to read for your overall enjoyment. The story isn\'t as average as your usual shounen but it\'s quite more adapted to the point where you\'d still want to binge read it. The art is insane and the characters are very intriguing.', 4, '2022-11-18 23:23:14'),
(57, 'admin', 'Knight\'s & Magic', 'ãƒŠã‚¤ãƒ„ï¼†ãƒžã‚¸ãƒƒã‚¯', 'Light Novel', '3766-KnightsAndMagic.jpg', 'A mecha otaku is reincarnated into another world as Ernesti Echevalier, also known as Eru. In this world exists a huge humanoid weapons known as Silhouette Knights. Dreaming of piloting those robots, Eru, with childhood friends, Archid and Adeltrud Walter, aim to become Knight Runners, pilots of these Silhouette Knights.', 'Amazake No Hisago', 'Action,Fantasy,Isekai,Mecha', 11, '2013 to ?', 'Publishing', 50, 'A mecha otaku died then got revived as a cute looking child that looks like a girl but its actually a boy then he got used to the new place he lives because there are robots there and then started his dream to make one for himself and ride it. What makes the story interesting is how we actually see it happened. How we see the robots and the MC do the job among with other characters to build the newly improved robots and convinced the king. You may forget that it\'s an isekai for some reason and it\'s all focus on the production of weapons of mass destruction, Robots.', 3, '2022-11-18 23:41:53'),
(58, 'admin', 'All You Need Is Kill', 'Edge of Tomorrow', 'Manga', '7809-AllYouNeedIsKill.jpg', 'The story is told from the first person point of view of the protagonist Keiji Kiriya. Keiji is a new recruit in the United Defense Force, fighting against the mysterious creatures called \'Mimics\' which have laid siege to Earth. Keiji is killed on his first sortie, but through some inexplicable phenomenon wakes up having returned to the day before the battle, only to find himself caught in a time loop as his death and resurrection repeats time and time again. Keiji\'s skills as a soldier grows as he passes through the time loops trying to change his fate.', 'Sakurazaka Hiroshi', 'Action,Drama,Mecha,Psychological,Sci-fi', 2, '2014 to 2014', 'Finished', 35, 'Aside from the time loop aspect, the story isn\'t that special. I won\'t spoil anything, but expect a typical sci-fi mecha setting. The time loop is what makes things interesting. The main character slowly learns the rules of the loop, and the reader along with him. If you have a scientific mind, the implications of each rule will leave you fantasizing for at least fifty loops.\r\n\r\nI\'d like to mention the artwork. It\'s absolutely top notch. Every panel has a painstaking amount of detail, from the character designs, to the suits, to the environments. People who don\'t enjoy gore should avoid this, as the artwork is very... detailed.\r\n\r\nI\'d recommend this for people who like sci-fi or heart pounding action sequences. It wasn\'t that long of a read. If you find yourself with nothing to do, this manga won\'t leave you asking for your time back', 3, '2022-11-19 00:07:25'),
(59, 'admin', 'Sidonia no Kishi', 'Knights of Sidonia', 'Manga', '1204-KnightOfSidonia.jpg', 'A thousand years into the future, Earth has been destroyed by powerful aliens known as Gauna. Although mankind has fled into space, the giant spaceships they now call home are still constantly being targeted by the strange creatures. Piloting mobile weapon units called \"Gardes,\" humanity is able to take a stand against their adversaries by destroying their cores, preventing the monsters from regenerating their protective shell of placenta.\r\n\r\nWithin the vessel Sidonia, a boy named Nagate Tanikaze surfaces from its depths for the very first time in his life. With an incredible amount of time clocked into pilot simulators during his isolation deep within the ship, he quickly proves to be an indispensable asset to humanity\'s defense force. With the opportunity to pilot the legendary Garde Tsugumori, he fights to protect Sidonia from a grim demise.', 'Nihei Tsutomu', 'Action,Drama,Mecha,Sci-fi', 15, '2009 to 2015', 'Finished', 40, 'Though parts of the the plot might seem a bit formulaic at first, there were more than a few elements to it to keep reader hooked. The build-up to all of the battles was gradual (and logical) and during every battle a new twist was added, this prevented them from getting repetitive and dull. How humans came to settle on Sidonia and how they\'ve further evolved was also pretty interesting. But more significant is the inclusion of clever and slightly bent deconstructions of harem and slapstick comedy that will take you off guard. This is juxta-positioned against a now disturbingly real sense of danger and impending doom... death is not unusual in Tsutomu universes but this time it is framed to be more of an impact.\r\n\r\nKnights of Sidonia was really a rare gem for me as far as mecha manga go. It has a great and enjoyable story with enough plot twists to keep you surprised and the art suits it.', 4, '2022-11-19 00:02:21'),
(62, 'admin', 'Josee to Tora to Sakana-tachi', 'Josee, the Tiger and the Fish', 'Manga', '1875-joseetiger.jpg', 'Unable to get around without a wheelchair, a young woman named Josee leads a solitary, housebound existence. Her key to the outside world is her friend Tsuneo, a recent college graduate and her so-called caretaker. The titular story, Josee, the Tiger and the Fish, depicts the precarious, at times sensual relationship that blossoms between these two young people still learning what it means to be happy. This anthology also includes eight short tales centering on working women and their myriad loves and partings sure to stir the heart and soul.', 'Seiko Tanabe', 'Drama,Romance,Slice of Life', 1, '2020 to 2020', 'Publishing', 50, 'Josee to Tora\'s brief narrative always focuses on making his concept of difficulties explicit. We all have dreams, but we feel incapable of realizing them for whatever reason, and that inevitably, both protagonists stumble, and think about giving up, which they just don\'t do because they have each other as motivation.\r\n\r\nJosee is simple, clichÃ©, and it sends a message that we\'ve already gotten used to, but even so, the standardly melancholic narrative holds you, where you quickly empathize with the characters\' situation, and hope for the best in the end.\r\nIt\'s a novel where all the time it chooses to show the melancholy of the characters, at the same time it presents how they run away from it only by deepening their relationship.', 4, '2023-01-12 15:39:21'),
(68, 'admin', 'One Piece', 'ãƒ¯ãƒ³ãƒ”ãƒ¼ã‚¹', 'Manga', '3065-onepiece.jpg', 'Gol D. Roger, a man referred to as the \"Pirate King,\" is set to be executed by the World Government. But just before his demise, he confirms the existence of a great treasure, One Piece, located somewhere within the vast ocean known as the Grand Line. Announcing that One Piece can be claimed by anyone worthy enough to reach it, the Pirate King is executed and the Great Age of Pirates begins.\r\n\r\nTwenty-two years later, a young man by the name of Monkey D. Luffy is ready to embark on his own adventure, searching for One Piece and striving to become the new Pirate King. Armed with just a straw hat, a small boat, and an elastic body, he sets out on a fantastic journey to gather his own crew and a worthy ship that will take them across the Grand Line to claim the greatest status on the high seas.', 'Oda Eiichiro', 'Action,Adventure,Comedy,Fantasy', 5, '1997', 'Finished', 40, 'When looking at one piece objectively it is just a terribly long Shonen manga with characters with not much development. but the more you read it the more complete it becomes. Does it have the have the best written characters, no. Does it have the most in depth story, no. Is it still the greatest piece of fiction ever released, yes. One Piece, although they are not that deep have some of the most enduring and entertaining characters ever. Oda manages to make you hate some characters with such a passion and makes you love others just as, if not stronger. The writing is perfect and although at some points it may be boring when you catch up you will wish it was 10 times longer. One piece to me managed to give me the most highs I\'ve ever felt while watching/reading it. when a plot twist arrives or when a moment is gas it never fails to disappoint.', 5, '2023-01-12 15:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int NOT NULL AUTO_INCREMENT,
  `description` varchar(1000) NOT NULL,
  `news_image` varchar(255) NOT NULL,
  `news_date` datetime NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `description`, `news_image`, `news_date`) VALUES
(10, 'Aliens Area ends today in MANGA Plus! Thanks to Fusai Naba for this exciting, other-worldly thriller!', '8920-FfwyVe6X0AEgOWV.jpg', '2022-10-24 01:43:05'),
(9, 'Harahara-sensei by Yanagi Takakuchi will end with Chapter 32 next week in Shonen Jump+ App.', '4911-Haraharasensei.jpg', '2022-09-26 00:05:47'),
(8, 'Wataru Mitogawa will serialize a new work titled \'Chieri no Koi wa 8 metre\' starting October 2nd on Shonen Jump+ App.', '', '2022-09-22 00:07:02'),
(7, 'Kaiju No. 8 is getting an official novel titled \'Kaiju No. 8 Close-Up! 3rd Division\', including four new stories about the main characters.\r\n\r\nIllustrated by Naoya Matsumoto and written by Ando Keiji, it\'s set to be released on November 4th.', '', '2022-09-16 00:09:57'),
(6, 'Earthchild by Hideo Shinkai has officially ended this week with Chapter 27 in Weekly Shonen Jump Issue #40.', '9331-Fb0eqtbWIAIaUWS.jpg', '2022-08-31 00:14:07'),
(5, 'Doron Dororon ends today! Thank you, Gen Osuka, for this phenomenal exorcist ride!', '1502-FbQ6SN0XoAMwACm.jpg', '2022-08-29 00:16:57'),
(4, 'Mission: Yozakura Family has reached 1.400.000 copies in circulation.', '3831-FbJq5bsVEAAO0Bd.jpg', '2022-08-27 00:18:34'),
(40, 'NARUTOP99 Worldwide Character Popularity Poll Provisional Results.\r\n\r\nThe poll has already surpassed 1 million votes.', '4705-FkpLUSLXwAMj9Kt.jpg', '2022-12-23 15:33:41'),
(41, 'HEART GEAR by Tsuyoshi Takaki is going on an indefinite break once again after Chapter 39 at Shonen Jump+ App.\r\n\r\nNo return date has been announced, and any update will be given as soon as the serialization resumes.', '3671-Screenshot_20230110_033622.png', '2022-12-20 15:36:35'),
(33, 'Kubo Won\'t Let Me Be Invisible TV Anime New Key Visual.\r\n\r\nSeries will start broadcasting in January 2023.', '8490-FhRZOtjWIAAIBtH.jpg', '2022-11-11 12:39:54'),
(29, '\"Kaguya-sama\" Author, Aka Akasaka announces his RETIREMENT as a Manga Artist.\r\n\r\nFurther tells that he would like to focus on creating stories & just remain as an original author.', '9350-FgrSA3-XwAIHJf1.png', '2022-11-04 22:29:52'),
(34, 'ONE PIECE will be holding a Special Exhibition titled \'Road to EMPEROR\' in Jump Festa 2023.\r\n\r\nThis corner will feature different battle scenes from Luffy\'s enemies until the conclusion of Wano Arc.', '2445-Fhg6YzHXoAABTuT.jpg', '2022-11-14 12:43:55'),
(35, 'Masanori Morita, mangaka of ROOKIES and Rokudenashi Blues, has confirmed to have handed, \'for the fourth time in his life as a mangaka, the first chapter draft of a new series\'.\r\n\r\nNothing else is yet known regarding this upcoming potential serialization.', '', '2022-11-10 12:46:08'),
(36, 'It appears Black Clover is on a sudden break this week in Weekly Shonen Jump Issue #50. \r\n\r\nAdding its upcoming break next week, the series will be absent for 2 weeks until Weekly Shonen Jump Issue #52.', '', '2022-11-09 12:47:45'),
(37, 'Oshi no Ko by Aka Akasaka and Yokoyari Mengo has 4.000.000 copies in circulation with 9 volumes. \r\n\r\nSeries is being published in Young Jump and Shonen Jump+ App.', '6145-Fg9662oXwAIxaG3.jpg', '2022-11-17 12:48:21'),
(38, 'Tsuyoshi Takaki confirms that HEART GEAR will postpone the release of Volume 5 and may enter hiatus once again due to his poor health condition.\r\n\r\nHEART GEAR will still release chapters already drawn and finished before taking a break in Shonen Jump+ App.', '', '2022-10-25 12:52:48'),
(42, 'Captain Tsubasa: Rising Sun by Yoichi Takahashi will be starting its Final Arc \'Rising Sun THE FINAL\' in upcoming Captain Tsubasa Magazine Issue #16, out in April 2023.', '9026-cptnsubasanews.png', '2023-01-12 11:25:30'),
(43, 'Shinji Mizushima, one of Japan\'s Most Profilic Manga Artist, Dies at 82.', '4276-authordied.png', '2023-01-12 15:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `order_num` varchar(255) NOT NULL,
  `mangaln_id` int NOT NULL,
  `cover` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alternative_title` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` double NOT NULL,
  `discount` int NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL,
  `address_id` int NOT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_num`, `mangaln_id`, `cover`, `title`, `alternative_title`, `volume`, `price`, `quantity`, `subtotal`, `discount`, `payment_method`, `order_date`, `address_id`, `username`) VALUES
(1, 'ABA1E0C0DB29', 17, '4097-TheEminenceinShadow.jpg', 'Kage no Jitsuryokusha ni Naritakute!', 'The Eminence in Shadow', 'Volume 1', 44, 1, 44, 0, 'Online Banking', '2022-10-22 22:24:31', 12, 'nikasyraf'),
(55, '2FE2B326D415', 41, '2834-horimiya.jpg', 'Horimiya', 'Hori-san and Miyamura-kun', 'Volume 1', 45, 1, 45, 14, 'Online Banking', '2023-01-11 11:04:32', 5, 'udinrhman'),
(5, '4DB09EFE2073', 38, '1066-assassinstatus.jpg', 'Assassin de Aru Ore no Sutetasu ga Yuusha Yori mo Akiraka ni Tsuyoi Nodaga', 'My Status as an Assassin Obviously Exceeds the Heroâ€™s', 'Volume 1', 40, 1, 40, 0, 'Cash on Delivery', '2022-11-10 17:17:28', 5, 'udinrhman'),
(53, 'DCC69EEBC494', 1, '7047-VanitasNoCarte.jpg', 'Vanitas no Carte', 'The Case Study of Vanitas', 'Volume 1', 40, 1, 40, 18, 'Online Banking', '2023-01-10 10:21:10', 15, 'farah'),
(7, 'C73ED3BFDB32', 2, '5654-TokyoGhoul.jpg', 'Tokyo Ghoul', 'Tokyo Kushu', 'Volume 1', 44, 1, 44, 0, 'Online Banking', '2022-11-17 01:29:54', 5, 'udinrhman'),
(8, 'C73ED3BFDB32', 25, '8167-YozakuraFamily.jpg', 'Yozakura-san Chi no Daisakusen', 'Mission: Yozakura Family', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2022-11-17 01:29:54', 5, 'udinrhman'),
(9, '4939CF273BE6', 17, '4097-TheEminenceinShadow.jpg', 'Kage no Jitsuryokusha ni Naritakute!', 'The Eminence in Shadow', 'Volume 1', 44, 1, 44, 0, 'Online Banking', '2022-11-30 14:38:06', 1, 'udinrhman'),
(10, 'FB29868B21F6', 26, '4512-SpyClassroom.jpg', 'Spy Kyoushitsu', 'Spy Classroom', 'Volume 1', 50, 1, 50, 0, 'Online Banking', '2022-11-30 14:44:46', 5, 'udinrhman'),
(11, '11550CF6052B', 34, '6575-SeraphOfTheEnd.jpg', 'Owari no Seraph', 'Seraph of the End: Vampire Reign', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2022-11-30 14:46:19', 5, 'udinrhman'),
(13, 'FFA20B5DF46B', 56, '7278-kaijuu8.jpg', 'Kaijuu 8-gou', 'Kaiju No. 8', 'Volume 1', 50, 1, 50, 0, 'Online Banking', '2022-11-30 15:15:25', 5, 'udinrhman'),
(14, 'FDF445F971D8', 59, '1204-KnightOfSidonia.jpg', 'Sidonia no Kishi', 'Knights of Sidonia', 'Volume 1', 40, 1, 40, 0, 'Online Banking', '2022-11-30 15:16:52', 5, 'udinrhman'),
(15, 'F3EABD17F53D', 1, '7047-VanitasNoCarte.jpg', 'Vanitas no Carte', 'The Case Study of Vanitas', 'Volume 1', 40, 1, 40, 9, 'Online Banking', '2022-11-30 15:19:23', 5, 'udinrhman'),
(16, 'F3EABD17F53D', 18, '6718-86.jpg', '86', '86â€”Eighty-Six', 'Volume 1', 44, 1, 44, 9, 'Online Banking', '2022-11-30 15:19:23', 5, 'udinrhman'),
(17, 'D1A5B12F9342', 1, '7047-VanitasNoCarte.jpg', 'Vanitas no Carte', 'The Case Study of Vanitas', 'Volume 1', 40, 1, 40, 0, 'Online Banking', '2022-12-30 22:13:15', 11, 'syawal'),
(18, 'ECA785F5BA10', 2, '5654-TokyoGhoul.jpg', 'Tokyo Ghoul', 'Tokyo Kushu', 'Volume 1', 44, 1, 44, 0, 'Online Banking', '2022-12-30 22:29:46', 11, 'syawal'),
(19, 'ECA785F5BA10', 49, '3851-TokyoGhoulRE.jpg', 'Tokyo Ghoul:re', 'Tokyo Kushu:re', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2022-12-30 22:29:46', 11, 'syawal'),
(20, 'ECA785F5BA10', 3, '2933-dgrayman.jpg', 'D.Gray-man', 'D.Gray-man', 'Volume 1', 44, 1, 44, 0, 'Online Banking', '2022-12-30 22:29:46', 11, 'syawal'),
(21, '23A332F245A3', 52, '1338-kubosan.jpg', 'Kubo-san wa Mob wo Yurusanai', 'Kubo Won\'t Let Me Be Invisible', 'Volume 1', 40, 1, 40, 0, 'Online Banking', '2022-12-30 22:37:08', 12, 'nikasyraf'),
(22, '23A332F245A3', 41, '2834-horimiya.jpg', 'Horimiya', 'Hori-san and Miyamura-kun', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2022-12-30 22:37:08', 12, 'nikasyraf'),
(23, '23A332F245A3', 27, '3259-ShikimoriNotJustaACutie.jpg', 'Kawaii dake ja Nai Shikimori-san', 'Shikimori\'s Not Just a Cutie', 'Volume 1', 40, 1, 40, 0, 'Online Banking', '2022-12-30 22:37:08', 12, 'nikasyraf'),
(24, '23A332F245A3', 42, '2421-kuzumikun.jpg', 'Kuzumi-kun, Kuuki Yometemasu ka?', 'Kuzumi-kun, Can\'t You Read the Room?', 'Volume 1', 40, 1, 40, 0, 'Online Banking', '2022-12-30 22:37:08', 12, 'nikasyraf'),
(25, '9A0B70B5FCA5', 40, '6527-AngelNextDoor.jpeg', 'Otonari no Tenshi-sama ni Itsunomanika Dame Ningen ni Sareteita Ken', 'The Angel Next Door Spoils Me Rotten', 'Volume 1', 45, 1, 45, 0, 'Debit/Credit Card', '2023-01-01 01:33:26', 13, 'muhdhakim'),
(26, '9A0B70B5FCA5', 18, '6718-86.jpg', '86', '86â€”Eighty-Six', 'Volume 1', 44, 1, 44, 0, 'Debit/Credit Card', '2023-01-01 01:33:26', 13, 'muhdhakim'),
(27, '9A0B70B5FCA5', 25, '8167-YozakuraFamily.jpg', 'Yozakura-san Chi no Daisakusen', 'Mission: Yozakura Family', 'Volume 1', 45, 1, 45, 0, 'Debit/Credit Card', '2023-01-01 01:33:26', 13, 'muhdhakim'),
(28, '9A0B70B5FCA5', 17, '4097-TheEminenceinShadow.jpg', 'Kage no Jitsuryokusha ni Naritakute!', 'The Eminence in Shadow', 'Volume 1', 44, 1, 44, 0, 'Debit/Credit Card', '2023-01-01 01:33:26', 13, 'muhdhakim'),
(29, '9A0B70B5FCA5', 26, '4512-SpyClassroom.jpg', 'Spy Kyoushitsu', 'Spy Classroom', 'Volume 1', 50, 1, 50, 0, 'Debit/Credit Card', '2023-01-01 01:33:26', 13, 'muhdhakim'),
(52, 'CE28789107BE', 34, '6575-SeraphOfTheEnd.jpg', 'Owari no Seraph', 'Seraph of the End: Vampire Reign', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2023-01-10 10:18:18', 15, 'farah'),
(56, '4102EA94F356', 41, '2834-horimiya.jpg', 'Horimiya', 'Hori-san and Miyamura-kun', 'Volume 1', 45, 1, 45, 0, 'Online Banking', '2023-01-11 11:10:05', 15, 'farah'),
(57, '4102EA94F356', 41, '2834-horimiya.jpg', 'Horimiya', 'Hori-san and Miyamura-kun', 'Volume 2', 45, 1, 45, 0, 'Online Banking', '2023-01-11 11:10:05', 15, 'farah'),
(65, '1AF47EDE4368', 34, '6575-SeraphOfTheEnd.jpg', 'Owari no Seraph', 'Seraph of the End: Vampire Reign', 'Volume 1', 45, 2, 90, 19, 'Online Banking', '2023-01-12 15:31:40', 5, 'udinrhman');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE IF NOT EXISTS `reply` (
  `reply_id` int NOT NULL AUTO_INCREMENT,
  `parent` int NOT NULL,
  `mangaln_id` int NOT NULL,
  `username` varchar(25) NOT NULL,
  `user_comment` varchar(500) NOT NULL,
  `reply_date` datetime NOT NULL,
  PRIMARY KEY (`reply_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reply`
--

INSERT INTO `reply` (`reply_id`, `parent`, `mangaln_id`, `username`, `user_comment`, `reply_date`) VALUES
(7, 10, 1, 'adamzafran', 'Yeah, it feel a lot more natural and works well with the characters right now. Being serious all the time can make it feel stiff and banking on comedy too much takes away from the story, feels like they\'ve got a really solid balance here!', '2023-01-10 13:28:55'),
(8, 10, 1, 'halibanania', 'I agree. Not to mention those humorous moments are integral to the character\'s personalities. Comedy adds spice to the narrative but also gives extra characterization without forcing the plot to go faster.', '2023-01-10 13:40:34'),
(10, 12, 34, 'nikasyraf', 'Yea .. but with Eren Jaeger from Attack on Titan as the main characther.', '2023-01-10 16:26:14'),
(11, 13, 41, 'udinrhman', 'Yeah, totally agree with you!', '2023-01-11 11:44:00'),
(12, 13, 41, '', 'saDSASD', '2023-01-11 18:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `stock_id` int NOT NULL AUTO_INCREMENT,
  `mangaln_id` int NOT NULL,
  `volume` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`stock_id`)
) ENGINE=MyISAM AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `mangaln_id`, `volume`, `stock`) VALUES
(1, 38, 'Volume 1', 10),
(8, 38, 'Volume 3', 10),
(3, 38, 'Volume 2', 10),
(99, 60, 'Volume 3', 10),
(100, 37, 'Volume 1', 10),
(97, 60, 'Volume 1', 10),
(12, 40, 'Volume 1', 10),
(13, 40, 'Volume 2', 10),
(14, 40, 'Volume 3', 10),
(15, 40, 'Volume 4', 10),
(16, 40, 'Volume 5', 10),
(17, 40, 'Volume 6', 10),
(18, 41, 'Volume 1', 0),
(19, 41, 'Volume 2', 0),
(20, 41, 'Volume 3', 0),
(21, 41, 'Volume 4', 10),
(180, 62, 'Volume 1', 10),
(181, 62, 'Volume 2', 10),
(22, 42, 'Volume 1', 10),
(23, 42, 'Volume 2', 10),
(24, 42, 'Volume 3', 10),
(25, 43, 'Volume 1', 10),
(26, 43, 'Volume 2', 10),
(27, 43, 'Volume 3', 10),
(28, 44, 'Volume 1', 10),
(29, 44, 'Volume 2', 10),
(30, 44, 'Volume 3', 10),
(31, 45, 'Volume 1', 10),
(32, 45, 'Volume 2', 10),
(33, 46, 'Volume 1', 10),
(34, 46, 'Volume 2', 10),
(35, 46, 'Volume 3', 10),
(36, 47, 'Volume 1', 10),
(37, 47, 'Volume 2', 10),
(38, 47, 'Volume 3', 10),
(39, 47, 'Volume 4', 10),
(40, 48, 'Volume 1', 10),
(41, 48, 'Volume 2', 10),
(42, 2, 'Volume 1', 10),
(43, 2, 'Volume 2', 10),
(44, 2, 'Volume 3', 10),
(45, 49, 'Volume 1', 10),
(46, 49, 'Volume 2', 10),
(47, 49, 'Volume 3', 10),
(48, 49, 'Volume 4', 10),
(49, 50, 'Volume 1', 10),
(50, 50, 'Volume 2', 10),
(51, 50, 'Volume 3', 10),
(52, 51, 'Volume 1', 10),
(53, 51, 'Volume 2', 10),
(54, 51, 'Volume 3', 10),
(55, 52, 'Volume 1', 10),
(56, 52, 'Volume 2', 10),
(57, 52, 'Volume 3', 10),
(58, 53, 'Volume 1', 10),
(59, 53, 'Volume 2', 10),
(60, 53, 'Volume 3', 10),
(61, 53, 'Volume 4', 10),
(62, 53, 'Volume 5', 10),
(63, 53, 'Volume 6', 10),
(64, 53, 'Volume 7', 10),
(65, 53, 'Volume 8', 10),
(66, 53, 'Volume 9', 10),
(67, 54, 'Volume 1', 10),
(68, 54, 'Volume 2', 10),
(69, 54, 'Volume 3', 10),
(70, 54, 'Volume 4', 10),
(71, 55, 'Volume 1', 10),
(72, 55, 'Volume 2', 10),
(73, 55, 'Volume 3', 10),
(74, 55, 'Volume 4', 10),
(75, 56, 'Volume 1', 10),
(76, 56, 'Volume 2', 10),
(77, 56, 'Volume 3', 10),
(78, 56, 'Volume 4', 10),
(79, 56, 'Volume 5', 10),
(80, 56, 'Volume 6', 10),
(81, 56, 'Volume 7', 10),
(82, 56, 'Volume 8', 10),
(83, 57, 'Volume 1', 10),
(84, 57, 'Volume 2', 10),
(85, 57, 'Volume 3', 10),
(86, 57, 'Volume 4', 10),
(87, 58, 'Volume 1', 10),
(88, 58, 'Volume 2', 10),
(89, 59, 'Volume 1', 10),
(90, 59, 'Volume 2', 10),
(91, 59, 'Volume 3', 10),
(92, 59, 'Volume 4', 10),
(93, 59, 'Volume 5', 10),
(98, 60, 'Volume 2', 10),
(101, 37, 'Volume 2', 10),
(102, 37, 'Volume 3', 10),
(103, 36, 'Volume 1', 10),
(104, 36, 'Volume 2', 10),
(105, 36, 'Volume 3', 10),
(106, 35, 'Volume 1', 10),
(107, 35, 'Volume 2', 10),
(108, 35, 'Volume 3', 10),
(109, 34, 'Volume 1', 8),
(110, 34, 'Volume 2', 5),
(182, 68, 'Volume 1', 10),
(113, 33, 'Volume 1', 10),
(178, 33, 'Volume 3', 0),
(176, 33, 'Volume 2', 0),
(116, 32, 'Volume 1', 10),
(117, 32, 'Volume 2', 10),
(118, 32, 'Volume 3', 10),
(119, 31, 'Volume 1', 10),
(120, 31, 'Volume 2', 10),
(121, 31, 'Volume 3', 10),
(122, 30, 'Volume 1', 10),
(123, 30, 'Volume 2', 10),
(124, 30, 'Volume 3', 10),
(125, 29, 'Volume 1', 10),
(126, 29, 'Volume 2', 10),
(127, 29, 'Volume 3', 10),
(128, 28, 'Volume 1', 10),
(129, 28, 'Volume 2', 10),
(130, 28, 'Volume 3', 10),
(131, 27, 'Volume 1', 10),
(132, 27, 'Volume 2', 10),
(133, 27, 'Volume 3', 10),
(134, 26, 'Volume 1', 10),
(135, 26, 'Volume 2', 10),
(136, 26, 'Volume 3', 10),
(137, 25, 'Volume 1', 10),
(138, 25, 'Volume 2', 10),
(139, 25, 'Volume 3', 10),
(140, 24, 'Volume 1', 10),
(141, 24, 'Volume 2', 10),
(142, 24, 'Volume 3', 10),
(143, 23, 'Volume 1', 9),
(144, 23, 'Volume 2', 10),
(145, 23, 'Volume 3', 10),
(146, 22, 'Volume 1', 10),
(147, 22, 'Volume 2', 10),
(148, 22, 'Volume 3', 10),
(149, 21, 'Volume 1', 10),
(150, 21, 'Volume 2', 10),
(151, 21, 'Volume 3', 10),
(152, 20, 'Volume 1', 10),
(153, 20, 'Volume 2', 10),
(154, 20, 'Volume 3', 10),
(155, 19, 'Volume 1', 10),
(156, 19, 'Volume 2', 10),
(157, 19, 'Volume 3', 10),
(158, 18, 'Volume 1', 10),
(159, 18, 'Volume 2', 10),
(160, 18, 'Volume 3', 10),
(161, 17, 'Volume 1', 10),
(162, 17, 'Volume 2', 10),
(163, 17, 'Volume 3', 10),
(164, 5, 'Volume 1', 10),
(165, 5, 'Volume 2', 10),
(166, 5, 'Volume 3', 10),
(167, 4, 'Volume 1', 10),
(168, 4, 'Volume 2', 10),
(169, 4, 'Volume 3', 10),
(170, 3, 'Volume 1', 10),
(171, 3, 'Volume 2', 10),
(172, 3, 'Volume 3', 10),
(173, 1, 'Volume 1', 10),
(174, 1, 'Volume 2', 10),
(175, 1, 'Volume 3', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(25) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_type` varchar(5) NOT NULL,
  `yomi_tokens` int NOT NULL,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `user_fullname`, `user_email`, `user_password`, `bio`, `user_image`, `user_type`, `yomi_tokens`, `register_date`) VALUES
('halibanania', 'Aina Nabilah', 'ainanabilah@gmail.com', '$2y$10$KWNSN0n7hAvnhUIBpPF71umgwlX2VVmEKAzDfMlK5ajD4CQVBAIrS', 'Welcome to my profile!', 'upload/1347-eto.jpg', 'user', 100, '2022-12-13 13:10:28'),
('shinoa', 'Shinoa Hiiragi', 'shinoahiragi@gmail.com', '$2y$10$p/oLjAsdBOmNfAAzIPiGTeQi.DOb.zrs2ywnpGpcIh89u/JTMIMcu', 'This is my profile!', 'upload/9304-shinoa.jpg', 'user', 0, '2022-09-24 23:22:41'),
('admin', 'Admin', '', '$2y$10$WFC1vhavRAjat6S/lcvzsOjEHHjQF0O8d/3yo35gcbTW.9rVyTp/m', '', 'image/admin.jpg', 'admin', 0, '2022-09-20 23:22:41'),
('udinrhman', 'Abdullah', 'udinrhman@gmail.com', '$2y$10$LMjX5Otg/HWVUMXTa0Y6IeiW.9SgSQ.LBAfMwA9jRxCsfN/4uHA/a', 'Welcome to my profile!', 'upload/3634-sasaki.jpg', 'user', 10, '2022-09-23 23:22:41'),
('syawal', 'Muhammad Syawal', 'muhdsyawal0065@gmail.com', '$2y$10$v.5QCuB0MvsTGnk2L96b8.mkQzdv4y.wcB48mFl9y4w2XyQBWDp1m', 'Welcome to my profile!', 'upload/7941-1asDc.jpg', 'user', 0, '2022-12-30 22:25:53'),
('nikasyraf', 'Nik Muhd Asyraf', 'nikasyraf454@gmail.com', '$2y$10$wzh3x3D6X7wWoHtH9s395.gSE7xq15OWRK4QPpToiTLV78Z9LwV7e', 'Welcome to my profile!', 'upload/1044-ef.jpg', 'user', 240, '2022-12-30 22:32:42'),
('muhdhakim', 'Muhammad Hakim', 'mdhakimpakhari@gmail.com', '$2y$10$bbU45Nu1Fk081RMXnDg2mOsBAZm7wCz2ODGQNjXEUV6hV/yhTgabC', 'Welcome to my profile!', 'upload/3093-suzuya.jpg', 'user', 0, '2023-01-01 01:24:40'),
('adamzafran', 'Adam Zafran', 'adamzafran@gmail.com', '$2y$10$PH437g4KN4pK4.UzxbK1jeB5R38kjS0nK6ST8ADFd9MSVPB/MeleO', 'Welcome to my profile!', 'upload/7598-kneki.jpg', 'user', 0, '2023-01-02 14:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `wishlist_id` int NOT NULL AUTO_INCREMENT,
  `mangaln_id` int NOT NULL,
  `username` varchar(25) NOT NULL,
  PRIMARY KEY (`wishlist_id`)
) ENGINE=MyISAM AUTO_INCREMENT=258 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `mangaln_id`, `username`) VALUES
(257, 41, 'udinrhman'),
(251, 24, 'farah'),
(250, 32, 'farah'),
(249, 25, 'farah'),
(248, 26, 'farah'),
(247, 34, 'farah'),
(246, 1, 'farah'),
(234, 27, 'udinrhman'),
(233, 40, 'udinrhman'),
(237, 4, 'udinrhman'),
(226, 38, 'shinoa'),
(227, 5, 'shinoa'),
(228, 23, 'shinoa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mangaln`
--
ALTER TABLE `mangaln` ADD FULLTEXT KEY `search` (`title`,`alternative_title`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders` ADD FULLTEXT KEY `search` (`order_num`,`title`,`alternative_title`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
