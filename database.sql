-- JWR assignment database; -- 1904362 --

DROP TABLE IF EXISTS `bookmarks`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `games`;
DROP TABLE IF EXISTS `genres`;
DROP TABLE IF EXISTS `supportticket`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `jobapplications`;
DROP TABLE IF EXISTS `jobs`;



CREATE TABLE `users` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(40),
    pass VARCHAR(255),
    salt VARCHAR(255),
    is_admin BOOLEAN
);

CREATE TABLE `genres` (
    id varchar(3) NOT NULL PRIMARY KEY,
    title VARCHAR(50)
);

CREATE TABLE `games` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    image VARCHAR(255),
    genre varchar(3) NOT NULL,
    rating INT,
    FOREIGN KEY (genre) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE `bookmarks` (
    user_id INT,
    game_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

CREATE TABLE `reviews` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    game_id int,
    rating INT,
    title VARCHAR(150),
    review TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

CREATE TABLE `supportticket` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unameid INT, 
    email VARCHAR(150),
    subject VARCHAR(255),
    message VARCHAR(255) NOT NULL,
    FOREIGN KEY (unameid) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE `jobs` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    salary VARCHAR(7),
    description varchar(8000)
);

CREATE TABLE `jobapplications` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jobname VARCHAR(255),
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    why varchar(8000)
);


INSERT INTO `genres` VALUES ("str", "Strategy");
INSERT INTO `genres` VALUES ("rpg", "Role-Playing Game");
INSERT INTO `genres` VALUES ("fps", "First Person Shooter");
INSERT INTO `genres` VALUES ("sim", "Simulation Game");
INSERT INTO `genres` VALUES ("???", "Other");

