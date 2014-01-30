-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: flexio
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `layout`
--

CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_html` text NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `content_type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `name`, `content`, `content_html`, `create_date`, `update_date`, `create_user_id`, `update_user_id`, `content_type`) VALUES
(1, 'default', '', '<!DOCTYPE html>\n<html lang="en">\n  <head>\n    <meta charset="utf-8">\n    <meta http-equiv="X-UA-Compatible" content="IE=edge">\n    <meta name="viewport" content="width=device-width, initial-scale=1.0">\n    <meta name="description" content="">\n    <meta name="author" content="">\n    <link rel="shortcut icon" href="http://getbootstrap.com/docs-assets/ico/favicon.png">\n\n    <title>Signin Template for Bootstrap</title>\n\n    <!-- Bootstrap core CSS -->\n    <link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">\n\n    <link href="<?php echo Flexio::app()->getAssetUrl(''css/app.css''); ?>" rel="stylesheet" />\n\n    <!-- Custom styles for this template -->\n    <?php if (! empty($this->css)): ?> \n    <?php foreach ($this->css as $css): ?>\n    <link href="<?php echo $css; ?>" rel="stylesheet" />\n	<?php endforeach; ?>\n	<?php endif; ?>\n    \n    <!-- Just for debugging purposes. Don''t actually copy this line! -->\n    <!--[if lt IE 9]><script src="http://getbootstrap.com/docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->\n\n    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->\n    <!--[if lt IE 9]>\n      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>\n      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>\n    <![endif]-->\n  </head>\n\n  <body>\n\n  	<?php if ($this->isNavEnabled === true): ?>\n  	<div class="navbar navbar-default navbar-static-top" role="navigation">\n	  <div class="container">\n	    <div class="navbar-header">\n	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">\n	        <span class="sr-only">Toggle navigation</span>\n	        <span class="icon-bar"></span>\n	        <span class="icon-bar"></span>\n	        <span class="icon-bar"></span>\n	      </button>\n	      <a class="navbar-brand" href="<?php echo Flexio::app()->createUrl(Flexio::app()->defaultRoute); ?>"><?php echo Flexio::app()->name; ?></a>\n	    </div>\n	    <div class="navbar-collapse collapse">\n			<?php echo Flexio::app()->nav->render(); ?>\n\n			<ul class="nav navbar-nav navbar-right">\n				<li><a href="<?php echo Flexio::app()->createUrl(array(''controller''=>''user'', ''action''=>''edit'', ''id''=>Flexio::app()->auth->getId())); ?>"><?php echo Flexio::app()->auth->getUserName(); ?></a></li>\n				<li><a href="<?php echo Flexio::app()->createUrl(array(''controller''=>''auth'', ''action''=>''logout'')); ?>">Logout</a></li>\n			</ul>\n	    </div><!--/.nav-collapse -->\n	  </div>\n	</div>\n	<?php endif; ?>\n\n    <div class="container">\n\n    	<?php $success=Flexio::app()->flash->get(''success''); ?>\n    	<?php $error=Flexio::app()->flash->get(''error''); ?>\n\n    	<?php if ($success !== null): ?>\n    	<div class="alert alert-success">\n			<?php echo $success; ?>\n		</div>\n    	<?php endif; ?>\n\n    	<?php if ($error !== null): ?>\n    	<div class="alert alert-danger">\n			<?php echo $error; ?>\n		</div>\n    	<?php endif; ?>\n\n		<?php echo $this->content; ?>\n\n    </div> <!-- /container -->\n\n    <!-- Bootstrap core JavaScript\n    ================================================== -->\n    <!-- Placed at the end of the document so the pages load faster -->\n    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>\n    <script src="//cdnjs.cloudflare.com/ajax/libs/parsley.js/1.2.2/parsley.min.js"></script>\n    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js"></script>\n    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ext-emmet.js"></script>\n    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/mode-php.js"></script>\n    <script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>\n    <script src="<?php echo Flexio::app()->getAssetUrl(''js/app.js''); ?>"></script>\n  </body>\n</html>', '2014-01-28 22:30:39', '2014-01-28 00:00:00', 1, 1, '');

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `path` varchar(1000) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL,
  `update_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'Page 1','/',NULL,NULL,NULL),(2,'Page 2','/myslug','myslug',NULL,NULL),(3,'Page 3','/myslug.json','myslug.json',NULL,NULL),(4,'Page 4','/admin','admin',NULL,NULL),(5,'Page 4','/',NULL,NULL,NULL),(6,'Page 4','/',NULL,NULL,NULL),(7,'Page 4','/',NULL,NULL,NULL),(8,'Page 4','/',NULL,NULL,NULL),(9,'Page 4','/',NULL,NULL,NULL),(10,'Page 4','/',NULL,NULL,NULL),(11,'Page 4','/',NULL,NULL,NULL),(12,'Page 4','/',NULL,NULL,NULL),(13,'Page 4','/',NULL,NULL,NULL),(14,'Page 4','/',NULL,NULL,NULL),(15,'Page 4','/',NULL,NULL,NULL),(16,'Page 4','/',NULL,NULL,NULL),(17,'Page 4','/',NULL,NULL,NULL),(18,'Page 4','/',NULL,NULL,NULL),(19,'Page 4','/',NULL,NULL,NULL),(20,'Page 4','/',NULL,NULL,NULL),(21,'Page 4','/',NULL,NULL,NULL),(22,'Page 4','/',NULL,NULL,NULL),(23,'Page 4','/',NULL,NULL,NULL),(24,'Page 4','/',NULL,NULL,NULL);
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_content`
--

DROP TABLE IF EXISTS `page_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_content`
--

LOCK TABLES `page_content` WRITE;
/*!40000 ALTER TABLE `page_content` DISABLE KEYS */;
INSERT INTO `page_content` VALUES (1,'abba','Content of body.'),(2,'body','Content of body.'),(3,'body','Content of body.'),(4,'body2','Content2'),(5,'body2','Content2'),(6,'body2','Content2'),(7,'body2','Content2'),(8,NULL,NULL),(9,NULL,NULL),(10,'abba',NULL),(11,'abba',NULL),(12,'abba',NULL);
/*!40000 ALTER TABLE `page_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plugin`
--

DROP TABLE IF EXISTS `plugin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `config` text,
  `is_active` int(11) DEFAULT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plugin`
--

LOCK TABLES `plugin` WRITE;
/*!40000 ALTER TABLE `plugin` DISABLE KEYS */;
INSERT INTO `plugin` VALUES (1,'PageContent','{\"name\":\"value\"}',1,'/'),(2,'PageNotFound','{\"name\":\"value\"}',1,'/'),(3,'Admin','{\"name\":\"value\"}',1,'/admin'),(4,'Api','{\"name\":\"value\"}',1,'/'),(5,'PageContent','{\"name\":\"value\"}',0,'/'),(6,'PageContent','{\"name\":\"value\"}',0,'/'),(7,'PageContent','{\"name\":\"value\"}',0,'/');
/*!40000 ALTER TABLE `plugin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `permissions` varchar(1000) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997','administrator,developer,editor','2014-01-08 18:11:08','2014-01-08 18:11:08',NULL,'Administrator','flexio@mailinator.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-01-08 18:11:43
