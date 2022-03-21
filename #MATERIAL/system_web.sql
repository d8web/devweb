-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21-Mar-2022 às 23:05
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `system_web`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda`
--

CREATE TABLE `agenda` (
  `id` int(11) NOT NULL,
  `todo` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `agenda`
--

INSERT INTO `agenda` (`id`, `todo`, `date`) VALUES
(1, 'Fazer exercícios', '2022-03-20'),
(2, 'Lavar a louça', '2022-03-20'),
(3, 'Estudar typescript', '2022-03-21'),
(6, 'Ir no mercado', '2022-03-22'),
(8, 'Fazer exercícios de pull ups', '2022-03-21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Tecnologia'),
(5, 'Esportes'),
(6, 'Novidades');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `number` varchar(25) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `type`, `number`, `avatar`) VALUES
(1, 'Cleber', 'dfdev2022@gmail.com\n', 'fisica', '000.000.000-00', '24c1c78b5d493140bf72f3b02d4da9ba.png'),
(6, 'Núcleo expert', 'nucleo@hotmail.com', 'juridica', '44.444.444/4444-44', 'default.jpg'),
(7, 'Camboja LTDA', 'comboja@outlook.com', 'juridica', '88.888.888/8888-88', '96bb8946b04150b0390f37724bcb0b2e.png'),
(8, 'Fernanda', 'fernanda@gmail.com', 'fisica', '444.444.444-44', '1b5120b009ae07fbc2c5bf5f26fb7da3.png'),
(9, 'Roberto', 'daniel.profissional.email@gmail.com', 'fisica', '666.666.666-66', '77fa9506e9831456cd77981bf6eb12c7.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `nameAuthor` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id`, `nameAuthor`, `description`, `image`) VALUES
(1, 'This dev', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla voluptate accusantium nesciunt quaerat placeat, nostrum adipisci deserunt, doloribus impedit amet mollitia porro consectetur voluptatibus, ab sunt autem voluptatum quia? Ipsum debitis corporis tenetur, perspiciatis quod eius eveniet tempora esse in blanditiis soluta porro, accusamus maiores dolores unde aperiam omnis nobis?\r\n\r\nLorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla voluptate accusantium nesciunt quaerat placeat, nostrum adipisci deserunt, doloribus impedit amet mollitia porro consectetur voluptatibus, ab sunt autem voluptatum quia? Ipsum debitis corporis tenetur, perspiciatis quod eius eveniet tempora esse in blanditiis soluta porro, accusamus maiores dolores unde aperiam omnis nobis?', 'd19d48981d00f8b04335655778c644e8.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `financial`
--

CREATE TABLE `financial` (
  `id` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `expired` date NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `financial`
--

INSERT INTO `financial` (`id`, `clientId`, `name`, `value`, `expired`, `status`) VALUES
(1, 1, 'Curso Firebase', '100,00', '2022-03-15', 1),
(2, 1, 'Curso Firebase', '100,00', '2022-03-17', 0),
(3, 1, 'Curso Firebase', '100,00', '2022-03-19', 0),
(4, 1, 'Curso Firebase', '100,00', '2022-03-21', 0),
(5, 1, 'Curso Firebase', '100,00', '2022-03-23', 0),
(6, 6, 'Design', '599,00', '2022-03-20', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `housing`
--

CREATE TABLE `housing` (
  `id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `housing`
--

INSERT INTO `housing` (`id`, `propertyId`, `name`, `price`, `area`) VALUES
(4, 11, 'Casa com Jardim', '345000', 300);

-- --------------------------------------------------------

--
-- Estrutura da tabela `housing_images`
--

CREATE TABLE `housing_images` (
  `id` int(11) NOT NULL,
  `housingId` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `housing_images`
--

INSERT INTO `housing_images` (`id`, `housingId`, `image`) VALUES
(14, 4, '9e8745e33529d5221aa51ad9b941bd24.png'),
(15, 4, '5d3aa8ac741e21cbfd284ddb3637ac53.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `images`
--

INSERT INTO `images` (`id`, `productId`, `url`) VALUES
(1, 1, 'cbf6d6c2287f4a8d329931c9395bce82.png'),
(2, 1, '249e9a60793489c9f3ff74556e905afa.png'),
(3, 1, 'fa7d2aebd17094d38f010f9d4ef6f98b.png'),
(6, 3, 'efb370f843d81f348fc18b8cefa326ce.png'),
(7, 3, 'f40a984066594c9f514ed3cff11202c5.png'),
(12, 4, '0fef56ca1b555453d7f1dc9d81e10e0f.png'),
(13, 4, 'baa16508d6c1ee531c3140637fda7db8.png'),
(15, 5, '083b70d1d0f051f5cf81b5b8f724d4c6.png'),
(16, 5, 'd1f623a460b97f31fc246033080c8df5.png'),
(17, 6, '70e84abc4686e76f2bb9fed982f6cf23.png'),
(18, 6, 'd4b6d93d673c9fde8ee189cdf7dc4369.png'),
(19, 7, '92bb180b2524053e2feb043e50802bc1.png'),
(20, 7, '6b92b3d81dbacb06e3f46d27ed0b4d1b.png'),
(21, 8, 'ab48f390447c739d2c40fd4de603267a.png'),
(22, 8, 'f81efa89b6366fb32bc7d7b5eb5b5ebc.png'),
(24, 9, '321bcd50b4e1b70e08f2d0c75b96b307.png'),
(25, 9, '19f74ffb682ecf8f5420a110f6c71f32.png'),
(26, 9, '8808535537555c5098f332f6f4d9c7a8.png'),
(31, 11, 'f46ffa0c9f08b73cc7d6cc67ab1b7005.png'),
(32, 11, '049911bef9cc59a5729c5c1402788672.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `thumbnail` varchar(255) DEFAULT 'default.jpg',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `authorId` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `notices`
--

INSERT INTO `notices` (`id`, `categoryId`, `thumbnail`, `title`, `slug`, `body`, `authorId`, `created_at`) VALUES
(1, 6, '752872dfbebe6fa7844c6a89f1f46f76.png', 'Conheça as novidades do PHP O que mudou na nova versão 8', 'conheca-as-novidades-do-php-o-que-mudou-na-nova-versao-8', '<p><strong>Nullam quis lacus</strong> in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus.</p>\n<p>Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a. Pellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi.</p>\n<p>Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. <strong>Donec pulvinar</strong>, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna.</p>\n<p>Cras non ipsum pharetra, iaculis mauris vitae, <em>scelerisque lectus. Suspendisse sed tempus ipsum.</em> Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem. Integer non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet.</p>\n<p>Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales. Nullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim.</p>\n<p>Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus. Morbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam.</p>\n<p>Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa. Vestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper.</p>\n<p>Pellentesque tincidunt nisi et leo varius venenatis.</p>', 1, '2022-03-12 15:29:19'),
(2, 4, '7b372fe7079a14c4054bdac958efd734.png', 'Confira as novidades da versão 9 do Laravel', 'confira-as-novidades-da-versao-9-do-laravel', 'Nullam quis lacus in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus. Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a.\r\n\r\nPellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi. Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. Donec pulvinar, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna. Cras non ipsum pharetra, iaculis mauris vitae, scelerisque lectus. Suspendisse sed tempus ipsum. Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem.\r\n\r\nInteger non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet. Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales.\r\n\r\nNullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim. Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus.\r\n\r\nMorbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam. Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa.\r\n\r\nVestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper. Pellentesque tincidunt nisi et leo varius venenatis.', 1, '2022-03-12 17:36:22'),
(4, 6, 'b0744292f59f7d443dec6777ef4f390d.png', 'React Router v6 - O que mudou, veja as novidades da biblioteca', 'react-router-v6-o-que-mudou-veja-as-novidades-da-biblioteca', 'Nullam quis lacus in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus. Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a.\r\n\r\nPellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi. Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. Donec pulvinar, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna. Cras non ipsum pharetra, iaculis mauris vitae, scelerisque lectus. Suspendisse sed tempus ipsum. Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem.\r\n\r\nInteger non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet. Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales.\r\n\r\nNullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim. Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus.\r\n\r\nMorbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam. Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa.\r\n\r\nVestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper. Pellentesque tincidunt nisi et leo varius venenatis.', 1, '2022-03-12 19:06:51'),
(6, 4, 'c82358f30574c86d4deb4db6655c710b.png', 'Linguagem de Programação 2022: veja em quais linguagens você deve ficar de olho!', 'linguagem-de-programacao-2022-veja-em-quais-linguagens-voce-deve-ficar-de-olho!', 'Nullam quis lacus in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus. Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a.\r\n\r\nPellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi. Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. Donec pulvinar, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna. Cras non ipsum pharetra, iaculis mauris vitae, scelerisque lectus. Suspendisse sed tempus ipsum. Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem.\r\n\r\nInteger non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet. Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales.\r\n\r\nNullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim. Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus.\r\n\r\nMorbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam. Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa.\r\n\r\nVestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper. Pellentesque tincidunt nisi et leo varius venenatis.', 1, '2022-03-12 19:45:58'),
(8, 4, '845ada0dc220c4cceeb0712aab3f97aa.png', 'JavaScript se consolida como a linguagem de programação mais popular', 'javascript-se-consolida-como-a-linguagem-de-programacao-mais-popular', '<p>Nullam quis lacus in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus. Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a.</p>\r\n<p>Pellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi. Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. Donec pulvinar, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna. Cras non ipsum pharetra, iaculis mauris vitae, scelerisque lectus. Suspendisse sed tempus ipsum. Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem.</p>\r\n<p>Integer non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet. Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales.</p>\r\n<p>Nullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim. Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus.</p>\r\n<p>Morbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam. Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa.</p>\r\n<p>Vestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper. Pellentesque tincidunt nisi et leo varius venenatis.</p>', 3, '2022-03-13 15:08:46'),
(10, 4, '84355815b4a8cf05fa710d2786b5f5b9.png', 'PYTHON 3.10: CONHEÇA AS NOVIDADES DA NOVA VERSÃO DA LINGUAGEM', 'python-3-10-conheca-as-novidades-da-nova-versao-da-linguagem', '<p>Nullam quis lacus in justo tempus pellentesque eget in lorem. Sed metus nibh, dictum sit amet elit in, egestas convallis erat. Nullam sit amet eleifend orci. Integer scelerisque id velit at gravida. Integer elementum consequat neque sed venenatis. Aliquam ornare nulla non pellentesque pulvinar. Aenean urna velit, hendrerit quis sollicitudin ut, viverra a augue. Integer sit amet urna id nulla tristique ornare faucibus a purus. Morbi ornare sit amet ante ut laoreet. Fusce cursus tincidunt pellentesque. Proin a justo interdum justo vehicula ornare. Cras vulputate id leo nec ultricies. Ut mollis tellus tristique elementum convallis. Donec ante sapien, venenatis feugiat ultricies sed, sollicitudin sed arcu. Nam malesuada, velit quis interdum dapibus, urna quam tincidunt lectus, aliquam sollicitudin dui tortor at lorem. Aliquam condimentum sem lectus, ut iaculis ante scelerisque a.</p>\r\n<p>Pellentesque vel arcu ornare, interdum dolor eu, tincidunt nisi. Maecenas in mollis ex. Proin blandit leo augue, sit amet semper felis rutrum nec. Donec pulvinar, sem eu mollis semper, augue magna porttitor justo, sed elementum urna dui vel ex. Cras luctus vel felis sed iaculis. Vestibulum convallis dignissim tortor, vel finibus sem laoreet eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vel nisi rhoncus, aliquet lacus at, vulputate orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Phasellus euismod placerat turpis, ac gravida risus maximus ut. Vivamus vitae mauris sit amet erat ullamcorper viverra. Praesent eu imperdiet magna. Cras non ipsum pharetra, iaculis mauris vitae, scelerisque lectus. Suspendisse sed tempus ipsum. Etiam eu consectetur ante, eget congue ante. Nam eget volutpat eros, ut lacinia sem.</p>\r\n<p>Integer non urna nec ligula dignissim vulputate. Quisque at odio ut massa lacinia mollis et at quam. Vestibulum id pulvinar tortor. Morbi faucibus sagittis eros at malesuada. Integer malesuada eros nunc, eleifend iaculis mi scelerisque vel. Fusce nibh ante, ultrices non nibh non, placerat egestas felis. Quisque vehicula massa dignissim diam iaculis, nec dignissim sapien fringilla. Nullam consequat elementum eros, ut cursus justo pellentesque sit amet. Quisque nisi odio, congue nec luctus quis, pretium sit amet magna. Integer mollis nibh ut elit sodales euismod. Sed faucibus quam nunc, ac hendrerit ipsum congue interdum. Nunc lobortis, magna eget fermentum posuere, purus ante volutpat odio, eget viverra mauris odio ut diam. Ut egestas fringilla sodales.</p>\r\n<p>Nullam bibendum, urna in semper efficitur, dolor felis consectetur metus, nec venenatis massa eros ut lectus. Nullam et purus nisl. Nunc eget ante augue. In massa sapien, luctus sed augue quis, dignissim condimentum metus. Nunc vestibulum risus vitae euismod luctus. Aenean dolor lorem, pretium nec mauris non, ultrices condimentum enim. Fusce porttitor, felis eget vehicula lobortis, nunc turpis pharetra ipsum, ac tincidunt sapien mauris ac ipsum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ut erat a urna aliquet pretium. Cras elit felis, fringilla eu lacus ac, placerat mattis erat. Praesent dolor tortor, mattis et tempus ac, vehicula at lacus.</p>\r\n<p>Morbi auctor ex quis leo convallis, a gravida odio maximus. Cras rutrum auctor velit at ullamcorper. Maecenas at convallis felis. Pellentesque nec tellus urna. In vitae tempus diam. Praesent auctor erat nec velit viverra, ut condimentum tortor mattis. Donec in vestibulum lacus. Aenean eget imperdiet neque, nec accumsan massa.</p>\r\n<p>Vestibulum et mauris a sapien pretium volutpat eget semper dui. Donec tempus fermentum erat eu iaculis. Nulla facilisi. Duis nunc lectus, posuere a sapien ut, scelerisque ultrices nisi. Donec sem nibh, dignissim sit amet libero eu, mollis pretium leo. In in convallis risus. Nulla id eros est. Sed ultricies enim sit amet finibus maximus. Nullam sit amet odio non est mattis fermentum vitae a magna. Cras nec erat enim. Vivamus imperdiet urna est, sed tempus libero porttitor non. Aliquam lacinia viverra nulla at semper. Pellentesque tincidunt nisi et leo varius venenatis.</p>', 3, '2022-03-13 16:12:00'),
(11, 6, '7d7ed9e4324429c5772c4feab110c748.png', 'Quer se tornar um desenvolvedor front-end? Confira essas dicas', 'quer-se-tornar-um-desenvolvedor-front-end?-confira-essas-dicas', '<p>Existem muitas especialidades que um desenvolvedor pode se focar em obter para se destacar no mercado de trabalho. E, entre as v&aacute;rias op&ccedil;&otilde;es, muito se fala de<em>&nbsp;front-end</em>, com foco no desenvolvimento de solu&ccedil;&otilde;es vis&iacute;veis para os usu&aacute;rios.</p>\r\n<ul style=\"list-style-type: none;\">\r\n<li style=\"list-style-type: none;\"><a href=\"https://canaltech.com.br/mercado/10-linguagens-de-programacao-que-o-mercado-vai-exigir-em-2022-204423/\">10 linguagens de programa&ccedil;&atilde;o que o mercado vai exigir em 2022</a></li>\r\n<li style=\"list-style-type: none;\"><a href=\"https://canaltech.com.br/mercado/10-linguagens-de-programacao-mais-indicadas-para-estudantes-em-2022-208264/\">10 linguagens de programa&ccedil;&atilde;o mais indicadas para estudantes em 2022</a></li>\r\n</ul>\r\n<p>Com a popularidade da internet e dos servi&ccedil;os oferecidos por ela, acaba que o&nbsp;<em>front-end</em>, principalmente para o desenvolvimento de aplica&ccedil;&otilde;es web, &eacute; uma &aacute;rea que muitos profissionais desejam trabalhar, enxergando como um caminho cheio de oportunidades.</p>\r\n<p>Mas o que desenvolvedores devem aprender para entrar nessa &aacute;rea em espec&iacute;fico? A Adalov, ag&ecirc;ncia de intelig&ecirc;ncia digital, compartilhou com o&nbsp;<strong>Canaltech</strong>&nbsp;o que ela acha fundamental para novatos no&nbsp;<em>front-end</em>&nbsp;aprenderem, possibilitando que eles j&aacute; tenham caminhos para seguir na &aacute;rea.</p>\r\n<section>\r\n<p>Quer ficar por dentro das melhores not&iacute;cias de tecnologia do dia?&nbsp;<strong>Acesse e se inscreva no nosso novo canal no youtube, o Canaltech News.</strong>&nbsp;Todos os dias um resumo das principais not&iacute;cias do mundo tech para voc&ecirc;!</p>\r\n</section>\r\n<h2>Compet&ecirc;ncias importantes para desenvolvedores&nbsp;<em>front-end</em></h2>\r\n<h3>HTML</h3>\r\n<figure><img style=\"height: 1157px;\" src=\"https://t.ctcdn.com.br/nqvp2bas5Csaj3h0OPtQ1yWzpN4=/1024x0/smart/filters:format(webp)/i555622.jpeg\" alt=\"\" width=\"1738\" data-ivi=\"iu6g\" />\r\n<figcaption><em>HTML &eacute; o primeiro passo no processo para se tornar um desenvolvedor front-end. (Imagem: Reprodu&ccedil;&atilde;o/Pixabay/Pexels)</em></figcaption>\r\n</figure>\r\n<p>Independente do seu foco, para se tornar<em>&nbsp;front-en</em>d, &eacute; preciso come&ccedil;ar pelo HTML. &Eacute; ele quem vai estruturar todo o conte&uacute;do de um site; ele &eacute; a base para o Desenvolvimento Web.</p>\r\n<div>&nbsp;</div>\r\n<p>&ldquo;E antes de se deixar levar pela famosa negativa de que &lsquo;HTML n&atilde;o &eacute; uma linguagem de programa&ccedil;&atilde;o&rsquo;, &eacute; preciso aprender com ela. Estud&aacute;-la para compreender o que de melhor ela pode oferecer. Entender sua sintaxe, a melhor forma de escrev&ecirc;-la, procurar conte&uacute;do nas comunidades online. E, como parte de qualquer aprendizado, pratic&aacute;-la. Sem isso, n&atilde;o existe a consolida&ccedil;&atilde;o do seu aprendizado, algo essencial para o crescimento&rdquo;, explica Tiago Martins, s&oacute;cio-fundador da Adalov.</p>\r\n<h3>CSS</h3>\r\n<p>CSS significa Cascading Style Sheets(Folhas de Estilo em Cascata, em tradu&ccedil;&atilde;o livre). Para muitos, ele serve como complemento do HTML, para deixar o projeto mais organizado e os estilos leg&iacute;veis.</p>\r\n<p>&ldquo;E &eacute; aqui que as coisas come&ccedil;am a complicar, pois voc&ecirc; trabalhar&aacute; com o estilo da p&aacute;gina, ponto que pode ser um dos mais desafiadores: deixar algo bonito e da forma como foi idealizado&rdquo;, explica Erik Vandelei, tamb&eacute;m s&oacute;cio da Adalov. Martins complementa: &ldquo;no CSS, voc&ecirc; vai come&ccedil;ar a se deparar com algumas regras do desenvolvimento, ent&atilde;o vai precisar entender o que cada atributo faz e como utiliz&aacute;-los da forma correta. Com ele, voc&ecirc; conseguir&aacute; deixar o elemento de uma forma mais agrad&aacute;vel para o usu&aacute;rio, alterando cor, tamanho, lugar e atribuindo anima&ccedil;&otilde;es tamb&eacute;m&rdquo;.</p>\r\n<h3>Javascript</h3>\r\n<figure><img style=\"height: 883px;\" src=\"https://t.ctcdn.com.br/a44PHMn86imv0SNXX9mw4QyIEmo=/660x0/smart/filters:format(webp)/i550288.jpeg\" alt=\"\" width=\"1713\" data-ivi=\"irpp\" />\r\n<figcaption><em>Javascript &eacute; uma importante compet&ecirc;ncia para desenvolvedores front-end. (Imagem: Reprodu&ccedil;&atilde;o/Wikimedia Communs)</em></figcaption>\r\n</figure>\r\n<p>O Javascript, por mais que seja uma linguagem utilizada para web, necessita de um entendimento l&oacute;gico de programa&ccedil;&atilde;o. &ldquo;Sugerimos a estudar essa linguagem somente quando considerar que possui um entendimento mais s&oacute;lido em HTML e CSS&rdquo;, orienta Martins.</p>\r\n<p>As funcionalidades do Javascript s&atilde;o imensas, e todo bom desenvolvedor<em>&nbsp;front-end</em>&nbsp;no mercado tem familiaridade com essa linguagem, fazendo com que o mercado classifique essa compet&ecirc;ncia como algo obrigat&oacute;rio nessa &aacute;rea.</p>', 1, '2022-03-14 15:00:57'),
(13, 4, 'b96b8bf71b50edb7a9578660a35f0c4a.png', 'CSS3 conheça a mais nova versão das famosas Cascading Style Sheets (ou simplesmente CSS)', 'css3-conheca-a-mais-nova-versao-das-famosas-cascading-style-sheets-(ou-simplesmente-css)', '<p><strong>CSS3</strong>&nbsp;&eacute; a terceira mais nova vers&atilde;o das famosas&nbsp;<a title=\"Cascading Style Sheets\" href=\"https://pt.wikipedia.org/wiki/Cascading_Style_Sheets\">Cascading Style Sheets</a>&nbsp;(ou simplesmente CSS), pela qual se define estilos para um projeto&nbsp;<a title=\"Web\" href=\"https://pt.wikipedia.org/wiki/Web\">web</a>&nbsp;(p&aacute;gina de internet). Com efeitos de transi&ccedil;&atilde;o, imagem, imagem de fundo/background e outros, pode-se criar estilos &uacute;nicos para seus projetos web, alterando diversos aspectos de design no&nbsp;<a title=\"Layout\" href=\"https://pt.wikipedia.org/wiki/Layout\">layout</a>&nbsp;da p&aacute;gina.</p>\r\n<p>A principal fun&ccedil;&atilde;o do CSS3 &eacute; abolir as imagens de plano/Background de fundo, bordas arredondadas, apresentar transi&ccedil;&otilde;es e efeitos para criar anima&ccedil;&otilde;es de v&aacute;rios tipos, como um simples rel&oacute;gio de ponteiros.</p>\r\n<p>Isso se deve aos novos browsers/navegadores que est&atilde;o chegando com suporte &agrave; essa linguagem, como o&nbsp;<a title=\"Google Chrome\" href=\"https://pt.wikipedia.org/wiki/Google_Chrome\">Google Chrome</a>,&nbsp;<a title=\"Opera\" href=\"https://pt.wikipedia.org/wiki/Opera\">Opera</a>,&nbsp;<a title=\"Internet Explorer\" href=\"https://pt.wikipedia.org/wiki/Internet_Explorer\">Internet Explorer</a>&nbsp;9,&nbsp;<a title=\"Safari\" href=\"https://pt.wikipedia.org/wiki/Safari\">Safari</a>&nbsp;e&nbsp;<a title=\"Mozilla Firefox\" href=\"https://pt.wikipedia.org/wiki/Mozilla_Firefox\">Mozilla Firefox</a>. Assim, o CSS3 facilitar&aacute; o trabalho dos profissionais de front-end e tamb&eacute;m a utiliza&ccedil;&atilde;o de sites pelos usu&aacute;rios.</p>', 1, '2022-03-18 15:24:52');

-- --------------------------------------------------------

--
-- Estrutura da tabela `notice_comments`
--

CREATE TABLE `notice_comments` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `noticeId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `notice_comments`
--

INSERT INTO `notice_comments` (`id`, `userId`, `noticeId`, `comment`, `created_at`) VALUES
(1, 1, 11, 'Quero me tornar um desenvolvedor! Obrigado pelo conteúdo', '2022-03-21'),
(3, 1, 11, 'Aprendi muito com este conteúdo...', '2022-03-21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `online`
--

CREATE TABLE `online` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `lastaction` datetime NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `weight` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `width`, `height`, `length`, `weight`, `stock`) VALUES
(1, 'Xbox one S', 'Apresentando o novo Xbox One S. Versão de 1 Tb 40% menor. 1 Tb de armazenamento. Fonte de alimentação interna. Experimente os melhores jogos, incluindo clássicos do Xbox 360, em um console 40% menor. Não se engane com o tamanho: com uma fonte de alimentação interna e até 500 Gb de armazenamento interno, o Xbox One S é o Xbox mais avançado que já existiu. Alto alcance dinâmico Experimente cores mais vivas e luminosas em jogos como o Gears of War 4 e o Forza Horizon 3. Com uma taxa de contraste maior entre claro e escuro, a tecnologia de alto alcance dinâmico revela a verdadeira profundidade visual dos jogos. Blu-ray e Streaming Ultra HD 4K Com resolução quatro vezes maior que o HD padrão, o Ultra HD 4K oferece o vídeo mais nítido e realístico possível. Faça streaming de conteúdo 4K na Netflix e na Amazon Video e assista a filmes em Blu-ray Ultra HD com uma impressionante fidelidade visual de alto alcance dinâmico. IR Blaster Configure seu Xbox One S para ligar outros dispositivos, como TV, receptor de áudio/vídeo, receptor de cabo/satélite. Se você estiver jogando ou assistindo a um filme, o IR Blaster integrado iniciará a ação com mais rapidez, permitindo que você se esqueça dos controles remotos. Controle Sem Fio Xbox Experimente o maior conforto do novo Controle Sem Fio Xbox, que apresenta um design mais elegante e anatômico. Tenha até o dobro do alcance sem fio. Mantenha o alvo com textura antiderrapante. E, com a tecnologia Bluetooth, divirta-se com seus jogos favoritos em computadores, tablets e telefones Windows 10.1.', '2399', 44, 12, 30, '4kg', 10),
(3, 'Xbox one S preto', 'Apresentando o novo Xbox One S. Versão de 1 Tb 40% menor. 1 Tb de armazenamento. Fonte de alimentação interna. Experimente os melhores jogos, incluindo clássicos do Xbox 360, em um console 40% menor. Não se engane com o tamanho: com uma fonte de alimentação interna e até 500 Gb de armazenamento interno, o Xbox One S é o Xbox mais avançado que já existiu. Alto alcance dinâmico Experimente cores mais vivas e luminosas em jogos como o Gears of War 4 e o Forza Horizon 3. Com uma taxa de contraste maior entre claro e escuro, a tecnologia de alto alcance dinâmico revela a verdadeira profundidade visual dos jogos. Blu-ray e Streaming Ultra HD 4K Com resolução quatro vezes maior que o HD padrão, o Ultra HD 4K oferece o vídeo mais nítido e realístico possível. Faça streaming de conteúdo 4K na Netflix e na Amazon Video e assista a filmes em Blu-ray Ultra HD com uma impressionante fidelidade visual de alto alcance dinâmico. IR Blaster Configure seu Xbox One S para ligar outros dispositivos, como TV, receptor de áudio/vídeo, receptor de cabo/satélite. Se você estiver jogando ou assistindo a um filme, o IR Blaster integrado iniciará a ação com mais rapidez, permitindo que você se esqueça dos controles remotos. Controle Sem Fio Xbox Experimente o maior conforto do novo Controle Sem Fio Xbox, que apresenta um design mais elegante e anatômico. Tenha até o dobro do alcance sem fio. Mantenha o alvo com textura antiderrapante. E, com a tecnologia Bluetooth, divirta-se com seus jogos favoritos em computadores, tablets e telefones Windows 10.1.', '2899', 45, 14, 38, '3.5kg', 10),
(4, 'Camera Canon', 'A Canon é um sistema de autofoco utilizado pela Canon nas câmeras fotográficas de filme 35 mm e DSLR, introduzido no mercado em 1987. As Canon possuem mecanismo de foco e de abertura na objetiva comandados eletronicamente pelo corpo.', '2599', 10, 15, 19, '475g', 10),
(5, 'Sony Playstation 4 1Tb', 'Quem já estava acostumado ao PS4 pode ficar tranquilo, o console na versão Slim manteve o processador de 8 núcleos e boa placa de vídeo, responsáveis por rodar ótimos gráficos de diversos jogos. Se você é daqueles que salva diversos jogos ao mesmo tempo em longas fases ou campanhas, saiba que a capacidade de armazenamento do PS4 Slim trouxe 1TB disponível. Tamanho suficiente também para ir além dos games e guardar fotos, vídeos ou músicas sem sustos. Por falar em espaço, você tem à disposição 1 entrada HDMI e 1 USB para transferir seus arquivos. E ainda pode usar a rede Wi-Fi ou o Bluetooth 4.0.', '6982', 40, 16, 40, '3.8kg', 10),
(6, 'Caixa de som JBL', 'A caixa de som Flip 5 da JBL será sua companheira para todos os usos, para todos os climas. Como é um produto portátil você pode levar a festa para qualquer lugar. Conta com certificação IPX7 à prova d\'água, assim você não precisa mais se preocupar com chuva, nem com respingos. A transmissão sem fio via Bluetooth permite um som estéreo impressionante e com muita qualidade. Feita com materiais para o seu estilo de vida, garantindo maior durabilidade ao produto. Você pode se divertir à vontade! Com 20W de potência você pode reproduzir a sua playlist favorita de maneira surpreendentemente poderosa. É alimentada por uma bateria recarregável de 4.800 mAh, permitindo até 12 horas de reprodução.', '760', 18, 12, 16, '540g', 10),
(7, 'Fone de ouvido JBL', 'Os fones de ouvido JBL Tune 510BT oferecem o potente som JBL Pure Bass sem fios. Fáceis de usar, esses fones de ouvido proporcionam até 40 horas de puro prazer e 2 horas extras de bateria com apenas 5 minutos de carga, via um cabo carregador USB-C. E se você receber uma chamada enquanto estiver assistindo a um vídeo em outro dispositivo, o JBL Tune 510BT alterna facilmente para o seu celular. Com design confortável e Bluetooth 5.0, os fones de ouvido JBL Tune 510BT também permitem conectar à Siri ou ao Google sem usar seu dispositivo móvel. Disponíveis em várias cores vibrantes e dobráveis para fácil portabilidade, os fones de ouvido JBL Tune 510BT são a solução grab ‘n go que o ajuda a injetar música em todos os aspectos de sua vida agitada.', '258', 22, 18, 16, '220g', 10),
(8, 'Pc gamer', 'O PC Gamer Fnew vem completo e pronto para os seus jogos. Pensado especialmente para a nova geração de gamers, ele é perfeito para quem está começando nesse universo e deseja investir em uma opção com ótimo custo-benefício.', '3437', 0, 58, 54, '5.4kg', 10),
(9, 'Fone de ouvido JBL', 'Os fones de ouvido JBL Tune 510BT oferecem o potente som JBL Pure Bass sem fios. Fáceis de usar, esses fones de ouvido proporcionam até 40 horas de puro prazer e 2 horas extras de bateria com apenas 5 minutos de carga, via um cabo carregador USB-C. E se você receber uma chamada enquanto estiver assistindo a um vídeo em outro dispositivo, o JBL Tune 510BT alterna facilmente para o seu celular. Com design confortável e Bluetooth 5.0, os fones de ouvido JBL Tune 510BT também permitem conectar à Siri ou ao Google sem usar seu dispositivo móvel. Disponíveis em várias cores vibrantes e dobráveis para fácil portabilidade, os fones de ouvido JBL Tune 510BT são a solução grab ‘n go que o ajuda a injetar música em todos os aspectos de sua vida agitada.', '245', 22, 18, 17, '220g', 10),
(11, 'Xbox one X', 'Conecte-se e jogue com amigos e familiares no Xbox Live, a rede de jogos mais rápida e confiável. Encontre amigos, rivais e companheiros de equipe na melhor comunidade global de jogos. O Xbox Live é a rede multijogador mais avançada e oferece jogabilidade estável e downloads rápidos. Compita, conecte-se e compartilhe em várias plataformas com jogadores no Xbox One e no Windows 10. Obtenha de dois a quatro jogos grátis por mês com o Xbox Live Gold.', '5000', 40, 18, 38, '4.2kg', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `properties`
--

INSERT INTO `properties` (`id`, `name`, `type`, `price`, `image`) VALUES
(3, 'Apartamento Z', 'residential', '378000', '103ef2f7a593ed122feb164869d25613.png'),
(4, 'Casa na montanha', 'residential', '678000', 'ce9a65cfed33e3ffaa7c7a1e4b7da555.png'),
(8, 'Casa top', 'residential', '390578', 'b14b80294bf2b085ef10526c0f302bb5.png'),
(9, 'Apartamento Leblon', 'residential', '1178569', '238d7cc5d55d3ff53354e62140e2eaad.png'),
(11, 'Condomínio Z', 'commertial', '1345760560', 'df414cebcd91807f91bcd1ed496df553.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `services`
--

INSERT INTO `services` (`id`, `title`, `icon`, `body`) VALUES
(1, 'Páginas web', 'fab fa-html5', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!'),
(2, 'Sistemas', 'fas fa-sitemap', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!'),
(4, 'Banco de dados', 'fas fa-server', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!'),
(5, 'Design', 'fas fa-palette', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!'),
(6, 'Aplicativos', 'fas fa-mobile', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!'),
(7, 'Manutenção', 'fas fa-cogs', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam debitis voluptatem alias rerum eaque veritatis mollitia necessitatibus asperiores porro? At, maxime? Illum, cumque!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `slides`
--

INSERT INTO `slides` (`id`, `url`) VALUES
(6, '4ff473f09880b6f9433a645b581fdee7.png'),
(7, '05bcc57db732c0c43d6be6e937ef2b0f.png'),
(8, '3eb3bc365ec3f534da770da69625ebfd.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `author` varchar(244) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `testimonials`
--

INSERT INTO `testimonials` (`id`, `author`, `body`) VALUES
(1, 'Jobson', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(2, 'Ramiro', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(3, 'Cleide', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(4, 'Vander', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(5, 'Lúcia', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(6, 'Rogéria', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(12, 'Paula', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.'),
(14, 'Clodoaldo', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam quaerat est atque nesciunt soluta consectetur porro veritatis. Ipsa, consequuntur necessitatibus! Exercitationem ut repudiandae reprehenderit eveniet nulla itaque dolore facere placeat explicabo illo. Quis mollitia ipsa nulla possimus. Temporibus, vero placeat.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.jpg',
  `token` varchar(255) DEFAULT NULL,
  `adminField` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `token`, `adminField`) VALUES
(1, 'Daniel', 'admin@admin.com', '$2y$10$/mvrOK2S9ZZScXJ8JHydGOddP2YJD8bpB7xje6Y1iqhUuvoa2l1Hu', '3b6da4e21a78ec3b67b5b4197731a6ea.png', '9a6b9884bb3b920454cd9f2b4800897a', 2),
(2, 'Luana', 'luana@gmail.com', '$2y$10$bScZ8TdODSN/r8SCZOtpo.oxX8R28/IbwTJCAMY8nk4ln76xMZWgO', 'avatar.jpg', 'acd5d0393d797a4e08dd1a0eef892efc', 0),
(3, 'Janaína', 'janaina@gmail.com', '$2y$10$yB5p2OeJzgWUxr3OMDbzOOFJZ9uOPESdrVexvC6xRFU1CRB2kQ7I6', '754b546566bfa159e443aaa8775c6389.png', 'de21971e3b2d36a13166e95153549e72', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_site`
--

CREATE TABLE `users_site` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users_site`
--

INSERT INTO `users_site` (`id`, `name`, `email`, `password`, `avatar`, `token`) VALUES
(1, 'Romildo', 'romildo@gmail.com', '$2y$10$yB5p2OeJzgWUxr3OMDbzOOFJZ9uOPESdrVexvC6xRFU1CRB2kQ7I6', 'default.jpg', '5c3eb01e2b16d291175e0741909667ab');

-- --------------------------------------------------------

--
-- Estrutura da tabela `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `visitday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `visits`
--

INSERT INTO `visits` (`id`, `ip`, `visitday`) VALUES
(1, '::1', '2022-03-10'),
(2, '::1', '2022-03-11'),
(3, '::1', '2022-03-12'),
(4, '::1', '2022-03-17'),
(5, '::1', '2022-03-18'),
(6, '::1', '2022-03-21'),
(7, '::1', '2022-03-21');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `financial`
--
ALTER TABLE `financial`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `housing`
--
ALTER TABLE `housing`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `housing_images`
--
ALTER TABLE `housing_images`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `notice_comments`
--
ALTER TABLE `notice_comments`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `online`
--
ALTER TABLE `online`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users_site`
--
ALTER TABLE `users_site`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `financial`
--
ALTER TABLE `financial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `housing`
--
ALTER TABLE `housing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `housing_images`
--
ALTER TABLE `housing_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `notice_comments`
--
ALTER TABLE `notice_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `online`
--
ALTER TABLE `online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users_site`
--
ALTER TABLE `users_site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
