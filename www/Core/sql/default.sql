-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 12 sep. 2021 à 16:32
-- Version du serveur : 10.3.30-MariaDB
-- Version de PHP : 7.4.21
--
--
-- --------------------------------------------------------
--
-- Structure de la table `page`
--
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `url` text NOT NULL,
  `content` longtext NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
-- Déchargement des données de la table `page`
--
-- --------------------------------------------------------
--
-- Structure de la table `user`
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` text NOT NULL,
  `verificationCode` varchar(32) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `createdAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
--
-- Index pour les tables déchargées
--
--
-- Index pour la table `page`
--
ALTER TABLE
  `page`
ADD
  PRIMARY KEY (`id`);
--
  -- Index pour la table `user`
  --
ALTER TABLE
  `user`
ADD
  PRIMARY KEY (`id`);