-- Base de données :  `cret`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL,
   PRIMARY KEY(`id`)
);