-- game list (yes, I'm including ones with strange letters on purpose)
INSERT INTO `games` VALUES (NULL, "Sid Meier's Civilization V: Brave New World", "", "str", 85); -- 8 Jul 2013
INSERT INTO `games` VALUES (NULL, "Crusader Kings II", "", "str", 82); -- 14 feb 2012
INSERT INTO `games` VALUES (NULL, "Warcraft III: Reforged ", "", "str", 60); -- 28 jan 2020

INSERT INTO `games` VALUES (NULL, "Else Heart.Break()", "", "rpg", 79); -- Sep 24 2015
INSERT INTO `games` VALUES (NULL, "Shadowrun: Dragonfall - Director's Cut", "", "rpg", 87); -- 18 sep 2014
INSERT INTO `games` VALUES (NULL, "Stardew Valley", "", "rpg", 89); -- 26 feb 2016 (it has the RPG tag on steam, it counts...)
INSERT INTO `games` VALUES (NULL, "Disco Elysium", "", "rpg", 91); -- 15 oct 2019

INSERT INTO `games` VALUES (NULL, "RimWorld", "", "sim", 87); -- 17 oct 2018
INSERT INTO `games` VALUES (NULL, "Tom Clancy's Rainbow Six® Siege", "", "fps", 0); -- 1 dec 2015, metacritic score wasn't on steam page
INSERT INTO `games` VALUES (NULL, "Euro Truck Simulator 2", "", "sim", 79); -- 18 oct 2012
INSERT INTO `games` VALUES (NULL, "Farming Simulator 19", "", "sim", 73); -- 19 Nov, 2018
INSERT INTO `games` VALUES (NULL, "Train Simulator 2020", "", "sim", 0); -- 12 jul 2009 *shrugs at release date on steam...*

INSERT INTO `games` VALUES (NULL, "Project Zomboid", "", "rpg", 87); -- 8 nov 2013
INSERT INTO `games` VALUES (NULL, "Shadowrun Returns", "", "rpg", 76); -- 25 july 2013
INSERT INTO `games` VALUES (NULL, "Shadowrun: Hong Kong - Extended Edition", "", "rpg", 81); -- 20 aug 2015

INSERT INTO `games` VALUES (NULL, "Cave Story+", "", "???", 81); -- 22 nov 2011
INSERT INTO `games` VALUES (NULL, "Sorcery! Parts 1 & 2", "", "???", 69); -- 2 feb 2016
INSERT INTO `games` VALUES (NULL, "Dwarf Fortress", "", "???", 0); -- 'time is subjective' isn't a valid release date...

-- users
-- salts should be random, using strings here, algorithm is sha1( $pass . $salt ); not secure, but it's an assignment.
INSERT INTO `users` VALUES (NULL, "jwalto", "244cad413fa94db1c686ff5bfc6777241ceaa3ea", "abc123", 1); -- password42
INSERT INTO `bookmarks` VALUES (1, 3);
INSERT INTO `bookmarks` VALUES (1, 2);

INSERT INTO `users` VALUES (NULL, "pwillic", "38bf8a5df0a227b697045c1b29a25a759e391f9b", "java123", 0); -- hanabi
INSERT INTO `bookmarks` VALUES (2, 3);
INSERT INTO `bookmarks` VALUES (2, 4);
INSERT INTO `bookmarks` VALUES (2, 5);

INSERT INTO `users` VALUES (NULL, "rpgs", "ba494cde63bd5d092e916b4083e27cda7c306d43", "html42", 0); -- rpgsftw
INSERT INTO `bookmarks` VALUES (3, 4);
INSERT INTO `bookmarks` VALUES (3, 5);
INSERT INTO `bookmarks` VALUES (3, 6);
INSERT INTO `bookmarks` VALUES (3, 7);
INSERT INTO `bookmarks` VALUES (3, 13);

INSERT INTO `users` VALUES (NULL, "sims", "c65e822545b8596c484112ac62a9194c6043c724", "eadlc", 0); -- simsftw
INSERT INTO `bookmarks` VALUES (4, 8);
INSERT INTO `bookmarks` VALUES (4, 10);
INSERT INTO `bookmarks` VALUES (4, 11);
INSERT INTO `bookmarks` VALUES (4, 12);

UPDATE games SET image = 'assets/images/id=1/frontPage.jpg assets/images/id=1/img1.jpg assets/images/id=1/img2.jpg assets/images/id=1/img3.jpg assets/images/id=1/img4.jpg' where id = 1; 
UPDATE games SET image = 'assets/images/id=2/frontPage.jpg assets/images/id=2/img1.jpg assets/images/id=2/img2.jpg assets/images/id=2/img3.jpg assets/images/id=2/img4.jpg' where id = 2; 
UPDATE games SET image = 'assets/images/id=3/frontPage.jpg assets/images/id=3/img1.jpg assets/images/id=3/img2.jpg assets/images/id=3/img3.jpg assets/images/id=3/img4.jpg' where id = 3; 
UPDATE games SET image = 'assets/images/id=4/frontPage.jpg assets/images/id=4/img1.jpg assets/images/id=4/img2.jpg assets/images/id=4/img3.jpg assets/images/id=4/img4.jpg' where id = 4; 
UPDATE games SET image = 'assets/images/id=5/frontPage.jpg assets/images/id=5/img1.jpg assets/images/id=5/img2.jpg assets/images/id=5/img3.jpg assets/images/id=5/img4.jpg' where id = 5; 
UPDATE games SET image = 'assets/images/id=6/frontPage.jpg assets/images/id=6/img1.jpg assets/images/id=6/img2.jpg assets/images/id=6/img3.jpg assets/images/id=6/img4.jpg' where id = 6; 
UPDATE games SET image = 'assets/images/id=7/frontPage.jpg assets/images/id=7/img1.jpg assets/images/id=7/img2.jpg assets/images/id=7/img3.jpg assets/images/id=7/img4.jpg' where id = 7; 
UPDATE games SET image = 'assets/images/id=8/frontPage.jpg assets/images/id=8/img1.jpg assets/images/id=8/img2.jpg assets/images/id=8/img3.jpg assets/images/id=8/img4.jpg' where id = 8;
UPDATE games SET image = 'assets/images/id=9/frontPage.jpg assets/images/id=9/img1.jpg assets/images/id=9/img2.jpg assets/images/id=9/img3.jpg assets/images/id=9/img4.jpg' where id = 9; 
UPDATE games SET image = 'assets/images/id=10/frontPage.jpg assets/images/id=10/img1.jpg assets/images/id=10/img2.jpg assets/images/id=10/img3.jpg assets/images/id=10/img4.jpg' where id = 10; 
UPDATE games SET image = 'assets/images/id=11/frontPage.jpg assets/images/id=11/img1.jpg assets/images/id=11/img2.jpg assets/images/id=11/img3.jpg assets/images/id=11/img4.jpg' where id = 11; 
UPDATE games SET image = 'assets/images/id=12/frontPage.jpg assets/images/id=12/img1.jpg assets/images/id=12/img2.jpg assets/images/id=12/img3.jpg assets/images/id=12/img4.jpg' where id = 12; 
UPDATE games SET image = 'assets/images/id=13/frontPage.jpg assets/images/id=13/img1.jpg assets/images/id=13/img2.jpg assets/images/id=13/img3.jpg assets/images/id=13/img4.jpg' where id = 13; 
UPDATE games SET image = 'assets/images/id=14/frontPage.jpg assets/images/id=14/img1.jpg assets/images/id=14/img2.jpg assets/images/id=14/img3.jpg assets/images/id=14/img4.jpg' where id = 14; 
UPDATE games SET image = 'assets/images/id=15/frontPage.jpg assets/images/id=15/img1.jpg assets/images/id=15/img2.jpg assets/images/id=15/img3.jpg assets/images/id=15/img4.jpg' where id = 15; 
UPDATE games SET image = 'assets/images/id=16/frontPage.jpg assets/images/id=16/img1.jpg assets/images/id=16/img2.jpg assets/images/id=16/img3.jpg assets/images/id=16/img4.jpg' where id = 16; 
UPDATE games SET image = 'assets/images/id=17/frontPage.jpg assets/images/id=17/img1.jpg assets/images/id=17/img2.jpg assets/images/id=17/img3.jpg assets/images/id=17/img4.jpg' where id = 17; 
UPDATE games SET image = 'assets/images/id=18/frontPage.jpg assets/images/id=18/img1.jpg assets/images/id=18/img2.jpg assets/images/id=18/img3.jpg assets/images/id=18/img4.jpg' where id = 18; 

ALTER TABLE games ADD description varchar(8000);

UPDATE games SET description = "Sid Meier's Civilization® V: Brave New World is the second expansion pack for Civilization V - the critically acclaimed 2010 PC Game of the Year. This new expansion provides enhanced depth and replayability through the introduction of international trade and a focus on culture and diplomacy. Your influence around the world will be impacted by creating Great Works, choosing an ideology for your people and proposing global resolutions in the World Congress. As you move through the ages of history you will make critical decisions that will impact your relationship with other civilizations." WHERE id=1;
UPDATE games SET description = "Crusader Kings II explores one of the defining periods in world history in an experience crafted by the masters of Grand Strategy. Medieval Europe is brought to life in this epic game of knights, schemes, and thrones..." WHERE id=2;
UPDATE games SET description = "Warcraft III: Reign of Chaos is a high fantasy real-time strategy computer video game developed and published by Blizzard Entertainment released in July 2002" WHERE id=3;
UPDATE games SET description = "Else Heartbreak is an adventure game set in the peculiar city of Dorisburg, a place where bits have replaced atoms. Follow the daily lives of its citizens, fall madly in love, and learn how to modify reality through programming." WHERE id=4;
UPDATE games SET description = "Shadowrun: Dragonfall - Director’s Cut is a standalone release of Harebrained Schemes' critically-acclaimed Dragonfall campaign, which first premiered as a major expansion for Shadowrun Returns. The Director's Cut adds a host of new content and enhancements to the original game: 5 all-new missions, alternate endings, new music, a redesigned interface, team customization options, a revamped combat system, and more - making it the definitive version of this one-of-a-kind cyberpunk RPG experience." WHERE id=5;
UPDATE games SET description = "You've inherited your grandfather's old farm plot in Stardew Valley. Armed with hand-me-down tools and a few coins, you set out to begin your new life. Can you learn to live off the land and turn these overgrown fields into a thriving home? It won't be easy. Ever since Joja Corporation came to town, the old ways of life have all but disappeared. The community center, once the town's most vibrant hub of activity, now lies in shambles. But the valley seems full of opportunity. With a little dedication, you might just be the one to restore Stardew Valley to greatness!" WHERE id=6;
UPDATE games SET description = "Disco Elysium is a multi award-winning open world role playing game. You’re a detective with a unique skill system at your disposal and a whole city block to carve your path across. Interrogate unforgettable characters, crack murders or take bribes. Become a hero or an absolute disaster of a human being." WHERE id=7;
UPDATE games SET description = "RimWorld is a story generator. It’s designed to co-author tragic, twisted, and triumphant stories about imprisoned pirates, desperate colonists, starvation and survival. It works by controlling the “random” events that the world throws at you. Every thunderstorm, pirate raid, and traveling salesman is a card dealt into your story by the AI Storyteller. There are several storytellers to choose from. Randy Random does crazy stuff, Cassandra Classic goes for rising tension, and Phoebe Chillax likes to relax." WHERE id=8;
UPDATE games SET description = "Master the art of destruction and gadgetry in Tom Clancy’s Rainbow Six Siege. Face intense close quarters combat, high lethality, tactical decision making, team play and explosive action within every moment. Experience a new era of fierce firefights and expert strategy born from the rich legacy of past Tom Clancy's Rainbow Six games." WHERE id=9;
UPDATE games SET description = "Travel across Europe as king of the road, a trucker who delivers important cargo across impressive distances! With dozens of cities to explore from the UK, Belgium, Germany, Italy, the Netherlands, Poland, and many more, your endurance, skill and speed will all be pushed to their limits. If you’ve got what it takes to be part of an elite trucking force, get behind the wheel and prove it!" WHERE id=10;
UPDATE games SET description = "Farming Simulator 19 takes the biggest step forward yet with the franchise’s most extensive vehicle roster ever! You’ll take control of vehicles and machines faithfully recreated from all the leading brands in the industry, including for the first time John Deere, the largest agriculture machinery company in the world, Case IH, New Holland, Challenger, Fendt, Massey Ferguson, Valtra, Krone, Deutz-Fahr and many more." WHERE id=11;
UPDATE games SET description = "Train Simulator lets you take control aboard powerful locomotives from around the world, and gives you the choice of what to do, where and when. Step in the cab and master the operation of diesel, electric and steam locomotives as you deliver passengers and freight to their destinations with a packed timetable of real-world services and scenarios. Whatever you love about trains, Train Simulator 2020 lets you take your hobby to the next level." WHERE id=12;
UPDATE games SET description = "Project Zomboid is an open-ended zombie-infested sandbox. It asks one simple question – how will you die?  In the towns of Muldraugh and West Point, survivors must loot houses, build defences and do their utmost to delay their inevitable death day by day. No help is coming – their continued survival relies on their own cunning, luck and ability to evade a relentless horde." WHERE id=13;
UPDATE games SET description = "MAN MEETS MAGIC & MACHINE. The year is 2054. Magic has returned to the world, awakening powerful creatures of myth and legend. Technology merges with flesh and consciousness. Elves, trolls, orks and dwarves walk among us, while ruthless corporations bleed the world dry. You are a shadowrunner - a mercenary living on the fringes of society, in the shadows of massive corporate arcologies, surviving day-by-day on skill and instinct alone. When the powerful or the desperate need a job done, you get it done... by any means necessary." WHERE id=14;
UPDATE games SET description = "HONG KONG. A stable and prosperous port of call in a sea of chaos, warfare, and political turmoil. The Hong Kong Free Enterprise Zone is a land of contradictions - it is one of the most successful centers of business in the Sixth World, and home to one of the world’s most dangerous sprawl sites. A land of bright lights, gleaming towers, and restless spirits where life is cheap and everything is for sale." WHERE id=15;
UPDATE games SET description = "Arguably the most well-known indie game of all time, Cave Story features a completely original storyline wrapped with personality, mystery and hours of fast-paced fun. Cave Story is an action-adventure game from the critically acclaimed independent designer, Daisuke Amaya--or Pixel to his fans. Overflowing with unmatched charm and character, Cave Story takes you into a rare world where a curious race of innocent rabbit-like creatures, called Mimigas, run free." WHERE id=16;
UPDATE games SET description = "An epic adventure in a land of monsters, traps and magic. Journey across the deadly Shamutanti Hills and through the Cityport of Kharé, home to thieves, corrupt nobles and deadly mutants, as you attempt to recover the Crown of Kings. Armed with your sword, and over fifty spells with weird and wonderful effects, embark on a journey of a thousand choices where every one is remembered and will change your story. This is Parts 1 and 2 of a four-part series." WHERE id=17;
UPDATE games SET description = "Dwarf Fortress (officially called Slaves to Armok: God of Blood Chapter II: Dwarf Fortress) is a part construction and management simulation, part roguelike, indie video game created by Tarn and Zach Adams. Freeware and in development since 2002, its first alpha version was released in 2006 and it received attention for being a two-member project surviving solely on donations. The primary game mode is set in a procedurally generated fantasy world in which the player indirectly controls a group of dwarves, and attempts to construct a successful and wealthy fortress. Critics praised its complex, emergent gameplay but had mixed reactions to its difficulty. The game influenced Minecraft and was selected among other games to be featured in the Museum of Modern Art to show the history of video gaming in 2012." WHERE id=18;


INSERT INTO `jobs` VALUES (NULL, "Web Developer - PHP", 40000, "We have an exciting opportunity for a senior-level PHP Developer to join our growing IT department and be the technical lead for one of our projects. You will work closely with a team of developers and help guide the project to meet its objectives. You will have significant involvement in the continual evolution of our bespoke in-house systems and will work collaboratively to improve and develop them for the future. At rp's games, we are working on a number of large and long-scale projects, including developing our own bespoke eCommerce website platform; our full back-office solution for product, stock, pricing and order management; and our internal and robust HR and task management system.");
INSERT INTO `jobs` VALUES (NULL, "Back End Developer Intern", 12000, "We are looking for a Back-End Web Developer responsible for managing the interchange of data between the server and the users. Your primary focus will be development of all server-side logic, definition and maintenance of the central database, and ensuring high performance and responsiveness to requests from the front-end. You will also be responsible for integrating the front-end elements built by your coworkers into the application. A basic understanding of front-end technologies is therefore necessary as well.");
INSERT INTO `jobs` VALUES (NULL, "Front End Developer", 35000, "We are looking for programmers with a keen eye for design for the position of Front End Developer. Front end Developers are responsible for ensuring the alignment of web design and user experience requirements, optimizing web pages for maximum efficiency and maintaining brand consistency across all web pages, among other duties. Front End Developers are required to work in teams alongside Back end Developers, Graphic Designers and User Experience Designers to ensure all elements of web creation are consistent. This requires excellent communication and interpersonal skills.");
